@php
    $def_popups = ['ese.popup.createtask'];
@endphp
@extends('ese.layout',['def_popups'=>$def_popups])
@section('pagename', 'Задачи')
@section('content')
    
    <div class="panel">
        <h1>Задачи</h1>
        <hr>
        <a class="button2" href="javascript:CreateTaskPopup('createtaskpopup')">Создать задачу</a>
        <a class="button2" href="#">Запустить бизнес-процесс</a>
    </div>
    <br>
    <div class="panel"><h3>Фильтры</h3>
    <table>
        <tr>
            <td>№ задачи</td>
            <td><input id="Filter_TaskId" @if(isset($requestedInput["Filter_TaskId"])) value="{{$requestedInput["Filter_TaskId"]}}" @endif type="number" min="1"></td>
            <td></td>
            <td></td>
        </tr>
        <tr> 
            <td>Автор:</td>
            <td><select id="Filter_Author"><option value="null" selected></option></select></td>
            <td>Текущий исполнитель:</td>
            <td><select id="Filter_Executor"><option value="null" selected></option></select></td>
        </tr>
        <tr> 
            <td>Задача создана:</td>
            <td><input id="Filter_StarDateFrom" @if(isset($requestedInput["Filter_StarDateFrom"])) value="{{date('Y-m-d H:i', strtotime($requestedInput["Filter_StarDateFrom"]))}}" @endif type="datetime-local"> по <input id="Filter_StarDateTo" @if(isset($requestedInput["Filter_StarDateTo"])) value="{{date('yy-m-d H:i', strtotime($requestedInput["Filter_StarDateTo"]))}}" @endif type="datetime-local"></td>
            <td>Выполнить в срок:</td>
            <td><input id="Filter_DeadlineDateFrom" @if(isset($requestedInput["Filter_DeadlineDateFrom"])) value="{{date('Y-m-d H:i', strtotime($requestedInput["Filter_DeadlineDateFrom"]))}}" @endif type="datetime-local"> по <input  id="Filter_DeadlineDateTo" @if(isset($requestedInput["Filter_DeadlineDateTo"])) value="{{date('yy-m-d H:i', strtotime($requestedInput["Filter_DeadlineDateTo"]))}}" @endif type="datetime-local"> </td>
            
        </tr>
        <tr> 
            <td>Закрыто:</td>    
            <td><input id="Filter_EndDateFrom" type="datetime-local"> по <input id="Filter_EndDateTo" type="datetime-local"></td>        
            <td>Фильтровать по статусу:</td>
            <td><select><option value="any">Все</option><option value="active" selected>Активные</option><option value="closed">Закрытые</option></select></td>
        </tr>
    </table>
    <a class="button2" href="javascript:FindTasks()">Искать задачи</a>
    </div>
    <br>
    <table class="paneltable">
        <tr>
            <th>№ задачи</th>
            <th>Наименование</th>
            <th>Автор</th>
            <th>Исполнитель</th>
            <th>Дата создания</th>
            <th>Дата закрытия</th>
            <th>Выполнить в срок до</th>
        </tr>
        @foreach($tasks as $taskItem)
        <tr>
            <td>{{$taskItem->TaskId}}</td>
            <td><a href="{{route('TaskBaseView',['id' => $taskItem->TaskId])}}">{{$taskItem->TaskName}}</a></td>
            <td><a href="javascript:userInfoPopup({{$taskItem->AuthorId}},'userinfopopup')">{{$taskItem->AuthorLastName}} {{$taskItem->AuthorFirstName}} {{$taskItem->AuthorMiddleName}}</a></td>
            <td><a href="javascript:userInfoPopup({{$taskItem->ExecutorId}},'userinfopopup')">{{$taskItem->ExecutorLastName}} {{$taskItem->ExecutorFirstName}} {{$taskItem->ExecutorMiddleName}}</a></td>
            <td>{{$taskItem->TaskStarDate}}</td>
            <td>{{$taskItem->TaskEndDate}}</td>
            <td>{{$taskItem->TaskDeadlineDate}}</td>
        </tr>
        @endforeach
    </table>
    <script>
        window.addEventListener("load",function(){
            SetUserDropDownOnLoad(["Filter_Executor","Filter_Author"])
            @if(isset($requestedInput["Filter_AuthorId"])) document.getElementById("Filter_Author").value = {{$requestedInput["Filter_AuthorId"]}}; @endif
            @if(isset($requestedInput["Filter_ExecutorId"])) document.getElementById("Filter_Executor").value = {{$requestedInput["Filter_ExecutorId"]}}; @endif
        },false);
        function SetUserDropDownOnLoad(itemsToFill){
            var users = JSON.parse(HTTPGet(window.location.origin+'/api/ESE/USERS/AllUsers'));
            for(var i=0; i< users.length; i++){
                
                for(var j=0; j< itemsToFill.length; j++){
                    
                    document.getElementById(itemsToFill[j]).add(new Option(users[i].lastname + " " + users[i].firstname + " " + " " + users[i].middlename + "("+users[i].Position+")",users[i].id));
                }
            }
        }
        function FindTasks(){
            var Filter_TaskId = document.getElementById("Filter_TaskId").value;
            var Filter_Author = document.getElementById("Filter_Author").value;
            var Filter_Executor = document.getElementById("Filter_Executor").value;
            var Filter_StarDateFrom = document.getElementById("Filter_StarDateFrom").value;
            var Filter_StarDateTo = document.getElementById("Filter_StarDateTo").value;
            var Filter_DeadlineDateFrom = document.getElementById("Filter_DeadlineDateFrom").value;
            var Filter_DeadlineDateTo = document.getElementById("Filter_DeadlineDateTo").value;
            var Filter_EndDateFrom = document.getElementById("Filter_EndDateFrom").value;
            var Filter_EndDateTo = document.getElementById("Filter_EndDateTo").value;
            var filterString = "?UseFilter=1";
            if(Filter_TaskId != ''){
                filterString = filterString + "&Filter_TaskId="+Filter_TaskId
            }
            if(Filter_Author != 'null'){
                filterString = filterString + "&Filter_AuthorId="+Filter_Author
            }
            if(Filter_Executor != 'null'){
                filterString = filterString + "&Filter_ExecutorId="+Filter_Executor
            }
            if(Filter_StarDateFrom != ''){
                filterString = filterString + "&Filter_StarDateFrom="+Filter_StarDateFrom
            }
            if(Filter_StarDateTo != ''){
                filterString = filterString + "&Filter_StarDateTo="+Filter_StarDateTo
            }
            if(Filter_DeadlineDateFrom != ''){
                filterString = filterString + "&Filter_DeadlineDateFrom="+Filter_DeadlineDateFrom
            }
            if(Filter_DeadlineDateTo != ''){
                filterString = filterString + "&Filter_DeadlineDateTo="+Filter_DeadlineDateTo
            }
            if(Filter_EndDateFrom != ''){
                filterString = filterString + "&Filter_EndDateFrom="+Filter_EndDateFrom
            }
            if(Filter_EndDateTo != ''){
                filterString = filterString + "&Filter_EndDateTo="+Filter_EndDateTo
            }
            document.location.href = window.location.origin+"/Tasks"+filterString;
        }
    </script>
@endsection