@php
    if(isset($popupid) == false){
        $popupid = "addtaskcommentpopup";
    }
@endphp

<div class="popupBlocker" id="{{$popupid}}_blocker"></div>
<div class="popup" id="{{$popupid}}">
    <div style="width:100%">
        <h3 class="popupHeader" style="float:left; margin: 15px;">Добавить комментарий</h3>
        <a class="button1 popupHeader" style="float:right" href="javascript:thisPopupClose('{{$popupid}}')">X</a>
    </div>
    <hr>
    <div id="popupContent" style="text-align:left; padding:5px;">
        <textarea id="{{$popupid}}_CommentText" style="width:100%; height:250px; resize: vertical;"></textarea>
        <hr>
        <input type="file" id="{{$popupid}}_CommentAttach">
    </div>
    <hr>
    <div class="popupButtons" style="text-align:right">
        <?php if(isset($taskData)){
            echo '<a class="button2" href="javascript:AddCommentTask(\''.$popupid.'\','.$taskData->id.')">Добавить комментарий</a>';
        }
        ?>
        
        <a class="button2" href="javascript:thisPopupClose('{{$popupid}}')">Закрыть</a>
    </div>
</div>