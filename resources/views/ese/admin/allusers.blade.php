@extends('ese.layout')

@section('pagename', 'Администрирование пользователей')

@section('content')
    <div class="panel"><h1>Администрирование пользователей</h1></div>
    <br>
    <div class="panel"><h3>Фильтры</h3>
    <table>
        <tr>
            <td>ФИО:</td>
            <td colspan=2><input style="width:100%;" id="Filter_Fullname" @if(isset($requestedInput["Filter_Fullname"])) value="{{$requestedInput["Filter_Fullname"]}}" @endif type="text"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Id пользователя: </td>
            <td><input id="Filter_Id" @if(isset($requestedInput["Filter_Id"])) value="{{$requestedInput["Filter_Id"]}}" @endif type="number" min="1"></td>
            <td>Показывать только заблокированных: </td>
            <td><input id="Filter_IsBlocked" type="checkbox" @if(isset($requestedInput["Filter_IsBlocked"]))@if($requestedInput["Filter_IsBlocked"]) == 1) checked @endif @endif></td>
        </tr>
    </table>
    <a class="button2" href="javascript:FindUsers()">Искать пользователей</a>
    </div>
    <br>
    <table class="paneltable" style="text-align:left">
        <tr>
            <th>id пользователя</th>
            <th>ФИО</th>
            <th>Должность</th>
            <th>Редактировать</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td><a href="{{ route('UserPage', ['userId'=>$user->id]) }}">{{$user->lastname}} {{$user->firstname}} {{$user->middlename}}</a></td>
            <td>{{$user->Position}}</td>
            <td><a class="button2long" href="#">Редактировать</a></td>
        </tr>
        @endforeach
    </table>
    <script>
    function FindUsers(){
            var Filter_Id = document.getElementById("Filter_Id").value;
            var Filter_Fullname = document.getElementById("Filter_Fullname").value;
            var Filter_IsBlocked = (document.getElementById("Filter_IsBlocked").checked == true ? "1" : "0");
     
            var filterString = "?";
            if(Filter_Id != ''){
                filterString = filterString + "&Filter_Id="+Filter_Id
            }
            if(Filter_Fullname != ''){
                filterString = filterString + "&Filter_Fullname="+Filter_Fullname
            }
            if(Filter_IsBlocked != ''){
                filterString = filterString + "&Filter_IsBlocked="+Filter_IsBlocked
            }
            document.location.href = window.location.origin+"/admin/users"+filterString;
        }
    </script>
    </div>
@endsection