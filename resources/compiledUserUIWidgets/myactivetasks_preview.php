<?php
/* EseAPP custom Widgets */

/*Для корректной работы, ни в коем случае не изменяйте исходный код находящийся
вне тегов ScenarioZone, EndScenarioZone,ViewZone, EndViewZone, UseZone, EndUseZone, VariableZone, EndVariableZone
*/
/*----------UseZone----------*/
use Illuminate\Support\Facades\DB;


/*----------EndUseZone----------*/
class Context_myactivetasks extends WidgetContextCore{
/*----------VariableZone----------*/
//Здесь вы можете описать кастомные переменные, с которыми будете работать в классе












/*----------EndVariableZone----------*/
/*----------ScenarioZone----------*/
//Кастомная функция
function GetTasks(){
    $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId(app('request'));
    return DB::table('taskbase')->select('taskbase.id as TaskId','taskbase.Name as TaskName','taskbase.StartDate as TaskStarDate','taskbase.DeadlineDate as TaskDeadlineDate','taskbase.EndDate as TaskEndDate','Author.id as AuthorId','Author.LastName as AuthorLastName','Author.MiddleName as AuthorMiddleName','Author.FirstName as AuthorFirstName','Executor.id as ExecutorId','Executor.LastName as ExecutorLastName', 'Executor.MiddleName as ExecutorMiddleName', 'Executor.FirstName as ExecutorFirstName')->join('user as Author','Author.id','=', 'taskbase.Author')->join('user as Executor','Executor.id','=','taskbase.Executor')->where([['Executor','=',$currentuserId]])->get();
}
        












/*----------EndScenarioZone----------*/
}
?>
<?php
$_context = new Context_myactivetasks();
$_context->OnPreload();
?>
<!----------ViewZone---------->
    <table class="paneltable">
        <tr>
            <th>Наименование</th>
            <th>Автор</th>
            <th>Дата создания</th>
            <th>Дата исполнения</th>
        </tr>
        <?php 
        $tasks = $_context->GetTasks();
        foreach($tasks as $taskItem){
            echo '<tr>';
            echo '<td><a href="'.route('TaskBaseView',['id' => $taskItem->TaskId]).'">'.$taskItem->TaskName.'</a></td>';
            echo '<td><a href="javascript:userInfoPopup('.$taskItem->AuthorId.',\'userinfopopup\')">'.$taskItem->AuthorLastName.' '.$taskItem->AuthorFirstName.' '.$taskItem->AuthorMiddleName.'</a></td>';
            echo '<td>'.$taskItem->TaskStarDate.'</td>';
            echo '<td>'.$taskItem->TaskDeadlineDate.'</td>';
            echo '</tr>';
        }
        ?>
    </table>



<!----------EndViewZone---------->
<?php
$_context->OnLoaded();
?>