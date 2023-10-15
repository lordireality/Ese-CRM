@extends('ese.layout')

@section('pagename', 'Редактирование страницы: '.$pageVisibleName)

@section('content')

    <div class="panel"><h1>Дизайнер. Редактирование виджета: {{$pageVisibleName}}</h1>
    <a class="button2" href="javascript:showEditSection('editView')">Представление виджета</a>
    <a class="button2" href="javascript:showEditSection('editScenarious')">Сценарии виджета</a>
    <a class="button2" href="javascript:showEditSection('editVariables')">Переменные виджета</a>
    <a class="button2" href="javascript:SaveWidget()">Сохранить</a>
    <a class="button2" href="javascript:EmulateWidget()">Отладка</a>
    <a class="button2" href="javascript:PublishWidget()">Опубликовать</a>
    </div>
    <br>
    <div id="editView" style="text-align:left">
        <div class="panel">
            <h3>Редактор представления</h3>
        </div>
        <textarea id="viewEditorSourceCode" hidden>{!!$view!!}</textarea>
        <div class="editor" id="viewEditor"></div>
    </div>
    <div id="editScenarious" style="text-align:left" >
        <div class="panel">
            <h3>Редактор сценариев</h3>
        </div>
        <br>
        <div class="panel">
            <h3>Сценарий:</h3>
        </div>
        <textarea id="scenariousEditorSourceCode" hidden>{!!$scenarious!!}</textarea>
        <div class="editor" id="scenariousEditor"></div>
        <br>
        <div class="panel">
            <h3>Связи:</h3>
        </div>
        <textarea id="usingsEditorSourceCode" hidden>{!!$usings!!}</textarea>
        <div class="editor" id="usingsEditor"></div>
    </div>
    <div id="editVariables" style="text-align:left" >
        <div class="panel">
            <h3>Редактор переменных</h3>
        </div>
        <textarea id="variableEditorSourceCode" hidden>{!!$variables!!}</textarea>
        <div class="editor" id="variableEditor"></div>
    </div>
    
    <hr>
    <script>var require = { paths: { 'vs': '{{ asset('/ese/content/monaco-editor/min/vs/') }}' } };</script>
    <script src="{{ asset('/ese/content/monaco-editor/min/vs/loader.js') }}"></script>
    <script src="{{ asset('/ese/content/monaco-editor/min/vs/editor/editor.main.nls.js') }}"></script>
    <script src="{{ asset('/ese/content/monaco-editor/min/vs/editor/editor.main.js') }}"></script>
    <script>
        var sections = ['editView','editScenarious','editVariables'];
        function showEditSection(sectionId){
            document.getElementById(sectionId).hidden=false;
            for(var i=0; i<sections.length;i++){
                if(sections[i] != sectionId){
                    document.getElementById(sections[i]).hidden=true;
                }
            }
        }

        var viewEditor = monaco.editor.create(document.getElementById('viewEditor'), {
             value: document.getElementById('viewEditorSourceCode').value,
             language: 'php',
             fontSize: 16
         });
         var usingsEditor = monaco.editor.create(document.getElementById('usingsEditor'), {
             value: document.getElementById('usingsEditorSourceCode').value,
             language: 'php',
             fontSize: 16
         });
         var scenariousEditor = monaco.editor.create(document.getElementById('scenariousEditor'), {
             value: document.getElementById('scenariousEditorSourceCode').value,
             language: 'php',
             fontSize: 16
         });
        var variableEditor = monaco.editor.create(document.getElementById('variableEditor'), {
             value: document.getElementById('variableEditorSourceCode').value,
             language: 'php',
             fontSize: 16
         });
         //Небольшой трюк, так как Monaco-Editor не создается на заранее скрытых панелях
         for(var i=1; i<sections.length;i++){
            document.getElementById(sections[i]).hidden=true;
        }

        function SaveWidget(){
            let saveParams = [
                {
                    "key" : "viewCode",
                    "value" : viewEditor.getValue()
                },
                {
                    "key" : "usingsCode",
                    "value" : usingsEditor.getValue()
                },
                {
                    "key" : "scenariousCode",
                    "value" : scenariousEditor.getValue()
                },
                {
                    "key" : "variableCode",
                    "value" : variableEditor.getValue()
                },
                {
                    "key" : "assemblyname",
                    "value" : "{!!$assembly!!}"
                },
                {
                    "key" : "isEmulation",
                    "value" : 1
                },
            ];
            var responseRaw = HTTPPost(window.location.origin+'/api/ESE/WEBDESIGNER/WIDGETCOMPILE',saveParams,false);
            response = JSON.parse(responseRaw);
            if(response.status == 200){
                alert('Страница сохранена!');
            } else {
                alert('Ошибка при сохранении виджета страницы!');
                console.log(response.message);
            }

        }
        function PublishWidget(){
            let saveParams = [
                {
                    "key" : "viewCode",
                    "value" : viewEditor.getValue()
                },
                {
                    "key" : "usingsCode",
                    "value" : usingsEditor.getValue()
                },
                {
                    "key" : "scenariousCode",
                    "value" : scenariousEditor.getValue()
                },
                {
                    "key" : "variableCode",
                    "value" : variableEditor.getValue()
                },
                {
                    "key" : "assemblyname",
                    "value" : "{!!$assembly!!}"
                },
                {
                    "key" : "isEmulation",
                    "value" : 1
                },
            ];
            var responseRaw = HTTPPost(window.location.origin+'/api/ESE/WEBDESIGNER/WIDGETCOMPILE',saveParams,false);
            response = JSON.parse(responseRaw);
            if(response.status == 200){
                console.log('Страница сохранена!');
            } else {
                console.log('Ошибка при сохранении страницы!');
                console.log(response.message);
            }
            let publishParams = [
                {
                    "key" : "viewCode",
                    "value" : viewEditor.getValue()
                },
                {
                    "key" : "usingsCode",
                    "value" : usingsEditor.getValue()
                },
                {
                    "key" : "scenariousCode",
                    "value" : scenariousEditor.getValue()
                },
                {
                    "key" : "variableCode",
                    "value" : variableEditor.getValue()
                },
                {
                    "key" : "assemblyname",
                    "value" : "{!!$assembly!!}"
                },
                {
                    "key" : "isEmulation",
                    "value" : 0
                },
            ];
            var responseRaw = HTTPPost(window.location.origin+'/api/ESE/WEBDESIGNER/WIDGETCOMPILE',publishParams,false);
            response = JSON.parse(responseRaw);
            if(response.status == 200){
                alert('Виджет опубликован!');
            } else {
                alert('Ошибка при публикации виджета!');
                console.log(response.message);
            }

        }
        function EmulateWidget(){
            //Сохраняем
            SaveWidget();
            //Открываем страницу с пометкой _preview.php
            window.open(window.location.origin+"/UIWidget/{!!$pagepath!!}?isEmulation=1",'_blank');
        }


         
    </script>
@endsection