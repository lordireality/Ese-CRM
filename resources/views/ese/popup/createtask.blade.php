@php
    if(isset($popupid) == false){
        $popupid = "createtaskpopup";
    }
@endphp

<div class="popupBlocker" id="{{$popupid}}_blocker"></div>
<div class="popup" id="{{$popupid}}">
    <div style="width:100%">
        <h3 class="popupHeader" style="float:left; margin: 15px;">Создать задачу</h3>
        <a class="button1 popupHeader" style="float:right" href="javascript:thisPopupClose('{{$popupid}}')">X</a>
    </div>
    <hr>
    <div id="popupContent" style="text-align:left; padding:5px;">
        <b>Тема задачи</b>
        <input type=text id="{{$popupid}}_TaskName">
        <hr>
        <b>Описание задачи:</b>
        <textarea id="{{$popupid}}_TaskDescription" style="width:100%; height:250px; resize: vertical;"></textarea>
        <hr>
        <b>Исполнитель:</b>
        <select id="{{$popupid}}_TaskExecutor">
            
        </select>
        <hr>
        <b>Контрольный срок:</b>
        <input type="datetime-local" id="{{$popupid}}_TaskDeadline">
    </div>
    <hr>
    <div class="popupButtons" style="text-align:right">
        <a class="button2" href="javascript:CreateTask('{{$popupid}}')">Создать задачу</a>
        <a class="button2" href="javascript:thisPopupClose('{{$popupid}}')">Закрыть</a>
    </div>
</div>