@extends('ese.layout')

@section('pagename', 'ESE-CRM Dev. Studio')

@section('content')

    <div class="panel"><h1>@yield('devStudioSectionName')ESE-CRM Dev. Studio [Даже не pre-alpha]</h1>
    <a class="button2" href="{{route('DevStudioIndex')}}">Главная</a>
    
    <a class="button2" href="{{route('DevStudioPagesIndex')}}">Страницы</a> 
    <a class="button2" href="#">Виджеты</a>
    <a class="button2" href="{{route('DevStudioReportsIndex')}}">Отчеты</a>
    <a class="button2" href="#">Объекты</a>
    <a class="button2" href="#">Процессы</a>
    <a class="button2" href="#">Штатное расписание</a>
    </div>
    @yield('DevStudioContent')
    <hr>
    <h1>
    Тут ничего не работает! <br>
    Короче вот роуты - пользуйтесь! <br>
    DevStudio/EditUIPage/{pagepath} <br>
    DevStudio/EditUIWidget/{widgetpath} <br>
    DevStudio/EditUIReport/{reportid}
    </h1>
@endsection