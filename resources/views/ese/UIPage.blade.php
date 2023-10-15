@extends('ese.layout')

@section('pagename', $visiblename)

@section('content')
    <div class="panel"><h1>{{$visiblename}}</h1></div>
        <?php include(resource_path()."/compiledUserUI/".$assembly.'.php') ?>
    <hr>
@endsection