@php
    if(isset($popupid) == false){
        $popupid = "userinfopopup";
    }
@endphp

<div class="popupBlocker" id="{{$popupid}}_blocker"></div>
<div class="popup" id="{{$popupid}}">
    <div style="width:100%">
        <h3 class="popupHeader" style="float:left; margin: 15px;">Информация о пользователе:</h3>
        <a class="button1 popupHeader" style="float:right" href="javascript:thisPopupClose('{{$popupid}}')">X</a>
    </div>
    <hr>
    <div id="popupContent" style="text-align:left">
        <img id="{{$popupid}}_PhotoContainer" style="width:25%; display:inline-block;" src="/ese/usercontent/profile/default.png">
        <div id="{{$popupid}}_UserInfo" style="display:inline-block; vertical-align:top">
            <h3 id="{{$popupid}}_UserInfo_FullName"></h3>
            <h3 id="{{$popupid}}_UserInfo_Position"></h3>
            <h3 id="{{$popupid}}_UserInfo_Email"></h3>
            <br>
            <h3>О себе: </h3>
            <p id="{{$popupid}}_UserInfo_Description"></p>
        </div>
    </div>
    <hr>
    <div class="popupButtons" style="text-align:right">

        <a class="button2" href="javascript:thisPopupClose('{{$popupid}}')">Закрыть</a>
    </div>
</div>