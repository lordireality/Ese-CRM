@php
    if(isset($popupid) == false){
        $popupid = "2fapopup";
    }
    if(isset($twoFAAction) == false){
        $twoFAAction = "auth";
    }
@endphp

<div class="popupBlocker" id="{{$popupid}}_blocker"></div>
<div class="popup" id="{{$popupid}}">
    <div style="width:100%">
        <h3 class="popupHeader" style="float:left; margin: 15px;">Подтверждение действия</h3>
        <a class="button1 popupHeader" style="float:right" href="javascript:twofaPopupClose('{{$popupid}}')">X</a>
    </div>
    <hr>
    <div id="popupContent" style="text-align:left">
        <div class="twoFAInputContainer"> 
            <input class="twoFAInputBox" type="number" min="0" max="9" maxlength="1" placeholder=" " id="2FAn1" oninput="if(this.value.length > 0){ this.nextElementSibling.focus(); } if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autofocus>
            <input class="twoFAInputBox" type="number" min="0" max="9" maxlength="1" placeholder=" " oninput="if(this.value.length > 0){ this.nextElementSibling.focus(); } if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="2FAn2">
            <input class="twoFAInputBox" type="number" min="0" max="9" maxlength="1" placeholder=" " oninput="if(this.value.length > 0){ this.nextElementSibling.focus(); } if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="2FAn3">
            <input class="twoFAInputBox" type="number" min="0" max="9" maxlength="1" placeholder=" " oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="2FAn4">
        </div>
    </div>
    <hr>
    <div class="popupButtons" style="text-align:right">
        <a class="button2" href="javascript:submit2fa('{{$popupid}}','{{$twoFAAction}}')">Подтвердить</a>
        <a class="button2" href="javascript:twofaPopupClose('{{$popupid}}')">Отмена</a>
    </div>
    <script>
        function twofaPopupClose(popupid){

        }
        function submit2fa(popupid, action){
            if(action == null){ return; }
            switch (action){
                case "auth": return;
                default: return;
            }
        }

    </script>

</div>