@php
    if(isset($popupid) == false){
        $popupid = "setWidgetToZone";
    }
@endphp

<div class="popupBlocker" id="{{$popupid}}_blocker"></div>
<div class="popup" id="{{$popupid}}">
    <div style="width:100%">
        <h3 class="popupHeader" style="float:left; margin: 15px;">Установить виджет</h3>
        <a class="button1 popupHeader" style="float:right" href="javascript:thisPopupClose('{{$popupid}}')">X</a>
    </div>
    <hr>
    <div id="popupContent" style="text-align:left; padding:5px;">
        <b>Виджет:</b>
        <select id="{{$popupid}}_widget">
        </select>
        <input type="text" id="{{$popupid}}_zoneNum" hidden>
    </div>
    <hr>
    <div class="popupButtons" style="text-align:right">
        <a class="button2" href="javascript:SetWidgetToZone('{{$popupid}}')">Установить</a>       
        <a class="button2" href="javascript:thisPopupClose('{{$popupid}}')">Отмена</a>
    </div>
</div>