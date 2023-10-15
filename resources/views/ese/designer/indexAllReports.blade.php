@extends('ese.designer.index')

@section('pagename', 'Отчеты - ESE-CRM Dev. Studio')
@section('devStudioSectionName', 'Отчеты - ')
@section('DevStudioContent')
<table class="paneltable" style="color:black; background-color:white;">
    <tr>
        
        <th>Наименование</th>
        <th>Просмотр</th>
        <th>Редактирование</th>
    </tr>
    @foreach($allReports as $report)
    <tr>
        <td>{{$report->visiblename}}</td>
        <td><a class="button2" href="{{ route('ViewReport', ['reportid'=>$report->id]) }}">Просмотр</a></td>
        <td><a class="button2" href="{{ route('DevStudioEditUIReport', ['reportid'=>$report->id]) }}">Редактировать</a></td>
    </td>
    @endforeach
</table>
    
@endsection