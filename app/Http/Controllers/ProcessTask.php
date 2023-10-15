<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcessTask extends Controller
{
    function LoadProcessTask($taskId = null){
        if(isset($taskId)){
            if(DB::table('processtask')->where(['id','=',$taskId]->exists())){
                //select [processtask + diagramitem => formId] + [processtask + [processinstance + processheader => Assembly]
            } else {
                //error task not found
            }
        } else {
            //error task not found
        }
    }
}
