<!doctype html>
<html class="welcome">
	<head>
		<title>Добро пожаловать!|ESE-CRM</title>
		<link rel="icon" href="{{ asset('/ese/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="ESE-CRM Leightweight OpenSource BPMN CRM"> 
		<meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('/ese/content/css/mainstyle.css') }}">
        <link rel="stylesheet" href="{{ asset('/ese/content/css/theme-blue.css') }}">
        <script src="{{ asset('/ese/content/js/auth.js') }}"></script>
	</head>
	<body>
        @if(config('app.UseTwoFA') == true)
        @include('ese.popup.2faSubmit',['popupid'=>'2fapopup','twoFAAction'=>'auth'])
        @endif
        <div class="bodysection">
            <div class="loginBox">
                <img style="height:25%; width:25%; vertical-align:baseline;" src="{{ asset('/ese/content/images/eseapplogotransparent.png') }}"/>
                <br>
                <h1>EseCRM Авторизация</h1>
                 <table style="text-align:left;"class="formTable">
                     <tr>
                         <td><h3><b style="color:red;">*</b>Эл. почта:</h3></td>
                         <td><input type="email" id="emailField"></td>
                    </tr>
                    <tr>
                        <td><h3><b style="color:red;">*</b>Пароль:</h3></td>
                        <td><input type="password" id="passwordField"></td>
                    </tr>
                </table>
                <a class="button2" href="javascript:Auth()">Авторизоваться</a>
                <hr>
                <p>{!!config('app.name')!!} v.{!!config('app.ver')!!}</p>
            </div>
           
        </div>
	</body>
</html>