<?php
namespace App\AdminModule\Presenters;
use Asterix\Form\AsterixForm;

/**
 * Class AccountPresenter
 * @author Vladimír Antoš
 * @version 1.0
 * @package app\AdminModule\presenters
 */
class AccountPresenter extends AdminPresenter{

    public function startup() {
        parent::startup();
    }

    public function renderDefault(){
        $this->title('admin.account.title');
        $this->navigation->addItem('admin.account.title', 'Account:');
    }

    public function renderSettings(){
        $this->title('admin.account.settings.title');
        $this->navigation->addItem('admin.account.title', 'Account:')
            ->addItem('admin.account.settings.name', 'settings');
    }

    public function renderChangePassword(){
        $this->title('admin.account.changePassword.title');
        $this->navigation->addItem('admin.account.title', 'Account:')
            ->addItem('admin.account.changePassword.title', 'Account:changePassword');
    }

    public function createComponentChangePasswordForm(){
        $form = AsterixForm::horizontalForm();
        $form->setTranslator($this->translator);
        $form->addAPassword('newPassword', 'admin.account.changePassword.new');
        $form->addAPassword('newPassword2', 'admin.account.changePassword.new2');
        $form->addASubmit('send', 'Uložit');
        return $form;
    }
}