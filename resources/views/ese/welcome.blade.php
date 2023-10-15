<!doctype html>
<html class="welcome">
	<head>
		<title>Добро пожаловать!|ESE-CRM</title>
		<link rel="icon" href="{{ asset('/ese/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="ESE-CRM Leightweight OpenSource BPMN CRM"> 
		<meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('/ese/content/css/mainstyle.css') }}">
        <link rel="stylesheet" href="{{ asset('/ese/content/css/theme-blue.css') }}">
	</head>
	<body>
        <div class="bodysection">
            <hr>
            <img style="height:25%; width:25%; vertical-align:baseline;" src="{{ asset('/ese/content/images/eseapplogotransparent.png') }}"/>
            <br>
            <h1>EseCRM - "Легкая BPMN CRM с открытым исходным кодом"</h1>
            <h3>v. {{ config('app.ver') }}</h3>
            <a class="button2" href="{{route('index')}}">Начать использование</a>
            <hr>
            <h2>Обратная связь:</h2>

            <hr>
            <h2>Патч логи:</h2>
            <a class="button2long" id="showNotesButton" href="javascript:showNotes()">Развернуть</a>
            <div id="patchnotes" hidden="true">
                <div style="text-align:left; width:75%; margin-left: auto; margin-right:auto; background-color:#2689c2;padding:8px; box-shadow:5px 5px 15px 0px rgb(0 0 0 / 75%); margin-top:5px;">
                    <h3>Версия 0.0.2</h3>
                    <hr>
                    <p>InitialCommit</p>
                </div>
                <div style="text-align:left; width:75%; margin-left: auto; margin-right:auto; background-color:#2689c2;padding:8px; box-shadow:5px 5px 15px 0px rgb(0 0 0 / 75%); margin-top:5px;">
                    <h3>Версия 0.0.1</h3>
                    <hr>
                    <p>1.Ура! Работа начата!</p>
                    <p>2.Добавлен диаграммер BPMN нотации</p>
                </div>

            </div>
            <script>
                function showNotes(){
                    var notesPlaceholder = document.getElementById('patchnotes');
                    if(notesPlaceholder.hidden == true){
                        notesPlaceholder.hidden = false;
                        showNotesButton.innerHTML = "Свернуть";
                    } else if(notesPlaceholder.hidden == false){
                        notesPlaceholder.hidden = true;
                        showNotesButton.innerHTML = "Развернуть";
                    }
                }
            </script>
        </div>
	</body>
</html>