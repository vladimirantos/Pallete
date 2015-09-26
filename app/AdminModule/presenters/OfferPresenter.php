<?php

namespace App\AdminModule\Presenters;

use App\Model\OfferService;
use Asterix\Form\AsterixForm;
use Asterix\Flash;
use App\Model\Languages;
use Asterix\Width;
use Nette\Forms\Form;
use Asterix\ButtonTypes;
use App\Model\Core\ArgumentException;
use App\Model\Core\EntityExistsException;

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

    public function renderDetail($idOffer, $lang) {
        $offer = $this->offer->getOffer($idOffer, $lang);
        if (!$offer)
            $this->error($this->translator->translate('admin.offer.notFound'), 404);
        if ($offer->keywords == null)
            $this->flashMessage('admin.offer.form.keywordsRequired', Flash::WARNING);
        if ($offer->description == null)
            $this->flashMessage('admin.offer.form.descriptionRequired', Flash::WARNING);
        if ($offer->keywords == null || $offer->description == null)
            $this->flashMessage('admin.offer.form.keywordsInfo', Flash::INFO); //todo: flashmessage který by se zobrazil jen jednou, aby nemusel být další if
        $this->title($offer->title);
        $this->template->offer = $offer;
        $this->template->imagePath = offerImagesPath;
        $this->navigation->addItem('admin.offer.title', 'Offer:');
        $data = $offer->toArray();
        $data['idOffer'] = $offer->idOffer;
        $this['addOfferForm']->setDefaults($data);
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
        $form->addHidden('idOffer');
        $form->addASubmit('send', 'admin.offer.form.submit', ButtonTypes::PRIMARY);
        $form->getComponent('send')->getControlPrototype()->onclick('tinyMCE.triggerSave()');
        $form->onSuccess[] = $this->addOfferSucceeded;
        return $form;
    }

    public function addOfferSucceeded(AsterixForm $form, $values) {
        try {
            if ($values->idOffer != null) {
                $this->offer->edit((array) $values, $this->params['idOffer'], $this->params['lang']);
                $this->flashMessage('admin.offer.form.success');
                $idOffer = $values['translate'] != null ? $values->translate : $values->idOffer;
                $this->redirect('this', ['idOffer' => $idOffer, 'lang' => $values['lang']]);
            } else {
                $this->offer->save((array) $values);
                $this->redirect('this');
            }
        } catch (ArgumentException $ex) {
            $this->flashMessage($this->translator->translate('admin.offer.form.required', ['text' => 'Obrazek']), Flash::ERROR);
            $this->redrawControl("addModal");
        } catch (EntityExistsException $ex) {
            $this->flashMessage('admin.offer.form.exists', Flash::ERROR);
            $this->redrawControl("addModal");
        }
    }

    public function handleDelete($id, $lang) {
        $this->offer->delete($id, $lang);
        $this->flashMessage('admin.offer.delete');
        $this->redirect('this');
    }

}
