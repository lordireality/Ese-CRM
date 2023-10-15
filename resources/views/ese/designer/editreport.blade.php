@extends('ese.layout')

@section('pagename', 'Редактирование отчета: '.$reportVisibleName)

@section('content')

    <div class="panel"><h1>Дизайнер. Редактирование отчета: {{$reportVisibleName}}</h1>
    <a class="button2" href="javascript:showEditSection('editView')">Представление отчета</a>
    <a class="button2" href="javascript:showEditSection('editQuery')">Запрос отчета</a>
    <a class="button2" href="javascript:showEditSection('reportSettings')">Настройки отчета</a>
    <a class="button2" href="javascript:PublishReport()">Опубликовать</a>
    </div>
    <br>
    <div id="editView" style="text-align:left">
        <div class="panel">
            <h3>Редактор представления</h3>
        </div>
        <textarea id="viewEditorSourceCode" hidden>{!!$view!!}</textarea>
        <div class="editor" id="viewEditor"></div>
    </div>
    <div id="editQuery" style="text-align:left" >
        <div class="panel">
            <h3>Редактор запроса</h3>
        </div>
        <br>
        <div class="panel">
            <h3>Запрос:</h3>
        </div>
        <div>
        <div style="width:75% !important; display:inline-block;" class="editor" id="queryEditor"></div>
        <div style="width:24.6%; display:inline-block; vertical-align:top;">
        <div class="panel" style="text-align:center; margin-top:5px;">
            <h3>Все таблицы</h3>
        </div>
        @foreach($allTables as $table)
            <a href="#" onclick="showDBColumns(this.id)" id="table_{{$table->TABLE_NAME}}" class="button2long" style="box-shadow: none; padding:0 0 0 10px; width:100%; box-sizing: border-box;margin-bottom:0px;">{{$table->TABLE_NAME}}</a>
            <ul id="columns_table_{{$table->TABLE_NAME}}" class="container" style="border-color: #2689c2; list-style-type: none; padding-inline-start: 25px;" hidden>
            @foreach(array_keys(array_column($allDBSet,'table_name'),$table->TABLE_NAME) as $key)
                <li>{{$allDBSet[$key]->column_name}} [{{$allDBSet[$key]->DATA_TYPE}}]</li>
            @endforeach
            </ul>

        @endforeach
        </div>
        </div>
        <textarea id="queryEditorSourceCode" hidden>{!!$sqlQuery!!}</textarea>
    </div>
    <div id="reportSettings"style="text-align:left">
    <div class="panel">
            <h3>Настройки отчета</h3>
        </div>
        <span>Использовать внешний источник данных [Драйвер MySQLi]: <input onchange="showExternalConnectionSettings(this.checked)" id="useExternalConnection" {{($useExternalConnection == 1) ? 'checked' : ''}} type="checkbox"></span>
        <div id="externalDataSourceSettings" {{($useExternalConnection == 0) ? 'hidden' : ''}} >
        <span>Адрес: <input id="externalDataSourceSettings_Hostname" type="text"></span>
        <span>Пользователь: <input id="externalDataSourceSettings_Username" type="text"></span>
        <span>Пароль: <input id="externalDataSourceSettings_Password" type="password"></span>
        </div>
        <br>
        <span>Использовать кастомное представление: <input type="checkbox" {{($useCustomView == 1) ? 'checked' : ''}}></span>
    </div>

    
    <hr>
    <script>
        function showExternalConnectionSettings(checked){
            if(checked == true){
                document.getElementById("externalDataSourceSettings").hidden = false;
            } else {
                document.getElementById("externalDataSourceSettings").hidden = true;
                document.getElementById("externalDataSourceSettings_Hostname").value = null;
                document.getElementById("externalDataSourceSettings_Username").value = null;
                document.getElementById("externalDataSourceSettings_Password").value = null;
            }

        }

        function showDBColumns(id){
            if(document.getElementById("columns_"+id).hidden == true){
                document.getElementById("columns_"+id).hidden = false;
            } else if(document.getElementById("columns_"+id).hidden == false) {
                document.getElementById("columns_"+id).hidden = true;
            }
        }
    </script>
    <script>var require = { paths: { 'vs': '{{ asset('/ese/content/monaco-editor/min/vs/') }}' } };</script>
    <script src="{{ asset('/ese/content/monaco-editor/min/vs/loader.js') }}"></script>
    <script src="{{ asset('/ese/content/monaco-editor/min/vs/editor/editor.main.nls.js') }}"></script>
    <script src="{{ asset('/ese/content/monaco-editor/min/vs/editor/editor.main.js') }}"></script>
    <script>
        var sections = ['editView','editQuery','reportSettings'];
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
         var queryEditor = monaco.editor.create(document.getElementById('queryEditor'), {
             value: document.getElementById('queryEditorSourceCode').value,
             language: 'sql',
             fontSize: 16
         });

         //Небольшой трюк, так как Monaco-Editor не создается на заранее скрытых панелях
         for(var i=1; i<sections.length;i++){
            document.getElementById(sections[i]).hidden=true;
        }
        /*
        PublishReport(){
            let publishParams = [
                {
                    "key" : "visiblename",
                    "value" : document.getElementById("visiblename").value 
                },
                {
                    "key" : "viewCode",
                    "value" : viewEditor.getValue()
                },
                {
                    "key" : "queryCode",
                    "value" : queryEditor.getValue()
                },
                {
                    "key" : "useExternalConnection",
                    "value" : (document.getElementById("useExternalConnection").checked ? "1" : "0")
                },
                {
                    "key" : "externalServername",
                    "value" : document.getElementById("externalDataSourceSettings_Hostname").value 
                },
                {
                    "key" : "externalUsername",
                    "value" : document.getElementById("externalDataSourceSettings_Username").value 
                },
                {
                    "key" : "externalPassword",
                    "value" : document.getElementById("externalDataSourceSettings_Password").value 
                },
                {
                    "key" : "externalPassword",
                    "value" : document.getElementById("externalDataSourceSettings_Password").value 
                }
            ];
            var responseRaw = HTTPPost(window.location.origin+'/api/ESE/WEBDESIGNER/REPORTCOMPILE',publishParams,false);
            response = JSON.parse(responseRaw);
            if(response.status == 200){
                alert('Страница опубликована!');
            } else {
                alert('Ошибка при публикации страницы!');
                console.log(response.message);
            }
        }*/


         
    </script>
@endsection