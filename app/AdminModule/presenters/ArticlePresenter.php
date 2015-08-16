<?php
namespace App\AdminModule\Presenters;
use Asterix\Form\AsterixForm;
use Asterix\Width;

/**
 * Class ArticlePresenter
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\AdminModule\Presenters
 */
class ArticlePresenter extends AdminPresenter {

    public function startup(){
        parent::startup();
    }

    public function renderDefault(){
        $this->title('admin.article.title', 'admin.article.subtitle');
        $this->navigation->addItem('admin.article.title', 'Article:');
    }

    protected function createComponentAddArticleForm(){
        $form = AsterixForm::horizontalForm();
        $form->setTranslator($this->translator);
        $form->addAText('title', 'admin.article.form.title', Width::WIDTH_10)->setMaxLength(80);
        $form->addATextArea('text', 'admin.article.form.text', Width::WIDTH_10)->setAttribute('rows', 10);
        $form->addAButtonUpload('image', 'admin.article.form.image', null, true);
        return $form;
    }
}