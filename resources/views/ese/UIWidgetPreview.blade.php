@extends('ese.layout')

@section('pagename', $visiblename)

@section('content')
<div class="widget"  id="widget_Preview">
    <div class="panel"><h1>{{$visiblename}}</h1></div>
    <div class="container" id="widget_Preview">
    <?php include_once(resource_path()."/ContextCore/WidgetContextCore.php") ?>
    <?php include_once(resource_path()."/compiledUserUIWidgets/".$assembly.'.php') ?>
    </div>
</div>
<div class="widget">
    <div class="panel"><h1>Виджет ...</h1></div>
    <div class="container" id="DemoWidget_Preview">
        <h1>Тест...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
        <h1>...</h1>
    </div>
</div>
@endsection