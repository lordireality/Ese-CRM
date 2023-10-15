<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Validator;

class UIReportController extends Controller
{
    function EditReport($reportid = null){
        if(!is_null($reportid)){
            if(DB::table('uireport')->where([['uireport.id','=',$reportid]])->exists()){
                $reportData = DB::table('uireport')->where([['uireport.id','=',$reportid]])->get()[0];
                $allDBSet = DB::Select(DB::Raw('select column_name,table_name,DATA_TYPE from information_schema.columns where table_schema = \'eseapp\' order by table_name,ordinal_position'));
                $allTables = DB::Select(DB::Raw('SELECT TABLE_NAME FROM information_schema.tables where table_schema = \'eseapp\''));
                return view('ese/designer/editreport')->with("reportVisibleName",$reportData->visiblename)->with("sqlQuery",$reportData->sqlQuery)->with("view","TODO + assembly")->with("useCustomView",$reportData->useCustomView)->with("assembly",$reportData->viewAssembly)->with("useExternalConnection",$reportData->useExternalConnection)->with('allDBSet',$allDBSet)->with('allTables',$allTables);
            } else {
                return view('ese/error')->with("stacktrace","Пользовательский отчет не найдена!");
            }
        } else {
            return view('ese/error')->with("stacktrace","Пользовательский отчет не найдена!");
        }

    }
    function ViewReport($reportid = null){
        if(!is_null($reportid)){
            if(DB::table('uireport')->where([['uireport.id','=',$reportid]])->exists()){
                $reportData = DB::table('uireport')->where([['uireport.id','=',$reportid]])->get()[0];
                if($reportData->useExternalConnection == 1){
                    //use mysqli driver
                    $mysqliDriverConnection = new mysqli($reportData->externalServername, $reportData->externalUsername, $reportData->externalPassword);
                    if($mysqliDriverConnection->connect_error){
                        return view('ese/error')->with("stacktrace","Ошибка подключения к внешнему источнику MySQLi Procedural Driver: ".$mysqliDriverConnection->connect_error());
                    }
                    $DataSource = $mysqliDriverConnection->query($reportData->sqlQuery);
                    $mysqliDriverConnection->close();
                } else {
                    $DataSource = DB::SELECT(DB::RAW($reportData->sqlQuery));
                    return view('ese/UIReport')->with("visiblename",$reportData->visiblename)->with("useCustomView",$reportData->useCustomView)->with("assembly", $reportData->viewAssembly)->with("DataSource",$DataSource);
                }




            } else {
                return view('ese/error')->with("stacktrace","Пользовательский отчет не найдена!");
            }
        } else {
            return view('ese/error')->with("stacktrace","Пользовательский отчет не найдена!");
        }
    }
    function getAllTables(){
        $allDBSet = DB::Select(DB::Raw('select column_name,table_name,DATA_TYPE from information_schema.columns where table_schema = \'eseapp\' order by table_name,ordinal_position'));
        $allTables = DB::Select(DB::Raw('SELECT TABLE_NAME FROM information_schema.tables where table_schema = \'eseapp\''));
        foreach($allTables as $table){
            echo 'TABLE:'.$table->TABLE_NAME.'<br>';
            foreach(array_keys(array_column($allDBSet,'table_name'),$table->TABLE_NAME) as $key){
                echo 'COLUMN:'.$allDBSet[$key]->column_name.' is: '.$allDBSet[$key]->DATA_TYPE.'<br>';
            }
            
            //echo implode(array_keys(array_column($allDBSet,'table_name'),$table->TABLE_NAME), ' ').'<br>';
        }
    }


}
