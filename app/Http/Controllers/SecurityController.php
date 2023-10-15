<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class SecurityController extends Controller
{
    //Открытие страницы авторизации
    function LogOnPage(Request $request){
        //Проверка, авторизован ли уже пользователь. Если авторизован отправляем на индекс, если нет то на логин
        if($this->IsSessionAlive($request) == true){
            return redirect()->route('index');
        } else {
            return view('ese/login');
        }
        
    }

    //API метод авторизации
    function Auth(Request $request){
        $inputData = $request->input();
        $validRules = [
           'email' => 'required|Email|max:256',
           'password' => 'required|max:256'
        ];
        $validator = Validator::make($inputData,$validRules);
        if($validator -> passes()){
            //Тут вы можете установить свои параметры хэширования пароля
            //Важно, что бы при создании учетной записи использовались аналогичные правила хэширования
            //--------------Start hash region--------------
            $hashedPassword = hash('sha256',$inputData["password"].$inputData["email"]);
            //---------------End hash region---------------
            if(DB::table('user')->SELECT('email')->WHERE([['email','=',$inputData["email"]],['passwordhash','=',$hashedPassword]])->exists()){
                $authtoken = hash('sha256',date("ymdhis"));
                DB::table('user')->WHERE([['email','=',$inputData["email"]],['passwordhash','=',$hashedPassword]])->update(['authtoken' => $authtoken]);
                return response() -> json(["status" => "200","message"=>"Вы успешно авторизовались!", "authtoken"=>$authtoken, "email"=>$inputData["email"]],200);
            } else {
                return response() -> json(["status" => "401","message"=>"Неверный логин или пароль!"],401);
            }
        } else { return response() -> json(["status" => "422","message"=>$validator->messages()],422); }
    }

    //TODO: очень сложно
    //API метод создания пользователя
    //Может быть использован для переноса учетных записей из внешних систем
    function CreateUser(Request $request){
        $inputData = $request->input();
        $validRules = [
           'email' => 'required|Email|max:256',
           'password' => 'required|max:256',
           'login' => 'required|max:256',
           'firstname' => 'required|max:256',
           'lastname' => 'required|max:256',
           'middlename' => 'max:256',
           'apiToken' => 'required'
        ];
        $validator = Validator::make($inputData,$validRules);
        if($validator -> passes()){
            if(DB::table('user')->SELECT('login')->WHERE([['login','=',$inputData["login"]]])->exists()){
                return response() -> json(["status" => "409","message"=>"Пользователь с таким логином уже зарегистрирован в системе!"],409);
            } else {
                //Тут вы можете установить свои параметры хэширования пароля
                //Важно, что бы при авторизации учетной записи использовались аналогичные правила хэширования
                //--------------Start hash region--------------
                $hashedPassword = hash('sha256',$inputData["password"].$inputData["email"]);
                //---------------End hash region---------------

                //TODO Insert

                return response() -> json(["status" => "200","message"=>"Учетная запись с логином ".$inputData["login"]." успешно создана!"],200);
            }
        }
    }


    //Верификации текущей сессии
    function IsSessionAlive(Request $request){
        $cookieInputData = $request->cookie();
        $validRules = [
            'email' => 'required|Email|max:256',
            'authtoken' => 'required'
        ];
        $validator = Validator::make($cookieInputData,$validRules);
        if($validator -> passes()){
            if(DB::table('user')->SELECT('email')->WHERE([['email','=',$cookieInputData["email"]],['authtoken','=',$cookieInputData["authtoken"]]])->exists()){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function IsCurrentUserAdmin(Request $request){

    }

    //получить id текущего пользователя
    function GetCurrentUserId(Request $request){
        $cookieInputData = $request->cookie();
        $validRules = [
            'email' => 'required|Email|max:256',
            'authtoken' => 'required'
        ];
        $validator = Validator::make($cookieInputData,$validRules);
        if($validator -> passes()){
            if(DB::table('user')->SELECT('id')->WHERE([['email','=',$cookieInputData["email"]],['authtoken','=',$cookieInputData["authtoken"]]])->exists()){
                return DB::table('user')->SELECT('id')->WHERE([['email','=',$cookieInputData["email"]],['authtoken','=',$cookieInputData["authtoken"]]])->get()[0]->id;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
