<?php
/* EseAPP custom Widgets */

/*Для корректной работы, ни в коем случае не изменяйте исходный код находящийся
вне тегов ScenarioZone, EndScenarioZone,ViewZone, EndViewZone, UseZone, EndUseZone, VariableZone, EndVariableZone
*/
/*----------UseZone----------*/
use Illuminate\Routing\Router;










/*----------EndUseZone----------*/
class Context_routedebug extends WidgetContextCore{
/*----------VariableZone----------*/
//test










/*----------EndVariableZone----------*/
/*----------ScenarioZone----------*/
//test









/*----------EndScenarioZone----------*/
}
?>
<?php
$_context = new Context_routedebug();
$_context->OnPreload();
?>
<!----------ViewZone---------->
<?php

$routeCollection = Illuminate\Support\Facades\Route::getRoutes();

foreach ($routeCollection as $value) {
    echo $value->uri .'<br>';
}
?>

<!----------EndViewZone---------->
<?php
$_context->OnLoaded();
?>