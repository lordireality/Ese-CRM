@extends('ese.layout')

@section('pagename', 'Главная')

@section('content')
    <div class="panel" style="overflow: auto;"><h1 style="display:inline-block; margin: 10px">Главная</h1> @if($isEdit == false)<a style="display:inline-block; float: right;" class="button2" href="{{route('index',['isEdit' => true])}}">Редактировать страницу</a>@else<a class="button2" style="display:inline-block; float: right;" href="{{route('index',['isEdit' => false])}}">Закончить редактирование</a>@endif</div>
        @foreach($widgetInfo as $tmp)
            @if(!is_null($tmp->assembly))
            @include('ese.UIWidget',['assembly'=>$tmp->assembly,'visiblename'=>$tmp->visiblename,'isEdit'=>$isEdit,'num'=>$tmp->num])
            @else
            <div class="widget" id="EmptyWidgetPlaceholder">
                <div class="panel" style="overflow: auto;"><h1 @if($isEdit == true)style="display:inline-block; margin: 10px;"@endif>Виджет не установлен</h1>@if($isEdit == true)<a class="button2" href="javascript:RemoveWidgetZone({{$tmp->num}})" style="float:right;">X</a> @endif</div>
                <div class="container">
                    @if($isEdit == true)
                    <a class="button2long" href="javascript:SetWidgetPopup('setWidgetToZone',{{$tmp->num}})">Добавить виджет</a>
                    @endif
                </div>
            </div>
            @endif
        @endforeach
    
    @if($isEdit == true)
    <a class="button2long" href="javascript:AddWidgetZone()">Добавить зону для виджета</a>
    @endif
    
    <script>
        function AddWidgetZone(){
            var params = [];
            var responseRaw = HTTPPost(window.location.origin+'/api/ESE/MainPage/AddWidgetZone',params,false);
            response = JSON.parse(responseRaw);
            if(response.status == 200){
                document.location.reload(true); 
            } else {
                console.log(response.message);
            }
        }

        function RemoveWidgetZone(zoneNum){
            let params = [
            {
                "key" : "num",
                "value" : zoneNum
            }
            ];
            var responseRaw = HTTPPost(window.location.origin+'/api/ESE/MainPage/RemoveWidgetZone',params,false);
            response = JSON.parse(responseRaw);
            if(response.status == 200){
                document.location.reload(true); 
            } else {
                console.log(response.message);
            }
        }
    </script>

@endsection