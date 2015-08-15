<?php

namespace App\Presenters;

use Asterix\ButtonTypes;
use Asterix\Flash;
use Asterix\Form\AsterixForm;
use Asterix\Form\Elements\AsterixCheckbox;
use Asterix\Icons;
use Asterix\Width;
use Nette;
use App\Forms\SignFormFactory;


class SignPresenter extends BasePresenter
{

	public function startup(){
		parent::startup();
		$this->setLayout('loginLayout');
	}

	public function renderForget(){

	}

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = AsterixForm::horizontalForm();
		$form->setTranslator($this->translator);
		$form->addAText('email', 'lang.login.email')->setIconBefore(Icons::USER)->setWidth(Width::WIDTH_12);
		$form->addAPassword('password', 'lang.login.password')->setIconBefore(Icons::UNLOCK)->setWidth(Width::WIDTH_12);
		$form->addASubmit('send', 'lang.login.button', ButtonTypes::_DEFAULT);
		$form->onSuccess[] = $this->signInSucceeded;
		return $form;
	}

	public function signInSucceeded(AsterixForm $form, $values){
		try{
			$this->user->login($values->email, $values->password);
			$this->flashMessage('lang.login.success');
			$this->redirect('Admin:Dashboard:');
		}catch (Nette\Security\AuthenticationException $e){
			if($e->getCode() == Nette\Security\IAuthenticator::IDENTITY_NOT_FOUND)
				$this->flashMessage('lang.login.notFound', Flash::ERROR);
			if($e->getCode() == Nette\Security\IAuthenticator::INVALID_CREDENTIAL)
				$this->flashMessage('lang.login.invalidCredential', Flash::ERROR);
		}
	}

	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('lang.logout');
		$this->redirect('in');
	}

}
