@php
    if(isset($popupid) == false){
        $popupid = "changetaskstatuspopup";
    }
@endphp

<div class="popupBlocker" id="{{$popupid}}_blocker"></div>
<div class="popup" id="{{$popupid}}">
    <div style="width:100%">
        <h3 class="popupHeader" style="float:left; margin: 15px;">Изменить статус задачи</h3>
        <a class="button1 popupHeader" style="float:right" href="javascript:thisPopupClose('{{$popupid}}')">X</a>
    </div>
    <hr>
    <div class="popupButtons" style="text-align:right">
        <?php if(isset($taskData)){
            if(is_null($taskData->EndDate)){
                echo '<a class="button2" href="javascript:CloseTask(\''.$popupid.'\','.$taskData->id.')">Задача выполнена</a>';
            } else {
                echo '<a class="button2" href="javascript:ReopenTask(\''.$popupid.'\','.$taskData->id.')">Переоткрыть задачу</a>';
            }
            
        }
        ?>
        <a class="button2" href="javascript:thisPopupClose('{{$popupid}}')">Закрыть</a>
    </div>
</div>