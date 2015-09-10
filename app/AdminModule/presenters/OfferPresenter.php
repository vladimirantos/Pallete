<?php

namespace App\AdminModule\Presenters;

use App\Model\OfferService;
use Asterix\Form\AsterixForm;
use App\Model\Languages;
use Asterix\Width;
use Nette\Forms\Form;
use Asterix\ButtonTypes;
/**
 * Class OfferPresenter
 * @author Bruno Puzják
 * @version 1.0
 * @package App\AdminModule\Presenters
 */
class OfferPresenter extends AdminPresenter {

    /** @var OfferService @inject */
    public $offer;

    public function renderDefault() {
        $this->title('admin.offer.title', 'admin.offer.subtitle');
        $this->navigation->addItem('admin.offer.title', 'Offer:');
        $this->template->offers = $this->offer->getAllOffers();
    }

    protected function createComponentAddOfferForm() {
        $form = AsterixForm::horizontalForm();
        $form->setTranslator($this->translator);
        $form->addASelect('translate', 'admin.offer.form.translate', $this->offer->getAllOffersPair())->setPrompt('');
        $form->addASelect('lang', 'admin.offer.form.language', Languages::toArray());
        $form->addAText('title', 'admin.offer.form.title', Width::WIDTH_8)->setRequired($this->translator->translate('admin.offer.form.required', ['text' => '%label']))->setMaxLength(80);
        $form->addATextArea('text', 'admin.offer.form.text', Width::WIDTH_8)->setAttribute('rows', 10);
        $form->addAButtonUpload('image', 'admin.offer.form.image', Width::WIDTH_8)->addCondition(Form::FILLED)->addRule(Form::IMAGE, 'admin.offer.form.imageError');
        $form->addAText('keywords', 'admin.offer.form.keywords')->setTooltip($this->translator->translate('admin.offer.form.keywordsHelp'));
        $form->addAText('description', 'admin.offer.form.description');
        $form->addHidden('author', $this->userEntity->email);
        $form->addHidden('oldTitle', null);
        $form->addASubmit('send', 'admin.offer.form.submit', ButtonTypes::PRIMARY);
        $form->getComponent('send')->getControlPrototype()->onclick('tinyMCE.triggerSave()');
        $form->onSuccess[] = $this->addOfferSucceeded;
        return $form;
    }
    
    public function addOfferSucceeded(AsterixForm $form, $values){
        
    }

}
