<?php
/* EseAPP custom Widgets */

/*Для корректной работы, ни в коем случае не изменяйте исходный код находящийся
вне тегов ScenarioZone, EndScenarioZone,ViewZone, EndViewZone, UseZone, EndUseZone, VariableZone, EndVariableZone
*/
/*----------UseZone----------*/
//test
    









/*----------EndUseZone----------*/
class Context_testwidget extends ContextCore{
/*----------VariableZone----------*/
public string $testString = 'Hello World 2!';









/*----------EndVariableZone----------*/
/*----------ScenarioZone----------*/
//Пример работы обработчика OnPreload - срабатывает перед выводом View контента
function OnPreload(){
    
}
//Пример работы обработчика OnLoaded - срабатывает после вывода View контента
function OnLoaded(){       

}
//Кастомная функция
function HelloWorld(){
    return "Hello World 1!";
}
        









/*----------EndScenarioZone----------*/
}
class ContextCore{
    public function OnPreload(){             
    }
    public function OnLoaded(){             
    }
}
?>
<?php
$_context = new Context_testwidget();
$_context->OnPreload();
?>
<!----------ViewZone---------->
<!--Вывод кастомного сценария -->
<h1><?php echo $_context->HelloWorld(); ?></h1>
<!--Вывод кастомной переменной -->
<h1><?php echo $_context->testString; ?></h1>
<!----------EndViewZone---------->
<?php
$_context->OnLoaded();
?>