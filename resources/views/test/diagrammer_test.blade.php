<!doctype html>
<html>
    <head>
        <title>@yield('pagename')|ESE-CRM</title>
        <meta name="description" content="ESE-CRM Leightweight OpenSource BPMN CRM"> 
        <meta charset="utf-8">
    </head>
    <body>
        <canvas height="1080" width="1980" id="diagramPlaceholderViewItem" class="diagramPlaceholder">
        </canvas>
        <style>
            .diagramPlaceholder{
                border:2px solid;
            }
        </style>
        <script>
            var diagramJson = '{"ProcessHeaderId":0,"ProcessName":"Тестовая схема","ProcessResponsibles":[{"ResponsibleType":"user","Responsibles":[1,2],"Align":"vertical","Caption":"Зона ответственности 1","StX":5,"StY":5,"EnX":500,"EnY":900,"Items":[{"DiagramItemId":0,"Name":"Стартовый элемент","Type":"startpoint","Posx":100,"Posy":100,"Parent":null,"LineInSide":null,"LineOutSide":null,"TaskFormId":null},{"DiagramItemId":1,"Name":"Задача 1","Type":"task","Posx":100,"Posy":200,"Parent":0,"LineInSide":"top","LineOutSide":"bottom","TaskFormId":null},{"DiagramItemId":2,"Name":"Сценар","Type":"scenario","Posx":100,"Posy":350,"Parent":1,"LineInSide":"top","LineOutSide":"bottom","TaskFormId":null},{"DiagramItemId":3,"Name":"Шлюз 1","Type":"gateway","Posx":100,"Posy":500,"Parent":2,"LineInSide":"top","LineOutSide":"bottom","TaskFormId":null},{"DiagramItemId":4,"Name":"Конечный элемент","Type":"endpoint","Posx":100,"Posy":850,"Parent":3,"LineInSide":"top","LineOutSide":"bottom","TaskFormId":null}]},{"ResponsibleType":"user","Responsibles":[1,2],"Align":"vertical","Caption":"Зона ответственности 2","StX":500,"StY":5,"EnX":1000,"EnY":900,"Items":[]}]}';
            //собираем элементы
            //собираем ЗО
            //впихиваем всё в диаграм констрактор
            
        </script>


        <script>
            ///Данная страница предназначена для тестирования диаграммера используемого в системе
            ///Диаграммер может быть использован для просмотра карты процесса, а также построения новых процессов
            ///Btw. Диаграммер это первый функционал написанный в CRM


            //TODO: ESE-4

            ///<summary>
            ///Root объект диаграммы BPMN
            ///</summary>
            class Diagram{
                constructor(processHeaderId, processName, processResponsibles){
                    this.ProcessHeaderId = processHeaderId; //id процесса
                    this.ProcessName = processName; //наименование процесса
                    this.ProcessResponsibles = processResponsibles; //объекты зон ответственности
                }
            }
            ///<summary>
            ///Объект зон ответственности диаграммы BPMN
            ///</summary>
            class DiagramProcessResponsibles{
                constructor(responsibleType,responsibles,align, caption, stX, sty, enX, enY, items){
                    this.ResponsibleType = responsibleType; //тип зоны ответственности (user, group, position) (пользователь, группа, должность)
                    this.Responsibles = responsibles; //список элементов исполнителей зоны ответственности
                    this.Align = align; //расположения текста-подписи
                    this.Caption = caption; //наименование зоны ответственности
                    this.StX = stX; //стартовая точка
                    this.StY = sty; //стартовая точка
                    this.EnX = enX;
                    this.EnY = enY;
                    this.Items = items;
                }

            }
            ///<summary>
            ///Элемент диаграммы BPMN
            ///</summary>
            class DiagramItems{
                constructor(diagramItemId, name, type, posx, posy, parent,lineInSide, lineOutSide, taskFormId){
                    this.DiagramItemId = diagramItemId;
                    this.Name = name; //название элемента
                    this.Type = type; //тип объекта (startpoint, endpoint, task, gateway, scenario)
                    this.Posx = posx; //позиция по x
                    this.Posy = posy; //позиция по y
                    this.Parent = parent; //родитель
                    this.LineInSide = lineInSide; //Сторона вхождения стрелки up/right/left/bottom
                    this.LineOutSide =  lineOutSide; //Сторона выхода стрелки up/right/left/bottom
                    this.TaskFormId = taskFormId; //id используемой формы
                }

            }

            ///<summary>
            ///Создает сэмпл. диаграмму
            ///</summary>
            function MakeSampleDiagram(){
                var _item1 = new DiagramItems(0,"Стартовый элемент", "startpoint", 100, 100, null, null, null, null);
                var _item2 = new DiagramItems(1,"Задача 1", "task", 100, 200, 0, "top","bottom", null);
                var _item3 = new DiagramItems(2,"Сценар", "scenario", 100, 350, 1, "top","bottom", null);
                var _item4 = new DiagramItems(3,"Шлюз 1", "gateway", 100, 500, 2, "top","bottom", null);
                var _item5 = new DiagramItems(4,"Конечный элемент", "endpoint", 100, 850, 3, "top","bottom", null);
                var _resp1 = new DiagramProcessResponsibles("user", [1,2], "vertical", "Зона ответственности 1", 5, 5, 500, 900, [_item1,_item2,_item3,_item4,_item5]);
                var _resp2 = new DiagramProcessResponsibles("user", [1,2], "vertical", "Зона ответственности 2", 500, 5, 1000, 900, []);
                var _resp3 = new DiagramProcessResponsibles("user", [1,2], "horizontal", "Зона ответственности 3", 1000, 5, 1500, 900, []);
                var _diagram = new Diagram(0,"Тестовая схема",[_resp1,_resp2,_resp3]);
                return _diagram;
            }

            ///
            ///Валидатор диаграммы
            ///
            function ValidateDiagram(diagramEntity){
                var isMultipleStartPoint = false;
                var isNoEndPoint = false;
                
            }

            ///<summary>
            ///Отрисовка зон ответственности
            ///</summary>
            function DiagramItem_Responsible(canvasContext, align, stX, stY, enX, enY, name){
                canvasContext.setTransform(1, 0, 0, 1, 0, 0);
                canvasContext.lineWidth = 3;
                canvasContext.strokeStyle = "#000000";
                canvasContext.lineWidth = 5;
                canvasContext.beginPath();
                canvasContext.rect(stX, stY, enX-stX, enY-stY);
                canvasContext.fillStyle = "#cdcdcd";
                if(align == "horizontal"){ 
                    
                    canvasContext.fillRect(stX, stY, 50, enY-stY);
                    canvasContext.rect(stX, stY, 50, enY-stY);
                } else if (align == "vertical"){
                    canvasContext.fillRect(stX, stY, enX-stX, 50);
                    canvasContext.rect(stX, stY, enX-stX, 50);
                }
                canvasContext.stroke();
                canvasContext.save;
                if(align == "horizontal"){ 
                    canvasContext.translate(stX+25, (enY-stY)/2);
                    canvasContext.rotate(-Math.PI/2);
                } else if (align == "vertical"){
                    canvasContext.translate(stX+(enX-stX)/2, stY+25);
                }
                canvasContext.font = "15px Arial";
                canvasContext.textAlign = "center",
                canvasContext.textBaseline = "middle";
                canvasContext.fillStyle = "#000000";
                canvasContext.fillText(name,0 ,0);
                canvasContext.restore;
                       
            }

            ///<summary>
            ///Отрисовка задачи
            ///</summary>
            function DiagramItem_Task(canvasContext, name, posX, posY){
                canvasContext.setTransform(1, 0, 0, 1, 0, 0);
                canvasContext.beginPath();
                canvasContext.roundRect(posX-75,posY-45,150,90,[10]);
                canvasContext.fillStyle = "#cdcdcd";
                canvasContext.fill();
                canvasContext.strokeStyle = '#000000';
                canvasContext.roundRect(posX-75,posY-45,150,90,[10]);
                canvasContext.stroke();
                canvasContext.font = "15px Arial";
                canvasContext.textAlign = "center",
                canvasContext.textBaseline = "middle";
                canvasContext.fillStyle = "black";
                canvasContext.fillText(name,posX,posY);
            }
            ///<summary>
            ///Отрисовка блока сценария
            ///</summary>
            function DiagramItem_Scenario(canvasContext, name, posX, posY){
                canvasContext.setTransform(1, 0, 0, 1, 0, 0);
                canvasContext.beginPath();
                canvasContext.roundRect(posX-75,posY-45,150,90,[10]);
                canvasContext.fillStyle = "#cda000";
                canvasContext.fill();
                canvasContext.strokeStyle = '#000000';
                canvasContext.roundRect(posX-75,posY-45,150,90,[10]);
                canvasContext.stroke();
                canvasContext.font = "15px Arial";
                canvasContext.textAlign = "center",
                canvasContext.textBaseline = "middle";
                canvasContext.fillStyle = "black";
                canvasContext.fillText("[Сценарий]"+name,posX,posY);   
            }
            ///<summary>
            ///Отрисовка ИЛИ шлюза
            ///</summary>
            function DiagramItem_GateWay(canvasContext, posX, posY){
                canvasContext.setTransform(1, 0, 0, 1, 0, 0);
                canvasContext.save;
                canvasContext.beginPath();
                canvasContext.translate(posX, posY-49);
                canvasContext.rotate(45 * Math.PI/180);
                canvasContext.strokeStyle = '#000000';
                canvasContext.fillStyle = "#cdcdcd";
                canvasContext.roundRect(0,0,70,70,[5]);
                canvasContext.fill();
                canvasContext.stroke();
                canvasContext.restore;
            }

            ///
            ///Отрисовка линии
            ///
            function DiagramItem_Line(canvasContext, destItem, parentItem){

                //TODO: ESE-2
                var moveToYOffset = 0;
                var moveToXOffset = 0;

                var lineToYOffset = 0;
                var lineToXOffset = 0;


                if(destItem.LineOutSide == "bottom"){ //Выход снизу
                    switch(parentItem.Type){
                        case "startpoint": moveToYOffset =  25; moveToXOffset = 0; break;
                        case "endpoint": moveToYOffset =  25; moveToXOffset = 0; break;
                        case "task": moveToYOffset =  45; moveToXOffset = 0; break;
                        case "scenario": moveToYOffset =  45; moveToXOffset = 0; break;
                        case "gateway": moveToYOffset =  49; moveToXOffset = 0; break;
                    }
                } else if(destItem.LineOutSide == "top"){ //Выход сверху
                    switch(parentItem.Type){
                        case "startpoint": moveToYOffset = -25; moveToXOffset = 0; break;
                        case "endpoint": moveToYOffset = -25; moveToXOffset = 0; break;
                        case "task": moveToYOffset = -45; moveToXOffset = 0; break;
                        case "scenario": moveToYOffset = -45; moveToXOffset = 0; break;
                        case "gateway": moveToYOffset = -49; moveToXOffset = 0; break;
                    }
                } else if(destItem.LineOutSide == "left"){  //Выход слева
                    switch(parentItem.Type){
                        case "startpoint": moveToYOffset = 0; moveToXOffset = -25; break;
                        case "endpoint": moveToYOffset = 0; moveToXOffset = -25; break;
                        case "task": moveToYOffset = 0; moveToXOffset = -75; break;
                        case "scenario": moveToYOffset = 0; moveToXOffset = -75; break;
                        case "gateway": moveToYOffset = 0; moveToXOffset = -49; break;
                    }
                }else if (destItem.LineOutSide == "right"){ //Выход справа
                    switch(parentItem.Type){
                        case "startpoint": moveToYOffset = 0; moveToXOffset = 25; break;
                        case "endpoint": moveToYOffset = 0; moveToXOffset = 25; break;
                        case "task": moveToYOffset = 0; moveToXOffset = 75; break;
                        case "scenario": moveToYOffset = 0; moveToXOffset = 75; break;
                        case "gateway": moveToYOffset = 0; moveToXOffset = 49; break;
                    }
                }
                

                if(destItem.LineInSide == "top"){ //Вход сверху
                    switch(destItem.Type){
                        case "startpoint": lineToYOffset = -25; lineToXOffset = 0; break;
                        case "endpoint": lineToYOffset = -25; lineToXOffset = 0; break;
                        case "task": lineToYOffset = -45; lineToXOffset = 0; break;
                        case "scenario": lineToYOffset = -45; lineToXOffset = 0; break;
                        case "gateway": lineToYOffset = -49; lineToXOffset = 0; break;
                    }
                } else if(destItem.LineInSide == "bottom"){ //Вход снизу
                    switch(destItem.Type){
                        case "startpoint": lineToYOffset = 25; lineToXOffset = 0; break;
                        case "endpoint": lineToYOffset = 25; lineToXOffset = 0; break;
                        case "task": lineToYOffset = 45; lineToXOffset = 0; break;
                        case "scenario": lineToYOffset = 45; lineToXOffset = 0; break;
                        case "gateway": lineToYOffset = 49; lineToXOffset = 0; break;
                    }
                } else if(destItem.LineInSide == "left"){
                    switch(destItem.Type){
                        case "startpoint": lineToYOffset = 0; lineToXOffset = -25; break;
                        case "endpoint": lineToYOffset = 0; lineToXOffset = -25; break;
                        case "task": lineToYOffset = 0; lineToXOffset = -75; break;
                        case "scenario": lineToYOffset = 0; lineToXOffset = -75; break;
                        case "gateway": lineToYOffset = 0; lineToXOffset = -49; break;
                    }
                } else if(destItem.LineInSide == "right"){
                    switch(destItem.Type){
                        case "startpoint": lineToYOffset = 0; lineToXOffset = 25; break;
                        case "endpoint": lineToYOffset = 0; lineToXOffset = 25; break;
                        case "task": lineToYOffset = 0; lineToXOffset = 75; break;
                        case "scenario": lineToYOffset = 0; lineToXOffset = 75; break;
                        case "gateway": lineToYOffset = 0; lineToXOffset = 49; break;
                    }
                }

                drawLineWithArrow(canvasContext,parentItem.Posx+moveToXOffset,parentItem.Posy+moveToYOffset,destItem.Posx + lineToXOffset,destItem.Posy + lineToYOffset);
            }
            ///
            ///Отрисовка линии со стрелкой на конце
            ///
            function drawLineWithArrow(canvasContext,stX,stY,EnX,EnY){
                canvasContext.setTransform(1,0,0,1,0,0);
                canvasContext.save;
                var dx=EnX-stX;
                var dy=EnY-stY;
                var angle=Math.atan2(dy,dx);
                var length=Math.sqrt(dx*dx+dy*dy);
                canvasContext.lineWidth = 2;
                canvasContext.strokeStyle = '#000000';
                canvasContext.beginPath();
                canvasContext.moveTo(stX,stY);
                canvasContext.lineTo(EnX,EnY);
                canvasContext.translate(stX,stY);
                canvasContext.rotate(angle);
                canvasContext.moveTo(length-7,-5);
                canvasContext.lineTo(length,0);
                canvasContext.lineTo(length-7,5);
                canvasContext.stroke();
                canvasContext.restore;
                
            }

            ///<summary>
            ///Отрисовка стартового элемента
            ///</summary>
            function DiagramItem_StartItem(canvasContext, posX, posY){
                canvasContext.setTransform(1, 0, 0, 1, 0, 0);
                canvasContext.save;
                canvasContext.strokeStyle = "#22c821"; //green
                canvasContext.lineWidth = 2;
                canvasContext.beginPath();
                canvasContext.arc(posX, posY, 25, 0, 2 * Math.PI);
                canvasContext.stroke();
                canvasContext.restore;
            }

            ///<summary>
            ///Отрисовка конечного элемента
            ///</summary>
            function DiagramItem_EndItem(canvasContext, posX, posY){
                canvasContext.setTransform(1, 0, 0, 1, 0, 0);
                canvasContext.save;
                canvasContext.strokeStyle = "#c82124"; //red
                canvasContext.lineWidth = 5;
                canvasContext.beginPath();
                canvasContext.arc(posX, posY, 25, 0, 2 * Math.PI);
                canvasContext.stroke();
                canvasContext.restore;
            }

            function DiagramItem_Notification(canvasContext, name, posX, posY){
                //TODO: ESE-5
            }

            function DiagramItem_Timer(canvasContext, posX, posY){
                //TODO: ESE-7
            }
            function DiagramItem_Event(canvasContext, posX, posY){
                //TODO: ESE-
            }

            function DiagramItem_SubProcess(canvasContext, name, posX, posY){
                //TODO: ESE-
                //Возможно введение нового аттрибута(?) 
                //Унаследовать стиль с задачи

            }




            function parseJson(json){
                try{
                    jsonData = xhr.responseText;
                    jsonData = jsonData.replaceAll('/"','\\"');
                    return JSON.parse(jsonData);  
                }
                catch(error) {
                    alert('Произошла ошибка ParseJson');
                }
                
            }

            ///
            ///Создать карту процесса
            ///
            function createDiagramMap(diagramEntity, canvasId){
                //createDiagramMap(MakeSampleDiagram(),"diagramPlaceholderViewItem")
                var editor = true;
                if(editor){
                    createDiagramCoordLines(canvasId, 20);
                }
                
                var canvas = document.getElementById(canvasId);  
                var canvasContext = canvas.getContext("2d");  
                let itemsList = new Array(0); //общий массив айтемов для генерации стрелок
                //Рендер объектов диаграммы
                for(var r = 0; r < diagramEntity.ProcessResponsibles.length; r++){
                    DiagramItem_Responsible(canvasContext,diagramEntity.ProcessResponsibles[r].Align,diagramEntity.ProcessResponsibles[r].StX,diagramEntity.ProcessResponsibles[r].StY,diagramEntity.ProcessResponsibles[r].EnX,diagramEntity.ProcessResponsibles[r].EnY,diagramEntity.ProcessResponsibles[r].Caption);
                    for(var i=0; i<diagramEntity.ProcessResponsibles[r].Items.length;i++){
                        itemsList.push(diagramEntity.ProcessResponsibles[r].Items[i]);
                        switch(diagramEntity.ProcessResponsibles[r].Items[i].Type){
                            
                            case "startpoint": DiagramItem_StartItem(canvasContext,diagramEntity.ProcessResponsibles[r].Items[i].Posx, diagramEntity.ProcessResponsibles[r].Items[i].Posy); break;
                            case "endpoint": DiagramItem_EndItem(canvasContext, diagramEntity.ProcessResponsibles[r].Items[i].Posx, diagramEntity.ProcessResponsibles[r].Items[i].Posy); break;
                            case "task": DiagramItem_Task(canvasContext, diagramEntity.ProcessResponsibles[r].Items[i].Name, diagramEntity.ProcessResponsibles[r].Items[i].Posx, diagramEntity.ProcessResponsibles[r].Items[i].Posy); break;
                            case "scenario": DiagramItem_Scenario(canvasContext, diagramEntity.ProcessResponsibles[r].Items[i].Name, diagramEntity.ProcessResponsibles[r].Items[i].Posx, diagramEntity.ProcessResponsibles[r].Items[i].Posy); break;
                            case "gateway": DiagramItem_GateWay(canvasContext, diagramEntity.ProcessResponsibles[r].Items[i].Posx, diagramEntity.ProcessResponsibles[r].Items[i].Posy); break;
                            default: console.error(diagramEntity.ProcessResponsibles[r].Items[i].Type +" is an unknown diagram item type"); break; //TODO : ESE-1 
                        }
                    }
                }
                //Рендер стрелок
                for(var i = 0; i<itemsList.length;i++){
                    if(itemsList[i].Parent != null){
                        var destItem = itemsList[i];
                        var parentItem = itemsList.find(element => element.DiagramItemId == itemsList[i].Parent);
                        //console.log(itemsList[i].Name+" "+itemsList[i].DiagramItemId+" "+itemsList[i].Parent);
                        DiagramItem_Line(canvasContext,destItem,parentItem);
                        
                    }

                }
            }

            function createDiagramCoordLines(canvasId, offset){
                var canvas = document.getElementById(canvasId);  
                var canvasContext = canvas.getContext("2d");  
                //x coord
                for(var x = 0; x < canvas.width; x){
                    x=x+offset;
                    canvasContext.moveTo(x, 0);
                    canvasContext.lineTo(x, canvas.height);
                    canvasContext.strokeStyle = '#cdcdcd';
                    canvasContext.stroke();
                }
                //y coord
                for(var y = 0; y < canvas.height; y){
                    y=y+offset;
                    canvasContext.moveTo(0, y);
                    canvasContext.lineTo(canvas.width, y);
                    canvasContext.strokeStyle = '#cdcdcd';
                    canvasContext.stroke();
                }
            }
           

        </script>


    </body>

