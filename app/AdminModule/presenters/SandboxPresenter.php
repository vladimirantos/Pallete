<?php
/**
 * Created by PhpStorm.
 * User: vladi
 * Date: 09.08.2015
 * Time: 12:52
 */

namespace App\AdminModule\Presenters;


use App\Model\Core\AsterixException;
use App\Model\Order;
use Asterix\Flash;
use Asterix\Form\AsterixForm;
use Asterix\Form\Elements\AsterixText;
use Asterix\Icons;

class SandboxPresenter extends AdminPresenter{

    public function startup(){
        parent::startup();
        $this->navigation->addItem('sandbox', $this->link('default'));
        $this->title('Sandbox', 'Ukázková aplikace');
    }

    public function renderDocumentation(){
        $this->title('Dokumentace', 'Ukázka nových funkcí');
        $this->navigation->addItem('Dokumentace', 'documentation');
    }

    protected function createComponentSandboxForm(){
        $form = AsterixForm::horizontalForm();
        $form->addAText('name', 'Jméno');
        $form->addAText('lastName', 'Příjmení');
        $form->addAText('email', 'Email')->setBefore('@');
        $form->addAPassword('password', 'Heslo')->setIconBefore(Icons::UNLOCK);
        $form->addAUpload('file', 'Soubor')->setHelp('Vkládej pouze soubory ve formátu TXT')->setTooltip('Nevkládej příliš velké soubory');
        $form->addAButtonUpload('fle', 'Soubor')->setHelp('Vkládej pouze soubory ve formátu TXT')->setTooltip('Nevkládej příliš velké soubory');
        $form->addATextArea('about', 'O mě')->setHelp('Napiš zde cokoliv o sobě')->setTooltip('Tak už piš!!');
        $form->addASelect('gender', "Pohlaví", ["Muž", "Žena", "Dítě"])->setIconBefore(Icons::USER);
        $form->addACheckbox('check', 'Zaškrtni')->setHelp('Nápověda')->isReadOnly();
        $form->addASubmit('send', 'Odeslat');
        $form->onSuccess[] = $this->pokus;
        return $form;
    }

    public function pokus(AsterixForm $form, $values){
        b($values);
    }
}