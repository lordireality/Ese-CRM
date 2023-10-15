<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class FileController extends Controller
{
    function GetFile($fileid){
        if(DB::table('uploadedfiles')->where([['id','=',$fileid]])->exists()){
            $fileDbRecord = DB::table('uploadedfiles')->where([['id','=',$fileid]])->get()[0];
            $base64 = $fileDbRecord->base64;
            $base64 = str_replace('data:'.$fileDbRecord->filetype.';base64,', '', $base64);
            $base64 = str_replace(' ', '+', $base64);
            $rawFile = base64_decode($base64);
            return response($rawFile)->header('Content-Type', $fileDbRecord->filetype);
        } else {
            return view('ese/error')->with("stacktrace","Файл с id:".$$fileid." не найден!");
        }
    }
}
