<?php
/* EseAPP custom page */

/*Для корректной работы, ни в коем случае не изменяйте исходный код находящийся
вне тегов ScenarioZone, EndScenarioZone,ViewZone, EndViewZone, UseZone, EndUseZone, VariableZone, EndVariableZone
*/
/*----------UseZone----------*/
    use Illuminate\Support\Facades\DB;
    








/*----------EndUseZone----------*/
class Context extends ContextCore{
/*----------VariableZone----------*/
public string $testString = 'hello!';








/*----------EndVariableZone----------*/
/*----------ScenarioZone----------*/
//Пример работы обработчика OnPreload - срабатывает перед выводом View контента
function OnPreload(){
    $this->testString = DB::table('user')->select('FirstName')->where([['id','=',3]])->get()[0]->FirstName;
}
//Пример работы обработчика OnLoaded - срабатывает после вывода View контента
function OnLoaded(){       

}
//Кастомная функция
function HelloWorld(){
    return "Hello World!";
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
$_context = new Context();
$_context->OnPreload();
?>
<!----------ViewZone---------->
<br>
<div class="panel">
        <h1><?php echo $_context->testString; ?></h1>
</div>
<p class="w-tooltip" data-descr="test">teeest</p>
</br>
<?php 
 echo 'HelloWorld'
 ?>








<!----------EndViewZone---------->
<?php
$_context->OnLoaded();
?>