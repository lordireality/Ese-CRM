<?php
/* EseAPP custom page */

/*Для корректной работы, ни в коем случае не изменяйте исходный код находящийся
вне тегов ScenarioZone, EndScenarioZone,ViewZone, EndViewZone, UseZone, EndUseZone, VariableZone, EndVariableZone
*/
/*----------UseZone----------*/

/*----------EndUseZone----------*/

//Описание базовых интерфейсов
class Context {
    public $variables = null;
    public $scenarios = null;
    public function __construct(){
        $this->variables = new UserVariables();
        $this->scenarios = new UserScenarios();
    }
}
class FormBase{
    public int $formId = 0;
    public string $formName = '';
    public $formItems = [];
    public $context;
    function onLoad(){

    }
    function Load(){
        echo '<div id="TaskForm'.$this->formId.'">';
        echo '<div class="panel" id="formpanel"><h1>'.$this->formName.'</h1></div>';
        if(isset($this->formItems)){
            foreach($this->formItems as $formItem){
                echo $formItem->Draw();
            }
        }
        echo '</div>';
    }
    function __construct($context, $formId, $formName){
        $this->context =$context;
        $this->formId = $formId;
        $this->formName =$formName;
    }
}


class UserVariables{
/*----------UserVariables----------*/
    public $SomeText;

    public function __construct(){
        $this->SomeText = new ESE_String("Текст","ttttttt",false);
        
    }
/*----------EndUserVariables----------*/
}
class UserScenarios{
/*----------UserScenarious----------*/

/*----------EndUserScenarious----------*/
}

$context = new Context();
$forms = [];
/*----------UserForms----------*/
$form1 = new FormBase($context, 1, 'Тестовая задача 1');
$form2 = new FormBase($context, 2, 'Тестовая задача 2');
$form1->formItems = [$context->variables->SomeText];
$form2->formItems = [];
$forms = [$form1,$form2];
/*----------EndUserForms----------*/

$currentFormObj = null;
foreach($forms as $form){
    if($form->formId == $currentFormId){
        $currentFormObj = $form;
    }
}
if(isset($currentFormObj)){
    $currentFormObj->Load();
    $currentFormObj->onLoad();
} else {
    echo '<h1>Форма с ID: '.$currentFormId.' не существует!</h1>';
}












class IVariable{
    public string $VisibleName;
    private string $TypeOf = 'IVariable';
    public $Value;
    public bool $readOnly = false;
    public function HTMLHelper(){
        if($this->readOnly == true){
            $HtmlHelper = '<div><p>'.$this->VisibleName.'</p><input type="text" value="'.$this->Value.'" readonly></div>';
        } else if($this->readOnly == false){
            $HtmlHelper = '<div><p>'.$this->VisibleName.'</p><input type="text" value="'.$this->Value.'"></div>';
        }
        return $HtmlHelper;
    }
    public function Draw(){
        echo $this->HTMLHelper();
    }
    public function GetType(){
        return $this->TypeOf;
    }
    public function __construct(string $Name, string $Value = null, bool $readOnly = true){
        $this->VisibleName = $Name;
        $this->Value = $Value;
        $this->readOnly = $readOnly;
    }
}

//Все типы контекстных переменных
class ESE_String extends IVariable{
    
}
class ESE_Text extends IVariable{
    
    public function Draw(){
        $HtmlHelper = '<p>'.$this->VisibleName.'</p><textarea>'.$this->Value.'</textarea>';
        return $HtmlHelper;
    }
}

class ESE_BigInt extends IVariable{

}
class ESE_DateTime extends IVariable{

}
class ESE_DropDownItem extends IVariable{

}
class ESE_CheckBox extends IVariable{ 

}
class ESE_Task extends IVariable{

}
class ESE_HREF extends IVariable{

}
class ESE_HTMLText extends IVariable{

}
?>