@extends('ese.layout')

@section('pagename', 'Админ панель')

@section('content')
    <?php include(resource_path()."/CompiledUserContext/testprocess_preview.php") ?>
@endsection