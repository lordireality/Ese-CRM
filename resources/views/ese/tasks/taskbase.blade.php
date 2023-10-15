@php
    $def_popups = ['ese.popup.addcomment','ese.popup.changeexecutor','ese.popup.createsubtask','ese.popup.changetaskstatus'];
@endphp
@extends('ese.layout',['def_popups'=>$def_popups])

@section('pagename', 'Задача')

@section('content')
    <div class="panel"> 
        <h3>Действия по задаче:</h3>
        <a class="button2" href="javascript:ChangeStatusPopup('changetaskstatuspopup')">Сменить статус задачи</a>
        <a class="button2" href="javascript:ChangeTaskExecutorPopup('changetaskexecutorpopup')">Переназначить</a>
        <a class="button2" href="javascript:AddCommentTaskPopup('addtaskcommentpopup')">Добавить комментарий</a>
        <a class="button2" href="javascript:CreateSubTaskPopup('createsubtaskpopup',{{$taskData->id}})">Создать подзадачу</a>
    </div>
    <br>
    <div class="panel"><h1>Задача #{{$taskData->id}} - {!!$taskData->Name!!}</h1></div>
    <br>
    <div class="panel"><h3>Информация по задаче: </h3>
    <table>
        <tr> 
            <td>Автор: <a href="javascript:userInfoPopup({{$taskData->AuthorId}},'userinfopopup')">{{$taskData->AuthorLastName}} {{$taskData->AuthorFirstName}} {{$taskData->AuthorMiddleName}}</a></td>
            <td>Текущий исполнитель: <a href="javascript:userInfoPopup({{$taskData->ExecutorId}},'userinfopopup')">{{$taskData->ExecutorLastName}} {{$taskData->ExecutorFirstName}} {{$taskData->ExecutorMiddleName}}</a></td>
        </tr>
        <tr> 
            <td>Задача создана: {{$taskData->StartDate}}</td>
            <td>Выполнить в срок до: {{$taskData->DeadlineDate}}</td>
            <td>Закрыто: {{$taskData->EndDate}}</td>
        </tr>
    </table>
    <br>
    @if(isset($taskData->ParentTaskId))
    <b>Родительская задача:</b> <a href="{{route('TaskBaseView',['id' => $taskData->ParentTaskId])}}"> {{$taskData->ParentTaskName}}</a><br>
    @endif
    
    @if(count($subTasks)>0)
    <b>Подзадачи</b>
    <table class="paneltable" style="color:black; background-color:white;">
        <tr>
            <th>№ задачи</th>
            <th>Наименование</th>
            <th>Автор</th>
            <th>Исполнитель</th>
            <th>Дата создания</th>
            <th>Дата закрытия</th>
            <th>Выполнить в срок до</th>
        </tr>
        @foreach($subTasks as $subTaskItem)
        <tr>
            <td>{{$subTaskItem->TaskId}}</td>
            <td><a href="{{route('TaskBaseView',['id' => $subTaskItem->TaskId])}}">{{$subTaskItem->TaskName}}</a></td>
            <td><a href="javascript:userInfoPopup({{$subTaskItem->AuthorId}},'userinfopopup')">{{$subTaskItem->AuthorLastName}} {{$subTaskItem->AuthorFirstName}} {{$subTaskItem->AuthorMiddleName}}</a></td>
            <td><a href="javascript:userInfoPopup({{$subTaskItem->ExecutorId}},'userinfopopup')">{{$subTaskItem->ExecutorLastName}} {{$subTaskItem->ExecutorFirstName}} {{$subTaskItem->ExecutorMiddleName}}</a></td>
            <td>{{$subTaskItem->TaskStarDate}}</td>
            <td>{{$subTaskItem->TaskEndDate}}</td>
            <td>{{$subTaskItem->TaskDeadlineDate}}</td>
        </tr>
        @endforeach
    </table>
    @endif

    <br>
    <p>Описание:</p>
    <div class="historyelement">{!!$taskData->Description!!}</div>
    </div>
    <br>
    <div class="panel">
    <h3>История задачи:</h3>
    <hr>
    @foreach($taskHistoryData as $taskHistoryItem)
        @if($taskHistoryItem->actiontypeid==0)
        <div class="historyelement">
            <div class="historyelement_img">

            </div>
            <div class="historyelement_info">
                <i>{{$taskHistoryItem->HistoryItemCreationDate}} <a href="javascript:userInfoPopup({{$taskHistoryItem->AuthorId}},'userinfopopup')">{{$taskHistoryItem->AuthorLastName}} {{$taskHistoryItem->AuthorFirstName}} {{$taskHistoryItem->AuthorMiddleName}}</a>, добавил комментарий:</i>
                <div class="historyelement_comment">
                    <p>{{$taskHistoryItem->commenttext}}</p>
                </div>
                @if(!is_null($taskHistoryItem->AttachId))
                <p>Вложение:</p>
                <a href="{{route('GetFile',['fileid'=> $taskHistoryItem->AttachId])}}" download>{{$taskHistoryItem->AttachName}}</a>
                @endif
            </div>
        </div>
        @else
        <div class="historyelement">
        <i>{{$taskHistoryItem->HistoryItemCreationDate}} <a href="javascript:userInfoPopup({{$taskHistoryItem->AuthorId}},'userinfopopup')">{{$taskHistoryItem->AuthorLastName}} {{$taskHistoryItem->AuthorFirstName}} {{$taskHistoryItem->AuthorMiddleName}}</a> {{$taskHistoryItem->actiontypename}}</i>
        </div>
        @endif
        
    @endforeach
    </div>
    
@endsection