<!doctype html>
<html>
    <head>
        <title>Организационная структура|ESE-CRM</title>
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
            var jsonData = {!!$organizationitems!!};
            var ctx = document.getElementById('diagramPlaceholderViewItem').getContext('2d');
            
            var padding = 20;
            function drawTree(data, x, y) {
                ctx.beginPath();
                ctx.roundRect(x-75,y-45,150,90,[10]);
                ctx.fillStyle = "#cdcdcd";
                ctx.fill();
                ctx.strokeStyle = '#000000';
                ctx.roundRect(x-75,y-45,150,90,[10]);
                ctx.stroke();
                ctx.font = "15px Arial";
                ctx.textAlign = "center",
                ctx.textBaseline = "middle";
                ctx.fillStyle = "black";
                ctx.fillText(data.name,x,y);

                
                if (data.children) {
                    var childCount = data.children.length;
                    var startX = x + ((childCount * (2 * 75 + padding)) / 2);
                    var startY = y + 2 * 45 + padding;
                    
                    data.children.forEach(function(child) {
                    var childX = startX - (2 * 75 + padding) * (child.index + 0.5);
                    
                    ctx.beginPath();
                    ctx.moveTo(x, y + 45);
                    ctx.lineTo(childX, startY - 45);
                    ctx.stroke();
                    
                    drawTree(child, childX, startY);
                    });
                }
                }

                // Преобразование JSON в структуру данных для отображения
                function buildTree(jsonData) {
                var tree = {};
                var nodeMap = {};
                
                jsonData.forEach(function(item) {
                    nodeMap[item.id] = {
                    name: item.name,
                    children: [],
                    index: 0
                    };
                });
                
                jsonData.forEach(function(item) {
                    if (item.parent) {
                    var parent = nodeMap[item.parent];
                    var child = nodeMap[item.id];
                    parent.children.push(child);
                    } else {
                    tree = nodeMap[item.id];
                    }
                });
                
                function setChildIndex(node) {
                    if (node.children.length === 0) return;
                    
                    var childCount = node.children.length;
                    var startIndex = -(childCount - 1) / 2;
                    
                    node.children.forEach(function(child, index) {
                    child.index = startIndex + index;
                    setChildIndex(child);
                    });
                }
                
                setChildIndex(tree);
                
                return tree;
                }

                // Построение дерева на Canvas
                var treeData = buildTree(jsonData);
                drawTree(treeData, 75 + padding, 45 + padding);
        </script>
    </body>
</html>