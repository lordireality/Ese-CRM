@extends('ese.designer.index')

@section('pagename', 'Страницы - ESE-CRM Dev. Studio')
@section('devStudioSectionName', 'Страницы - ')
@section('DevStudioContent')
<table class="paneltable" style="color:black; background-color:white;">
    <tr>
        
        <th>Наименование</th>
        <th>Путь к странице</th>
        <th>Просмотр</th>
        <th>Просмотр (черновик)</th>
        <th>Редактирование</th>
    </tr>
    @foreach($allPages as $page)
    <tr>
        <td>{{$page->visiblename}}</td>
        <td>/UIPage/{{$page->path}}</td>
        <td><a class="button2" href="{{ route('UIPageView', ['pagepath'=>$page->path]) }}?isEmulation=0">Просмотр</a></td>
        <td><a class="button2" href="{{ route('UIPageView', ['pagepath'=>$page->path]) }}?isEmulation=1">Просмотр (черновик)</a></td>
        <td><a class="button2" href="{{ route('DevStudioEditUIPage', ['pagepath'=>$page->path]) }}?isEmulation=1">Редактировать</a></td>
    </td>
    @endforeach
</table>
    
@endsection