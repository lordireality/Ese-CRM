@extends('ese.layout')

@section('pagename', 'Пользователь: '.$FullName)

@section('content')
<div class="panel"><h1>Пользователь: {{$FullName}}</h1></div>
<div style="width:100%; text-align:left;">
    <img style="width:25%; display:inline-block;" src="{{$PhotoPath}}">
    <div style="display:inline-block; vertical-align:top; padding: 10px;">
                <h3>ФИО: {{$FullName}}</h3>
                <h3>Должность: {{$Position}}</h3>
                <h3>Эл. почта: {{$Email}}</h3>
                <br>
                <h3>О себе: </h3>
                <p>{{$Description}}</p>
    </div>
</div>
@endsection

