<?php
namespace App\AdminModule\Presenters;
use App\Model\Entity\Gallery;
use App\Model\GalleryService;
use App\Model\Languages;
use Asterix\Form\AsterixForm;
use Asterix\Width;
use Nette\Application\UI\Form;

/**
 * Class GalleryPresenter
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\AdminModule\Presenters
 */
class GalleryPresenter extends AdminPresenter {

    /** @var GalleryService @inject*/
    public $gallery;

    public function startup() {
        parent::startup();
        Gallery::extensionMethod('getImages', function(Gallery $gallery){
            return $this->gallery->getImages($gallery->idGallery, $gallery->lang);
        });
        //todo: Metoda getImages vrace pouze pole a ne callback?
        Gallery::extensionMethod('getImage', function(Gallery $gallery){
            foreach($this->gallery->getImages($gallery->idGallery, $gallery->lang) as $path => $image)
                return $path;
        });
    }

    public function renderDefault(){
        $this->title('admin.gallery.title', 'admin.gallery.subTitle');
        $this->navigation->addItem('admin.gallery.title', 'Gallery:');
        $this->template->galleries = $this->gallery->getAll();
    }

    public function renderDetail($idGallery, $lang){
        $gallery = $this->gallery->getGallery($idGallery, $lang);
        if(!$gallery)
            $this->error($this->translator->trans('admin.commons.error'));
        $this->title($this->translator->translate('admin.gallery.detail.title', ['title' => $gallery->name]));

        $this->navigation->addItem('admin.gallery.title', 'Gallery:');
        $this->template->gallery = $gallery;
    }

    protected function createComponentGalleryForm(){
        $form = AsterixForm::horizontalForm();
        $form->setTranslator($this->translator);
        $form->addASelect('translate', 'admin.gallery.form.translate', $this->gallery->getAllArticlesPair())->setPrompt('');
        $form->addASelect('lang', 'admin.gallery.form.language', Languages::toArray())->setIconBefore('fa-language');;
        $form->addAText('name', 'admin.gallery.form.name', Width::WIDTH_8)
            ->setMaxLength(30)
            ->setRequired($this->translator->translate('admin.gallery.form.required', ['text' => '%label']));
        $form->addATextArea('text', 'Popis', Width::WIDTH_8)->setAttribute('rows', 5);
        $form->addAUpload('images', 'admin.gallery.form.image', null, true)->addCondition(Form::FILLED)->addRule(Form::IMAGE, 'admin.gallery.form.imageError');
        $form->addASubmit('send', 'admin.gallery.form.button');
        $form->onSuccess[] = $this->galleryFormSucceeded;
        return $form;
    }

    public function galleryFormSucceeded(AsterixForm $form, $values){
        $this->gallery->save((array) $values);
        $this->flashMessage('admin.gallery.form.success');
    }

    public function handleDelete($idGallery, $lang){
        $this->gallery->delete($idGallery, $lang);
        $this->flashMessage('admin.gallery.deleteSuccess');
        $this->redirect('default');
    }
}