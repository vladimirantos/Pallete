<?php
namespace App\AdminModule\Presenters;
use App\Model\ArticleService;
use Asterix\ButtonTypes;
use Asterix\Form\AsterixForm;
use Asterix\Width;
use Nette\Forms\Form;

/**
 * Class ArticlePresenter
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\AdminModule\Presenters
 */
class ArticlePresenter extends AdminPresenter {

    /** @var ArticleService @inject */
    public $article;

    public function startup(){
        parent::startup();
    }

    public function renderDefault(){
        $this->title('admin.article.title', 'admin.article.subtitle');
        $this->navigation->addItem('admin.article.title', 'Article:');
        $this->template->articles = $this->article->getAllArticles();
        b($this->template->articles);
    }

    protected function createComponentAddArticleForm(){
        $form = AsterixForm::horizontalForm();
        $form->setTranslator($this->translator);
        $form->addAText('title', 'admin.article.form.title', Width::WIDTH_8)->setMaxLength(80);
        $form->addATextArea('text', 'admin.article.form.text', Width::WIDTH_8)->setAttribute('rows', 10);
        $form->addAButtonUpload('image', 'admin.article.form.image', Width::WIDTH_8)->addRule(Form::IMAGE, 'admin.article.form.imageError');
        $form->addASubmit('send', 'admin.article.form.submit', ButtonTypes::PRIMARY);
        $form->onSuccess[] = $this->errorForm;
        return $form;
    }

    public function errorForm(AsterixForm $form) {
        $this->flashMessage('CHYBAAA');
        $this->redrawControl('modal');
    }
}