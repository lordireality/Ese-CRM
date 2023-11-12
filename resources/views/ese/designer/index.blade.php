@extends('ese.layout')

@section('pagename', 'ESE-CRM Dev. Studio')

@section('content')

    <div class="panel" style="color:red;"><h1>Внимание! DevStudio находится на ранней стадии развития! Просим относится с пониманием к возможным багам и ошибкам!</h1></div>

    <div class="panel"><h1>@yield('devStudioSectionName')ESE-CRM Dev. Studio</h1>
    <a class="button2" href="{{route('DevStudioIndex')}}">Главная</a>
    
    <a class="button2" href="{{route('DevStudioPagesIndex')}}">Страницы</a> 
    <a class="button2" href="{{route('DevStudioWidgetIndex')}}">Виджеты</a>
    <a class="button2" href="{{route('DevStudioReportsIndex')}}">Отчеты</a>
    <a class="button2" href="#">Объекты</a>
    <a class="button2" href="#">Процессы</a>
    <a class="button2" href="{{route('DevStudioOrganizationItemIndex')}}">Штатное расписание</a>
    </div>
    @yield('DevStudioContent')
    <hr>
@endsection


