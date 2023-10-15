<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{
    function TasksPage(Request $request){
        $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
        $inputData = $request->input();
        $useFilter = false;
        $whereStatement = [];
        if(isset($inputData["Filter_TaskId"])){
            $useFilter = true;
            array_push($whereStatement,['taskbase.id','=',$inputData["Filter_TaskId"]]);
        }
        if(isset($inputData["Filter_AuthorId"])){
            $useFilter = true;
            array_push($whereStatement,['Author.id','=',$inputData["Filter_AuthorId"]]);
        }
        if(isset($inputData["Filter_ExecutorId"])){
            $useFilter = true;
            array_push($whereStatement,['Executor.id','=',$inputData["Filter_ExecutorId"]]);
        }
        if(isset($inputData["Filter_StarDateFrom"])){
            $useFilter = true;
            array_push($whereStatement,['taskbase.StartDate','>=',$inputData["Filter_StarDateFrom"]]);
        }
        if(isset($inputData["Filter_StartDateTo"])){
            $useFilter = true;
            array_push($whereStatement,['taskbase.StartDate','<=',$inputData["Filter_StartDateTo"]]);
        }
        if(isset($inputData["Filter_DeadlineDateFrom"])){
            $useFilter = true;
            array_push($whereStatement,['taskbase.DeadlineDate','>=',$inputData["Filter_DeadlineDateFrom"]]);
        }
        if(isset($inputData["Filter_DeadlineDateTo"])){
            $useFilter = true;
            array_push($whereStatement,['taskbase.DeadlineDate','<=',$inputData["Filter_DeadlineDateTo"]]);
        }
        if(isset($inputData["Filter_EndDateFrom"])){
            $useFilter = true;
            array_push($whereStatement,['taskbase.EndDate','>=',$inputData["Filter_EndDateFrom"]]);
        }
        if(isset($inputData["Filter_EndDateTo"])){
            $useFilter = true;
            array_push($whereStatement,['taskbase.EndDate','<=',$inputData["Filter_EndDateTo"]]);
        }
        if($useFilter == false){
            $whereStatement = [['Executor','=',$currentuserId],['EndDate','=',null]];
        }
       
        $tasks = DB::table('taskbase')->select('taskbase.id as TaskId','taskbase.Name as TaskName','taskbase.StartDate as TaskStarDate','taskbase.DeadlineDate as TaskDeadlineDate','taskbase.EndDate as TaskEndDate','Author.id as AuthorId','Author.LastName as AuthorLastName','Author.MiddleName as AuthorMiddleName','Author.FirstName as AuthorFirstName','Executor.id as ExecutorId','Executor.LastName as ExecutorLastName', 'Executor.MiddleName as ExecutorMiddleName', 'Executor.FirstName as ExecutorFirstName')->join('user as Author','Author.id','=', 'taskbase.Author')->join('user as Executor','Executor.id','=','taskbase.Executor')->where($whereStatement)->get();
        return view('ese/tasks/tasks')->with("tasks",$tasks)->with("requestedInput",$inputData);
    }

    function ActiveTasksCount(Request $request){
        $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
        return DB::table('taskbase')->select('taskbase.id')->where([['Executor','=',$currentuserId]])->whereNull('EndDate')->get()->count();
    }

    function ProjectsPage(Request $request){
        return null;
    }
   
    
}
