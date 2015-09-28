<?php

namespace App\Presenters;

use Asterix\Form\AsterixForm;
use Asterix\Icons;
use Asterix\Width;
use Nette;
use App\Model;

class HomepagePresenter extends BasePresenter {

    /** @var Model\ArticleService @inject */
    public $article;

    /** @var array */
    public $onSendEmail = [];

    public function renderDefault() {
        $this->setActive('Domů');
    }

    public function renderNews() {
        $this->template->news = $this->article->getAllArticlesByLang($this->locale);
        $this->title('lang.news.title');
        $this->setActive('Novinky');
    }

    public function renderContact() {
        $this->title('lang.contact.title');
        $this->setActive('Kontakt');
    }

    protected function createComponentContactForm() {
        $form = AsterixForm::horizontalForm();
        $form->setTranslator($this->translator);
        $form->getElementPrototype()->class = null;
        $form->addAText('name', 'lang.contact.form.name', Width::WIDTH_10)->setRequired($this->translator->trans('lang.contact.form.required', ['text' => '%label']));
        $form->addAText('email', 'lang.contact.form.email', Width::WIDTH_10)
            ->setRequired($this->translator->trans('lang.contact.form.required', ['text' => '%label']))
            ->addRule(AsterixForm::EMAIL, 'lang.contact.form.emailFormat');
        $form->addATextArea('text', 'lang.contact.form.text', Width::WIDTH_10)->setRequired($this->translator->trans('lang.contact.form.required', ['text' => '%label']));
        $form->addASubmit('send', 'lang.contact.form.button');
        $form->onSuccess[] = $this->contactSucceeded;
        return $form;
    }

    public function contactSucceeded(AsterixForm $form, $values) {
        $this->onSendEmail($values->name, $values->email, $values->text);
        $this->flashMessage('lang.contact.form.success');
        $this->redirect('this');
    }

}
