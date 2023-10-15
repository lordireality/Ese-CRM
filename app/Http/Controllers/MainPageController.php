<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainPageController extends Controller
{
    function LoadMainPage(Request $request){
        
        $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
        //Получаем виджеты
        $widgetInfo = DB::table('indexpage_widgets')->select('uiwidget.assembly','uiwidget.visiblename','indexpage_widgets.id','indexpage_widgets.num')->leftjoin('uiwidget','uiwidget.id', '=', 'indexpage_widgets.widgetId')->where([['indexpage_widgets.userId','=',$currentuserId],['indexpage_widgets.num', '<>', '0']])->orderby('indexpage_widgets.num', 'asc')->get();
        $isEdit = false;
        if($request->has("isEdit")){
            
            $isEdit = (bool)$request->input()["isEdit"];
        } else {
            $isEdit = false;
        }
        
        return view('/ese/mainpage')->with("widgetInfo",$widgetInfo)->with("isEdit",$isEdit);
    }

    function AddWidgetZone(Request $request){
        $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
        if(!is_null($currentuserId)){
            $newWidgetZoneNum = (DB::table('indexpage_widgets')->where([['userId','=',$currentuserId]])->max('num'));
            if(is_null($newWidgetZoneNum)){
                $newWidgetZoneNum = 1;
            } else {
                $newWidgetZoneNum = $newWidgetZoneNum + 1;
            }
            DB::table('indexpage_widgets')->insert(["userId"=>$currentuserId,"num"=>$newWidgetZoneNum]);
            return response() -> json(["status" => "200","message"=>"Zone added!"],200);
        } else {
            return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
        }
        
        
    }
    function RemoveWidgetZone(Request $request){
        $inputData = $request->input();
        $validRules = [
            'num' => 'required|min:1|numeric'
        ];
        $validator = Validator::make($inputData,$validRules);
        if($validator->passes()){
            $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            if(!is_null($currentuserId)){
                if(DB::table('indexpage_widgets')->where([['userId','=',$currentuserId],['num','=', $inputData["num"]]])->exists()){
                    DB::table('indexpage_widgets')->WHERE([['userId','=',$currentuserId],['num','=', $inputData["num"]]])->update(['widgetId'=>null,'num'=>0]);
                    return response() -> json(["status" => "200","message"=>"Widget zone soft-deleted successfully!"],200);
                } else {
                    return response() -> json(["status" => "204","message"=>"Widget zone with num: ".$inputData["num"]." for user with id ".$currentuserId." not found"],204);
                    
                }
            } else {
                return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
            }
        } else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422); 
        }
    }
    function SetWidgetToZone(Request $request){
        $inputData = $request->input();
        $validRules = [
            'num' => 'required|min:1|numeric',
            'widgetId' => 'required|min:1|numeric'
        ];
        $validator = Validator::make($inputData,$validRules);
        if($validator->passes()){
            $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            if(!is_null($currentuserId)){
                if(DB::table('indexpage_widgets')->where([['userId','=',$currentuserId],['num','=', $inputData["num"]]])->exists()){
                    if(DB::table('uiwidget')->where([['id','=',$inputData["widgetId"]]])->exists()){
                        DB::table('indexpage_widgets')->WHERE([['userId','=',$currentuserId],['num','=', $inputData["num"]]])->update(['widgetId'=>$inputData["widgetId"]]);
                        return response() -> json(["status" => "200","message"=>"Widget set successfully!"],200);
                    } else {
                        return response() -> json(["status" => "204","message"=>"Widget with id: ".$inputData["widgetId"]." not found"],204);
                    }
                } else {
                        return response() -> json(["status" => "204","message"=>"Widget zone with num: ".$inputData["num"]." for user with id ".$currentuserId." not found"],204);
                }
            } else {
                return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
            }
        } else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422); 
        }


    }


}
