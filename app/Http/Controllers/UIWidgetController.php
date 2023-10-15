<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Validator;

class UIWidgetController extends Controller
{
    //Просмотр страницы
    function WidgetView($widgetpath = null, Request $request){
        if(!is_null($widgetpath)){
            if(DB::table('uiwidget')->select('id')->where([['path','=',$widgetpath]])->exists()){
                $uiwidgetinfo = DB::table('uiwidget')->select('assembly','visiblename')->where([['path','=',$widgetpath]])->get()[0];
                $inputData = $request->input();
                if(isset($inputData["isEmulation"])){
                    if($inputData["isEmulation"] == 1){
                        if(file_exists(resource_path()."/compiledUserUIWidgets/".$uiwidgetinfo->assembly.'_preview.php')){
                            return view('ese/UIWidgetPreview')->with("visiblename",$uiwidgetinfo->visiblename)->with("assembly",$uiwidgetinfo->assembly.'_preview');
                        } else {
                            return view('ese/error')->with("stacktrace","Сборка пользовательской страницы с названием ".$uiwidgetinfo->assembly." с меткой _preview не найдена в файловой системе");
                        }
                    } else {
                        if(file_exists(resource_path()."/compiledUserUIWidgets/".$uiwidgetinfo->assembly.'.php')){
                            return view('ese/UIWidgetPreview')->with("visiblename",$uiwidgetinfo->visiblename)->with("assembly",$uiwidgetinfo->assembly);
                        } else {
                            return view('ese/error')->with("stacktrace","Сборка пользовательского виджета с названием ".$uiwidgetinfo->assembly." не найдена в файловой системе");
                        }
                    }
                } else {
                    if(file_exists(resource_path()."/compiledUserUIWidgets/".$uiwidgetinfo->assembly.'.php')){
                        return view('ese/UIWidgetPreview')->with("visiblename",$uiwidgetinfo->visiblename)->with("assembly",$uiwidgetinfo->assembly);
                    } else {
                        return view('ese/error')->with("stacktrace","Сборка пользовательского виджета с названием ".$uiwidgetinfo->assembly." не найдена в файловой системе");
                    }
                }
                
        
            } else {
                return view('ese/error')->with("stacktrace","Виджет не найден");
            }
        } else {
            return view('ese/error')->with("stacktrace","Виджет не найден");
        }
    }

    function CompileWidgetSource(Request $request){
        $inputData = $request->input();
        $validRules = [
           'viewCode' => 'required',
           'usingsCode' => 'required',
           'scenariousCode' => 'required',
           'variableCode' => 'required',
           'assemblyname' => 'required',
           'isEmulation' => 'required|boolean'
        ];
        $validator = Validator::make($inputData,$validRules);
        if($validator -> passes()){
            //Не обращайте внимание, что код весь уехал налево, это необходимо, для того что бы в итоговом файле все выглядело чики-пуки
            $sourceCode = '<?php
/* EseAPP custom Widgets */

/*Для корректной работы, ни в коем случае не изменяйте исходный код находящийся
вне тегов ScenarioZone, EndScenarioZone,ViewZone, EndViewZone, UseZone, EndUseZone, VariableZone, EndVariableZone
*/
/*----------UseZone----------*/
'.$inputData["usingsCode"].'
/*----------EndUseZone----------*/
class Context_'.$inputData["assemblyname"].' extends WidgetContextCore{
/*----------VariableZone----------*/
'.$inputData["variableCode"].'
/*----------EndVariableZone----------*/
/*----------ScenarioZone----------*/
'.$inputData["scenariousCode"].'
/*----------EndScenarioZone----------*/
}
?>
<?php
$_context = new Context_'.$inputData["assemblyname"].'();
$_context->OnPreload();
?>
<!----------ViewZone---------->
'.$inputData["viewCode"].'
<!----------EndViewZone---------->
<?php
$_context->OnLoaded();
?>';
            
            $fpath = "";
            if($inputData["isEmulation"] == false){
                $fpath = resource_path()."/compiledUserUIWidgets/".$inputData["assemblyname"].'.php';
            } else {
                $fpath = resource_path()."/compiledUserUIWidgets/".$inputData["assemblyname"].'_preview.php';
            }
            $assemblyFile = fopen($fpath, "w");
            file_put_contents($fpath, $sourceCode);
            fclose($assemblyFile);
            return response() -> json(["status" => "200","message"=>"Compiled"],200);
        } else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422);
        }
    }



    function GetWidgetSource($startZoneTag = null, $endZoneTag = null, $assemblyname = null){
        $assemblyContent = File::get(resource_path()."/compiledUserUIWidgets/".$assemblyname.'.php');
        $assemblyZoneContent = explode($startZoneTag, $assemblyContent)[1];
        $assemblyZoneContent = explode($endZoneTag, $assemblyZoneContent)[0];
        return $assemblyZoneContent;
    }


    function EditWidget($widgetpath = null){
        if(!is_null($widgetpath)){
            if(DB::table('uiwidget')->select('id')->where([['path','=',$widgetpath]])->exists()){
                $uiwidgetinfo = DB::table('uiwidget')->select('assembly','visiblename')->where([['path','=',$widgetpath]])->get()[0];
                if(file_exists(resource_path()."/compiledUserUIWidgets/".$uiwidgetinfo->assembly.'_preview.php')){
                    $widgetVisibleName = $uiwidgetinfo->visiblename;
                    $usings = $this->GetWidgetSource('/*----------UseZone----------*/','/*----------EndUseZone----------*/',$uiwidgetinfo->assembly.'_preview');
                    $variables = $this->GetWidgetSource('/*----------VariableZone----------*/','/*----------EndVariableZone----------*/',$uiwidgetinfo->assembly.'_preview');
                    $scenarious = $this->GetWidgetSource('/*----------ScenarioZone----------*/','/*----------EndScenarioZone----------*/',$uiwidgetinfo->assembly.'_preview');
                    $view = $this->GetWidgetSource('<!----------ViewZone---------->','<!----------EndViewZone---------->',$uiwidgetinfo->assembly.'_preview');
                    
                    return view('ese/designer/editwidget')->with('pagepath',$widgetpath)->with('pageVisibleName',$widgetVisibleName)->with('assembly',$uiwidgetinfo->assembly)->with('scenarious',$scenarious)->with('usings',$usings)->with('variables',$variables)->with('view',$view);                  
                } else {
                    return view('ese/error')->with("stacktrace","Сборка пользовательского виджета с названием ".$uiwidgetinfo["assembly"]."_preview не найдена в файловой системе");
                }
            } else {
                return view('ese/error')->with("stacktrace","Пользовательский виджет не найден1");
            }
        } else {
            return view('ese/error')->with("stacktrace","Пользовательская виджет не найден");
        }
    }

    function GetAllWidgets(){
        return response()->json(["status"=>"200","widgets"=>DB::table('uiwidget')->select('id','visiblename')->get()],200);
    }

}
