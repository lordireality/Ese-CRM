@php
    if(isset($popupid) == false){
        $popupid = "changetaskexecutorpopup";
    }
@endphp

<div class="popupBlocker" id="{{$popupid}}_blocker"></div>
<div class="popup" id="{{$popupid}}">
    <div style="width:100%">
        <h3 class="popupHeader" style="float:left; margin: 15px;">Переназначить</h3>
        <a class="button1 popupHeader" style="float:right" href="javascript:thisPopupClose('{{$popupid}}')">X</a>
    </div>
    <hr>
    <div id="popupContent" style="text-align:left; padding:5px;">
        <b>Исполнитель:</b>
        <select id="{{$popupid}}_TaskExecutor">
            
        </select>
    </div>
    <hr>
    <div class="popupButtons" style="text-align:right">
    <?php if(isset($taskData)){
            echo '<a class="button2" href="javascript:ChangeTaskExecutor(\''.$popupid.'\','.$taskData->id.')">Переназначить</a>';
        }
        ?>
        <a class="button2" href="javascript:thisPopupClose('{{$popupid}}')">Закрыть</a>
    </div>
</div>