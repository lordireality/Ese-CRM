<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPanelController extends Controller
{
    function AllUsersPage(Request $request){
        $inputData = $request->input();
        $useFilter = false;
        $whereStatement = [];
        if(isset($inputData["Filter_Fullname"])){
            array_push($whereStatement,[DB::raw('concat(\' \',lastname, firstname,middlename)'),'LIKE','%'.$inputData["Filter_Fullname"].'%']);
        }
        if(isset($inputData["Filter_Id"])){
            array_push($whereStatement,['user.id','=',$inputData["Filter_Id"]]);
        }
        if(isset($inputData["Filter_IsBlocked"])){
            array_push($whereStatement,['isBlocked','=',$inputData["Filter_IsBlocked"]]);
        }
        $users = DB::table('user')->select('user.id','firstname','lastname','middlename','email', 'organizationitem.name as Position' )->leftjoin('organizationitem', 'user.id', '=' ,'organizationitem.user')->where($whereStatement)->orderby('id')->get();
        return view('ese/admin/allusers')->with('users',$users)->with('requestedInput',$inputData);

    }
}
