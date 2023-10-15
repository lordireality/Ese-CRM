<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    //краткая информация о пользователе для вызова справки и попапов
    //TODO: Вынести в секурити, так как может быть ЗГТ ДСП в случае использовании в госках -> сведения о должностях л/с
    //либо прикрутить какой нибудь кастомный Application API KEY
    function API_UserInfo(Request $request){
        $inputData = $request->input();
        $validRules = [
            'id' => 'required|numeric|min:1|numeric'
        ];
        $validator = Validator::make($inputData,$validRules);
        if($validator -> passes()){
            if(DB::table('user')->select('id')->where('id','=',$inputData["id"])->exists()){

                return DB::table('user')->select('user.id','login','firstname','lastname','middlename','email','description','isBlocked','telegramId', 'organizationitem.name as Position' )->leftjoin('organizationitem', 'user.id', '=' ,'organizationitem.user')->where('user.id','=',$inputData["id"])->get()[0];
                
            } else {
                return response() -> json(["status"=>"422","message"=>"Указанный пользователь не существует"], 404);
            }
        } else {
            return response() -> json(["status"=>"422","message"=>$validator->messages()], 422);
        }
    }

    //Список пользователей с должностями для DropDown селекторов
    function API_GetAllUsers(Request $request){
        return DB::table('user')->select('user.id','firstname','lastname','middlename','email', 'organizationitem.name as Position' )->leftjoin('organizationitem', 'user.id', '=' ,'organizationitem.user')->get();
    }

    function UserPage($userId = null){
        $validRules = [
            'id' => 'required|numeric|min:1|numeric'
        ];
        $validator = Validator::make(['id' => $userId],$validRules);
        if($validator -> passes()){
            if(DB::table('user')->select('id')->where('id','=',$userId)->exists()){

                $userData = DB::table('user')->select('user.id', 'login','firstname','lastname','middlename','email','description','isBlocked','telegramId', 'organizationitem.name as Position' )->leftjoin('organizationitem', 'user.id', '=' ,'organizationitem.user')->where('user.id','=',$userId)->get()[0];

                $photoPath = '';
                if (file_exists(public_path('/ese/usercontent/profile/'.$userData->id.'.png'))){
                    $photoPath = asset('/ese/usercontent/profile/'.$userData->id.'.png');
                } else {
                    $photoPath = asset('/ese/usercontent/profile/default.png');
                }
                return view('ese.users.user')->with('FullName',$userData->lastname.' '.$userData->firstname.' '.$userData->middlename)->with('Position',$userData->Position)->with('Description',$userData->description)->with('Email',$userData->email)->with('PhotoPath',$photoPath);
            } else {
                return response() -> json(["status"=>"422","message"=>"Указанный пользователь не существует"], 404);
            }
        } else {
            return response() -> json(["status"=>"422","message"=>$validator->messages()], 422);
        }
    }




}
