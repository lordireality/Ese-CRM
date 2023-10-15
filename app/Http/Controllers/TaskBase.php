<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskBase extends Controller
{
    /*
    Контроллер просмотра страницы задачи
    */
    function TaskBaseView($id = null, Request $request){
        $validRules = [
            'id' => 'required|min:1|numeric',
         ];
         $validator = Validator::make(['id'=>$id],$validRules);
        if($validator -> passes()){
            $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            if(!is_null($currentuserId)){
                if(DB::table('taskbase')->SELECT('taskbase.id')->WHERE([['id','=',$id]])->exists()){
                    $taskData = DB::table('taskbase')->SELECT('taskbase.id','taskbase.Name','taskbase.Description','taskbase.StartDate','taskbase.EndDate','taskbase.DeadlineDate','Author.id as AuthorId','Author.LastName as AuthorLastName','Author.MiddleName as AuthorMiddleName','Author.FirstName as AuthorFirstName','Executor.id as ExecutorId','Executor.LastName as ExecutorLastName', 'Executor.MiddleName as ExecutorMiddleName', 'Executor.FirstName as ExecutorFirstName', 'ParentTask.id as ParentTaskId', 'ParentTask.Name as ParentTaskName')->join('user as Author','Author.id','=', 'taskbase.Author')->join('user as Executor','Executor.id','=','taskbase.Executor')->leftjoin('taskbase as ParentTask','ParentTask.id','=','taskbase.ParentTask')->WHERE([['taskbase.id','=',$id]])->get();
                    //Проверяем является ли текущий юзер исполнителем
                    if(DB::table('taskbase')->where([['taskbase.executor','=',$currentuserId],['taskbase.id','=',$id]])->get()->count() == 1){
                        //Проверяем существует ли экшен на прочитанность задачи исполнителем
                        if(DB::table('taskbase')->join('taskbase_action','taskbase_action.task','=','taskbase.id')->join('action','taskbase_action.action','=','action.id')->where([['taskbase.id','=',$id],['action.actiontype','=','2'],['taskbase.executor','=',$currentuserId],['action.user','=',$currentuserId]])->get()->count()==0){
                        
                            $actionId = DB::table('action')->insertGetId(['user'=>$currentuserId,'creationdate'=>now(),'actiontype'=>2]);
                            DB::table('taskbase_action')->insert(['task'=>$id,'action'=>$actionId]);
                        }
                    }
                    $subTasks = DB::table('taskbase')->select('taskbase.id as TaskId','taskbase.Name as TaskName','taskbase.StartDate as TaskStarDate','taskbase.DeadlineDate as TaskDeadlineDate','taskbase.EndDate as TaskEndDate','Author.id as AuthorId','Author.LastName as AuthorLastName','Author.MiddleName as AuthorMiddleName','Author.FirstName as AuthorFirstName','Executor.id as ExecutorId','Executor.LastName as ExecutorLastName', 'Executor.MiddleName as ExecutorMiddleName', 'Executor.FirstName as ExecutorFirstName')->join('user as Author','Author.id','=', 'taskbase.Author')->join('user as Executor','Executor.id','=','taskbase.Executor')->where([['taskbase.ParentTask','=',$id]])->get();
                    $taskCommentData = DB::table('taskbase_comment')->select('comment.text as commenttext', 'comment.creationdate as HistoryItemCreationDate',DB::raw("null as actiontypename"),DB::raw("0 as actiontypeid") ,'commentAuthor.id as AuthorId','commentAuthor.LastName as AuthorLastName','commentAuthor.MiddleName as AuthorMiddleName', 'commentAuthor.FirstName as AuthorFirstName', 'uploadedfiles.filename as AttachName', 'uploadedfiles.id as AttachId')->join('comment', 'comment.id', '=', 'taskbase_comment.comment')->join('user as commentAuthor', 'commentAuthor.id', '=', 'comment.user')->leftjoin('commentattachment', 'commentattachment.comment', '=', 'comment.id')->leftjoin('uploadedfiles', 'uploadedfiles.id', '=', 'commentattachment.file')->where([['taskbase_comment.task','=',$id]]);
                    $taskActionData = DB::table('taskbase_action')->select(DB::raw("null as commenttext"),'action.creationdate as HistoryItemCreationDate', 'actiontype.name as actiontypename', 'actiontype as actiontypeid', 'actionAuthor.id as AuthorId','actionAuthor.LastName as AuthorLastName','actionAuthor.MiddleName as AuthorMiddleName', 'actionAuthor.FirstName as AuthorFirstName', DB::raw("null as AttachName"), DB::raw("null as AttachId"))->join('action','taskbase_action.action','=','action.id')->join('actiontype','actiontype.id','=','action.actiontype')->join('user as actionAuthor', 'actionAuthor.id', '=', 'action.user')->where([['taskbase_action.task','=',$id]]);
                    $taskHistoryData = $taskActionData->union($taskCommentData)->orderBy('HistoryItemCreationDate','ASC')->get();
                    return view('ese/tasks/taskbase')->with("taskData",$taskData[0])->with("taskHistoryData",$taskHistoryData)->with("subTasks",$subTasks);
                } else {
                    return view('ese/error')->with("stacktrace","Задача с id:".$id." не найдена!");
                }
            }
            else {
                return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
            }
        } else {
            return view('ese/error')->with("stacktrace",$validator->messages());
        }
    }
    /*
    API Контроллер добавления комментария
    */
    function TaskBaseAddComment(Request $request){
        $validRules = [
            'text' => 'required',
            'task' => 'required|min:1|numeric'
        ];
        
        $inputData = $request->input();
        $validator = Validator::make($inputData,$validRules);
        if($validator->passes()){
            $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            if(!is_null($currentuserId)){
                if(DB::table('taskbase')->SELECT('taskbase.id')->WHERE([['id','=',$inputData["task"]]])->exists()){
                    $commentId = DB::table('comment')->insertGetId([
                        'user' => $currentuserId,
                        'text' => $inputData["text"],
                        'creationdate' => now()
                    ]);
                    DB::table('taskbase_comment')->insert([
                        'task' => $inputData["task"],
                        'comment' => $commentId
                    ]);
                    
                    if(isset($inputData["file_name"]) && isset($inputData["file_type"]) && isset($inputData["file_base64"])){
                        $fileId = DB::table('uploadedfiles')->insertGetId([
                            'filename' => $inputData["file_name"],
                            'filetype' => $inputData["file_type"],
                            'base64' => $inputData["file_base64"]
                        ]);
                        DB::table('commentattachment')->insert(['comment'=>$commentId,'file'=>$fileId]);
                    }
                    return response() -> json(["status" => "200","message"=>"Comment added"],200);
                } else {
                    return response() -> json(["status" => "204","message"=>"Task with id: ".$inputData["task"]." not found"],204);
                }
            } else {
                return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
            }
        } else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422); 
        }   
    }
    /*
    API Метод контроллера переназначения
    */
    function TaskBaseChangeExecutor(Request $request){
        $validRules = [
            'task' => 'required|min:1|numeric',
            'newExecutor' => 'required|min:1|numeric',
        ];
        $inputData = $request->input();
        $validator = Validator::make($inputData,$validRules);
        if($validator->passes()){
            $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            if(!is_null($currentuserId)){
                if(DB::table('taskbase')->SELECT('taskbase.id')->WHERE([['id','=',$inputData["task"]]])->exists()){
                    if(DB::table('user')->SELECT('user.id')->WHERE([['id','=',$inputData["newExecutor"]]])->exists()){
                        $taskExecutor = DB::table('taskbase')->SELECT('taskbase.Executor')->WHERE([['id','=',$inputData["task"]]])->get()[0]->Executor;
                        $taskAuthor = DB::table('taskbase')->SELECT('taskbase.Author')->WHERE([['id','=',$inputData["task"]]])->get()[0]->Author;
                        if(($currentuserId == $taskExecutor) || ($currentuserId == $taskAuthor)){
                            
                            $actionId = DB::table('action')->insertGetId(['user'=>$currentuserId,'creationdate'=>now(),'actiontype'=>3, 'newExecutor'=>$inputData["newExecutor"], 'oldExecutor'=>$taskExecutor]);
                            DB::table('taskbase_action')->insert(['task'=>$inputData["task"],'action'=>$actionId]);
                            DB::table('taskbase')->WHERE([['id','=',$inputData["task"]]])->update(['Executor'=>$inputData["newExecutor"]]);
                            return response() -> json(["status" => "200","message"=>"Task executor changed"],200);
                        } else {
                            return response() -> json(["status" => "403","message"=>"Insufficiently privileges"],403);
                       }
                    } else {
                        return response() -> json(["status" => "204","message"=>"User with id: ".$inputData["newExecutor"]." not found"],204);
                    }
                } else {
                    return response() -> json(["status" => "204","message"=>"Task with id: ".$inputData["taskId"]." not found"],204);
                }
            }else {
                return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
            }
        } else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422); 
        }    
        
        
        //actiontype id - 3
        return null;
    }
    /*
    API Метод контроллера изменения контрольного срока исполнения
    */
    function TaskBaseChangeDeadline(Request $request){
        $validRules = [
            'task' => 'required|min:1|numeric',
            'newDeadline' => 'Date',
        ];
        $inputData = $request->input();
        $validator = Validator::make($inputData,$validRules);
        if($validator->passes()){
            $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            if(!is_null($currentuserId)){
                if(DB::table('taskbase')->SELECT('taskbase.id')->WHERE([['id','=',$inputData["task"]]])->exists()){
                    $taskAuthor = DB::table('taskbase')->SELECT('taskbase.Author')->WHERE([['id','=',$inputData["task"]]])->get()[0]->Author;
                    if($currentuserId == $taskAuthor){
                        $DeadlineDate = DB::table('taskbase')->SELECT('taskbase.DeadlineDate')->WHERE([['id','=',$inputData["task"]]])->get()[0]->DeadlineDate;
                        $actionId = DB::table('action')->insertGetId(['user'=>$currentuserId,'creationdate'=>now(),'actiontype'=>6, 'newDeadline'=>$inputData["newDeadline"], 'oldDeadline'=>$DeadlineDate]);
                        DB::table('taskbase_action')->insert(['task'=>$inputData["task"],'action'=>$actionId]);
                        DB::table('taskbase')->WHERE([['id','=',$inputData["task"]]])->update(['DeadlineDate'=>$inputData["newDeadline"]]);
                        return response() -> json(["status" => "200","message"=>"Task deadline changed"],200);
                    } else {
                        return response() -> json(["status" => "403","message"=>"Insufficiently privileges"],403);
                    }
                } else {
                    return response() -> json(["status" => "204","message"=>"Task with id: ".$inputData["taskId"]." not found"],204);
                }
            
            }else {
                return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
           }

        }else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422); 
        } 
        return null;
    }
    /*
    API Метод контроллера закрытия задачи
    */
    function TaskBaseCloseTask(Request $request){
        $validRules = [
            'task' => 'required|min:1|numeric'
        ];
        $inputData = $request->input();
        $validator = Validator::make($inputData,$validRules);
        if($validator->passes()){
            $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            if(!is_null($currentuserId)){
                if(DB::table('taskbase')->SELECT('taskbase.id')->WHERE([['id','=',$inputData["task"]]])->exists()){
                    $taskExecutor = DB::table('taskbase')->SELECT('taskbase.Executor')->WHERE([['id','=',$inputData["task"]]])->get()[0]->Executor;
                    if($currentuserId == $taskExecutor){
                        $actionId = DB::table('action')->insertGetId(['user'=>$currentuserId,'creationdate'=>now(),'actiontype'=>5]);
                        DB::table('taskbase_action')->insert(['task'=>$inputData["task"],'action'=>$actionId]);
                        DB::table('taskbase')->WHERE([['id','=',$inputData["task"]]])->update(['EndDate'=>now()]);
                        $subtasks = DB::table('taskbase')->SELECT('id')->WHERE([['ParentTask','=',$inputData["task"]]])->get();
                        while(count($subtasks)>0){
                            $newSubTasksPool = array();
                            foreach($subtasks as $subtask){
                                $actionId = DB::table('action')->insertGetId(['user'=>$currentuserId,'creationdate'=>now(),'actiontype'=>9]);
                                DB::table('taskbase_action')->insert(['task'=>$subtask->id,'action'=>$actionId]);
                                DB::table('taskbase')->WHERE([['id','=',$subtask->id]])->update(['EndDate'=>now()]);
                                $newSubTasks = DB::table('taskbase')->SELECT('id')->WHERE([['ParentTask','=',$subtask->id]])->get();
                                if(!is_null($newSubTasks)){
                                    foreach($newSubTasks as $newSubTask)
                                    array_push($newSubTasksPool,$newSubTask);
                                }
                            }
                            $subtasks = $newSubTasksPool;
                        }
                        //$subtasks = action id 9
                        return response() -> json(["status" => "200","message"=>"Task closed"],200);
                
                    } else {
                        return response() -> json(["status" => "403","message"=>"Insufficiently privileges"],403);
                    }
                } else {
                    return response() -> json(["status" => "204","message"=>"Task with id: ".$inputData["taskId"]." not found"],204);
                }
            
            }else {
                return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
           }

        }else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422); 
        } 
        return null;
    }
    /*
    API Метод контроллера переоткрытия задачи
    */
    function TaskBaseReopenTask(Request $request){
        $validRules = [
            'task' => 'required|min:1|numeric'
        ];
        $inputData = $request->input();
        $validator = Validator::make($inputData,$validRules);
        if($validator->passes()){
            $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            if(!is_null($currentuserId)){
                if(DB::table('taskbase')->SELECT('taskbase.id')->WHERE([['id','=',$inputData["task"]]])->exists()){
                    $taskAuthor = DB::table('taskbase')->SELECT('taskbase.Author')->WHERE([['id','=',$inputData["task"]]])->get()[0]->Author;
                    if($currentuserId == $taskAuthor){
                        $actionId = DB::table('action')->insertGetId(['user'=>$currentuserId,'creationdate'=>now(),'actiontype'=>8]);
                        DB::table('taskbase_action')->insert(['task'=>$inputData["task"],'action'=>$actionId]);
                        DB::table('taskbase')->WHERE([['id','=',$inputData["task"]]])->update(['EndDate'=>null]);
                        return response() -> json(["status" => "200","message"=>"Task reopened"],200);
                    } else {
                        return response() -> json(["status" => "403","message"=>"Insufficiently privileges"],403);
                    }
                } else {
                    return response() -> json(["status" => "204","message"=>"Task with id: ".$inputData["taskId"]." not found"],204);
                }
            
            }else {
                return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
           }

        }else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422); 
        } 
        return null;
    }
    /*
    API Метод контроллера создания задачи
    */
    function TaskBaseCreate(Request $request){
        $validRules = [
            'taskName' => 'required',
            'taskDescription' => 'required',
            'taskExecutorId' => 'required|min:1|numeric',
        ];
        $inputData = $request->input();
        $validator = Validator::make($inputData,$validRules);
        if($validator->passes()){
            $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            if(!is_null($currentuserId)){
                $deadline = ($inputData["taskDeadline"] != '') ? $inputData["taskDeadline"] : null;
                $taskId = DB::table('taskbase')->insertGetId(['Name'=>$inputData["taskName"],'Description'=>$inputData["taskDescription"],'StartDate'=>now(),'DeadlineDate'=>$deadline,'Author'=>$currentuserId,'Executor'=>$inputData["taskExecutorId"]]);
                $actionId = DB::table('action')->insertGetId(['user'=>$currentuserId,'creationdate'=>now(),'actiontype'=>1]);
                DB::table('taskbase_action')->insert(['task'=>$taskId,'action'=>$actionId]);
                return response() -> json(["status" => "200","message"=>"Task created","taskId"=>$taskId],200);

            } else {
                return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
            }

        } else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422); 
        }    
        
        //actiontype id - 1
        return null;
    }
    function SubTaskBaseCreate(Request $request){
        $validRules = [
            'taskName' => 'required',
            'taskDescription' => 'required',
            'taskExecutorId' => 'required|min:1|numeric',
            'parentTaskId' => 'required|min:1|numeric'
        ];
        $inputData = $request->input();
        $validator = Validator::make($inputData,$validRules);
        if($validator->passes()){
            $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            if(!is_null($currentuserId)){
                if(DB::table('taskbase')->where([['taskbase.id','=',$inputData["parentTaskId"]]])->exists()){
                    $deadline = ($inputData["taskDeadline"] != '') ? $inputData["taskDeadline"] : null;
                    $taskId = DB::table('taskbase')->insertGetId(['ParentTask'=>$inputData["parentTaskId"],'Name'=>$inputData["taskName"],'Description'=>$inputData["taskDescription"],'StartDate'=>now(),'DeadlineDate'=>$deadline,'Author'=>$currentuserId,'Executor'=>$inputData["taskExecutorId"]]);
                    $subTaskActionId = DB::table('action')->insertGetId(['user'=>$currentuserId,'creationdate'=>now(),'actiontype'=>1]);
                    DB::table('taskbase_action')->insert(['task'=>$taskId,'action'=>$subTaskActionId]);
                    $parentTaskActionId = DB::table('action')->insertGetId(['user'=>$currentuserId,'creationdate'=>now(),'actiontype'=>7]);
                    DB::table('taskbase_action')->insert(['task'=>$inputData["parentTaskId"],'action'=>$parentTaskActionId]);
                    return response() -> json(["status" => "200","message"=>"Task created","taskId"=>$taskId],200);
                }  else {
                    return response() -> json(["status" => "204","message"=>"Task with id: ".$inputData["taskId"]." not found"],204);
                }              
            } else {
                return response() -> json(["status" => "401","message"=>"Unauthorised!"],401);
            }

        } else {
            return response() -> json(["status" => "422","message"=>$validator->messages()],422); 
        }    
        
        //actiontype id - 1
        return null;
    }
    
}
