<?php

namespace App\Components\TextCmp\Forms;

use Nette,
	Nette\Application\UI\Form;


trait textFormCreate{
   /** @var \App\Components\TextDbParamCmp\Model\Texty */
    private $modelTexty;
    
    /** @var array */
    public $onProcessedText = array();
    public $idText;
   
    public function _constText(\App\Components\TextDbParamCmp\Model\Texty $modelTexty)
    {
            $this->modelTexty = $modelTexty;
    }
    
    public function createText()
    {
        $this->form->addHidden("cmp_text_id");
        $this->form->addTextArea('text', '')
                ->setRequired('Tato hodnota nemůže být prázdná.')
                ->setAttribute("class", "ckeditor")
                ->setHtmlId("ckeditor");
        //$this->form->addSubmit('ulozit', 'Uložit')->setAttribute("class", "btn submit-btn");
        //$this->form->getElementPrototype()->onsubmit('CKEDITOR.instances["ckeditor"].updateElement()');
        $this->form->getElementPrototype()->onclick('CKEDITOR.instances["ckeditor"].updateElement()');
        $this->form->onSuccess[] = $this->formSucceededText;
    }
    
    public function formSucceededText(\Nette\Application\UI\Form $form)
    {   
        //dump("formSucceededText");
        $values = $form->getValues();
        //if($this->presenter->user->isAllowed("sprava-obsahu"))
            if($textRow=$this->modelTexty->findOneById($values->cmp_text_id)){
                //if($this->modelTexty->update($values->cmp_text_id, $values->text)){
                $this->modelTexty->update($values->cmp_text_id, $values->text);
                $this->onProcessedText($values->cmp_text_id);
		$this->idText = $values->cmp_text_id;
            }
            else{
                $textRow = $this->modelTexty->insert($values);
                $this->onProcessedText($textRow->id);
		$this->idText=$textRow->id;
            }
    }
}

class TextFormFactory extends \App\Forms\AbstractFormFactory
{    
    use textFormCreate{textFormCreate::createText as public textCr; textFormCreate::_constText as public textConst;}
    
    public function __construct(\App\Components\TextDbParamCmp\Model\Texty $modelTexty)
    {
        $this->textConst($modelTexty);
    }

    /**
     * @return Form
     */
    public function create()
    {
        parent::create();
        $this->textCr();
	
        $this->form->addSubmit('ulozit', 'Uložit')->setAttribute("class", "btn submit-btn");
        
	return $this->form;
    }
}
