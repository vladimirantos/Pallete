<?php

namespace App\AdminModule\Presenters;

use App\Model\ArticleService;
use App\Model\Core\ArgumentException;
use App\Model\Core\EntityExistsException;
use App\Model\Languages;
use Asterix\ButtonTypes;
use Asterix\Flash;
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

    /** @var string */
    private $lang;

    public function startup() {
        parent::startup();
    }

    public function renderDefault() {
        $this->title('admin.article.title', 'admin.article.subtitle');
        $this->navigation->addItem('admin.article.title', 'Article:');
        $this->template->articles = $this->article->getAllArticles();
    }

    public function renderDetail($idArticle, $lang) {
        $article = $this->article->getArticle($idArticle, $lang);
        if (!$article)
            $this->error($this->translator->translate('admin.article.notFound'), 404);
        if ($article->keywords == null)
            $this->flashMessage('admin.article.form.keywordsRequired', Flash::WARNING);
        if ($article->description == null)
            $this->flashMessage('admin.article.form.descriptionRequired', Flash::WARNING);
        if ($article->keywords == null || $article->description == null)
            $this->flashMessage('admin.article.form.keywordsInfo', Flash::INFO); //todo: flashmessage který by se zobrazil jen jednou, aby nemusel být další if
        $this->title($article->title);
        $this->template->article = $article;
        $this->template->imagePath = articleImagesPath;
        $this->navigation->addItem('admin.article.title', 'Article:');
        $this->lang = $article->lang;
        $this['addArticleForm']->setDefaults($article->toArray());
    }

    protected function createComponentAddArticleForm() {
        $form = AsterixForm::horizontalForm();

        $form->setTranslator($this->translator);

        $form->addASelect('translate', 'admin.article.form.translate', $this->article->getAllArticlesPair())
                ->setPrompt('');

        $form->addASelect('language', 'admin.article.form.language', Languages::toArray())
                ->setIconBefore('fa-language')->setDefaultValue($this->lang);

        $form->addAText('title', 'admin.article.form.title', Width::WIDTH_8)
                ->setRequired($this->translator->translate('admin.article.form.required', ['text' => '%label']))
                ->setMaxLength(80);

        $form->addATextArea('text', 'admin.article.form.text', Width::WIDTH_8)
                ->setAttribute('rows', 10);

        $form->addAButtonUpload('image', 'admin.article.form.image', Width::WIDTH_8)->addCondition(Form::FILLED)
                ->addRule(Form::IMAGE, 'admin.article.form.imageError');

        $form->addAText('keywords', 'admin.article.form.keywords')
                ->setTooltip($this->translator->translate('admin.article.form.keywordsHelp'));

        $form->addAText('description', 'admin.article.form.description');

        $form->addHidden('author', $this->userEntity->email);

        $form->addHidden('idArticle', null);
        $form->addHidden('lang', null);
        $form->addASubmit('send', 'admin.article.form.submit', ButtonTypes::PRIMARY);

        $form->getComponent('send')
                ->getControlPrototype()
                ->onclick('tinyMCE.triggerSave()');

        $form->onSuccess[] = $this->addArticleSucceeded;
        return $form;
    }

    public function addArticleSucceeded(AsterixForm $form, $values) {
        try {
            if ($values->idArticle != null) {
                $this->article->edit((array) $values, $values->idArticle, $values->lang);
                $this->flashMessage('admin.article.form.success');
                $idArticle = $values['translate'] != null ? $values['translate'] : $values['idArticle'];
                $this->redirect('this', ['idArticle' => $idArticle, 'lang' => $values->language]);
            } else {
                $this->article->save((array) $values);
                $this->redirect('this');
            }
        } catch (ArgumentException $ex) {
            $this->flashMessage($this->translator->translate('admin.article.form.required', ['text' => 'Obrazek']), Flash::ERROR);
           // $this->redrawControl("addModal");
        } catch (EntityExistsException $ex) {
            $this->flashMessage('admin.article.form.exists', Flash::ERROR);
            //$this->redrawControl("addModal");
        }
    }

    public function handleDelete($id, $lang) {
        $this->article->delete($id, $lang);
        $this->flashMessage('admin.article.delete');
        $this->redirect('this');
    }

}
