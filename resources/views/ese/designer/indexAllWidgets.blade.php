@extends('ese.designer.index')

@section('pagename', 'Виджеты - ESE-CRM Dev. Studio')
@section('devStudioSectionName', 'Виджеты - ')
@section('DevStudioContent')
<table class="paneltable" style="color:black; background-color:white;">
    <tr>
        
        <th>Наименование</th>
        <th>Просмотр</th>
        <th>Редактирование</th>
    </tr>
    @foreach($allWidgets as $widget)
    <tr>
        <td>{{$widget->visiblename}}</td>
        <td><a class="button2" href="{{ route('UIWidgetPreviewView', ['widgetpath'=>$widget->path]) }}">Просмотр</a></td>
        <td><a class="button2" href="{{ route('DevStudioEditUIWidget', ['widgetpath'=>$widget->path]) }}">Редактировать</a></td>
    </td>
    @endforeach
</table>
    
@endsection