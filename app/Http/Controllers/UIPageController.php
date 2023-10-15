<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Validator;

class UIPageController extends Controller
{
    //Просмотр страницы
    function PageView($pagepath = null, Request $request){
        if(!is_null($pagepath)){
            if(DB::table('uipage')->select('id')->where([['path','=',$pagepath]])->exists()){
                $uipageinfo = DB::table('uipage')->select('assembly','visiblename')->where([['path','=',$pagepath]])->get()[0];
                $inputData = $request->input();
                if(isset($inputData["isEmulation"])){
                    if($inputData["isEmulation"] == 1){
                        if(file_exists(resource_path()."/compiledUserUI/".$uipageinfo->assembly.'_preview.php')){
                            return view('ese/UIPage')->with("visiblename",$uipageinfo->visiblename)->with("assembly",$uipageinfo->assembly.'_preview');
                        } else {
                            return view('ese/error')->with("stacktrace","Сборка пользовательской страницы с названием ".$uipageinfo->assembly." с меткой _preview не найдена в файловой системе");
                        }
                    } else {
                        if(file_exists(resource_path()."/compiledUserUI/".$uipageinfo->assembly.'.php')){
                            return view('ese/UIPage')->with("visiblename",$uipageinfo->visiblename)->with("assembly",$uipageinfo->assembly);
                        } else {
                            return view('ese/error')->with("stacktrace","Сборка пользовательской страницы с названием ".$uipageinfo->assembly." не найдена в файловой системе");
                        }
                    }
                } else {
                    if(file_exists(resource_path()."/compiledUserUI/".$uipageinfo->assembly.'.php')){
                        return view('ese/UIPage')->with("visiblename",$uipageinfo->visiblename)->with("assembly",$uipageinfo->assembly);
                    } else {
                        return view('ese/error')->with("stacktrace","Сборка пользовательской страницы с названием ".$uipageinfo->assembly." не найдена в файловой системе");
                    }
                }
                
        
            } else {
                return view('ese/error')->with("stacktrace","Пользовательская страница не найдена");
            }
        } else {
            return view('ese/error')->with("stacktrace","Пользовательская страница не найдена");
        }
    }

    function CompilePageSource(Request $request){
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
/* EseAPP custom page */

/*Для корректной работы, ни в коем случае не изменяйте исходный код находящийся
вне тегов ScenarioZone, EndScenarioZone,ViewZone, EndViewZone, UseZone, EndUseZone, VariableZone, EndVariableZone
*/
/*----------UseZone----------*/
'.$inputData["usingsCode"].'
/*----------EndUseZone----------*/
class Context extends ContextCore{
/*----------VariableZone----------*/
'.$inputData["variableCode"].'
/*----------EndVariableZone----------*/
/*----------ScenarioZone----------*/
'.$inputData["scenariousCode"].'
/*----------EndScenarioZone----------*/
}
class ContextCore{
    public function OnPreload(){             
    }
    public function OnLoaded(){             
    }
}
?>
<?php
$_context = new Context();
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
                $fpath = resource_path()."/compiledUserUI/".$inputData["assemblyname"].'.php';
            } else {
                $fpath = resource_path()."/compiledUserUI/".$inputData["assemblyname"].'_preview.php';
            }
            $assemblyFile = fopen($fpath, "w");
            file_put_contents($fpath, $sourceCode);
            fclose($assemblyFile);
            return response() -> json(["status" => "200","message"=>"Compiled"],200);
        } else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422);
        }
    }



    function GetPageSource($startZoneTag = null, $endZoneTag = null, $assemblyname = null){
        $assemblyContent = File::get(resource_path()."/compiledUserUI/".$assemblyname.'.php');
        $assemblyZoneContent = explode($startZoneTag, $assemblyContent)[1];
        $assemblyZoneContent = explode($endZoneTag, $assemblyZoneContent)[0];
        return $assemblyZoneContent;
    }


    function EditPage($pagepath = null){
        if(!is_null($pagepath)){
            if(DB::table('uipage')->select('id')->where([['path','=',$pagepath]])->exists()){
                $uipageinfo = DB::table('uipage')->select('assembly','visiblename')->where([['path','=',$pagepath]])->get()[0];
                if(file_exists(resource_path()."/compiledUserUI/".$uipageinfo->assembly.'_preview.php')){
                    $pageVisibleName = $uipageinfo->visiblename;
                    $usings = $this->GetPageSource('/*----------UseZone----------*/','/*----------EndUseZone----------*/',$uipageinfo->assembly.'_preview');
                    $variables = $this->GetPageSource('/*----------VariableZone----------*/','/*----------EndVariableZone----------*/',$uipageinfo->assembly.'_preview');
                    $scenarious = $this->GetPageSource('/*----------ScenarioZone----------*/','/*----------EndScenarioZone----------*/',$uipageinfo->assembly.'_preview');
                    $view = $this->GetPageSource('<!----------ViewZone---------->','<!----------EndViewZone---------->',$uipageinfo->assembly.'_preview');
                    
                    return view('ese/designer/editpage')->with('pagepath',$pagepath)->with('pageVisibleName',$pageVisibleName)->with('assembly',$uipageinfo->assembly)->with('scenarious',$scenarious)->with('usings',$usings)->with('variables',$variables)->with('view',$view);                  
                } else {
                    return view('ese/error')->with("stacktrace","Сборка пользовательской страницы с названием ".$uipageinfo["assembly"]."_preview не найдена в файловой системе");
                }
            } else {
                return view('ese/error')->with("stacktrace","Пользовательская страница не найдена");
            }
        } else {
            return view('ese/error')->with("stacktrace","Пользовательская страница не найдена");
        }
    }

}
