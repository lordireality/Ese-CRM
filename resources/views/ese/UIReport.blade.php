@extends('ese.layout')

@section('pagename', $visiblename)

@section('content')
    <div class="panel"><h1>{{$visiblename}}</h1></div>
        @if($useCustomView == 0)
        <table class="paneltable">
            <tr>
            @foreach(array_keys((array)$DataSource[0]) as $key)
            <th>{{$key}}</th>
            @endforeach           
            </tr>
            @for ($i = 0; $i < count($DataSource); $i++)
            <tr>
            @foreach(array_keys((array)$DataSource[$i]) as $key)
            <td>{{$DataSource[$i]->{$key} }}</td>
            @endforeach
            </tr>
            @endfor
        </table>
        @else if($useCustomView == 1)
        <?php include(resource_path()."/compiledUserUIReport/".$assembly.'.php') ?>
        @endif
    <hr>
@endsection