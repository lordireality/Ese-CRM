@extends('ese.layout')

@section('pagename', 'Админ панель')

@section('content')
    <div class="panel"><h1>Админ панель</h1></div>
    <br>
    <div class="adminPanel">
        <div class="green">
            <h1>Информация о сервере:</h1>
            <hr>
            <h3 style="text-align:left;">Имя сервера: {{$_SERVER['SERVER_NAME']}}</h3>
            <h3 style="text-align:left;">Используемое ядро сервера: {{$_SERVER["SERVER_SOFTWARE"]}}</h3>
            <h3 style="text-align:left;">Протокол: {{$_SERVER['SERVER_PROTOCOL']}}</h3>
            <h3 style="text-align:left">Режим разработчика: {{env('APP_DEBUG')}}
            <h3 style="text-align:left">Версия ESE: {{env('APP_VER')}}
        </div>
        <div class="green">
            <h1>ESE-CRM Dev. Studio:</h1>
            <hr>
            <a class="button2long" href="{{route('DevStudioIndex')}}">ESE-CRM Dev. Studio</a>
            <a class="button2long" href="https://ese-crm.ru/devdoc/index">Документация разработчика[БЕТА]</a>
        </div>
        <div class="green">
            <h1>Настройки прав доступа:</h1>
            <hr>
            
        </div>
        <div class="green">
            <h1>Базовое администрирование:</h1>
            <hr>
            <a class="button2long" href="{{route('adminpanelallusers')}}">Пользователи</a>
            
        </div>
    </div>
@endsection