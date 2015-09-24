<?php

namespace App\Presenters;

use Nette;
use App\Model;
use App\Model\Entity\Gallery;


class GalleryPresenter extends BasePresenter {

    /** @var Model\GalleryService @inject */
    public $gallery;

    public function startup() {
        parent::startup();
        Gallery::extensionMethod('getImages', function(Gallery $gallery) {
            return $this->gallery->getImages($gallery->idGallery, $gallery->lang);
        });
        //todo: Metoda getImages vrace pouze pole a ne callback?
        Gallery::extensionMethod('getImage', function(Gallery $gallery) {
            foreach ($this->gallery->getImages($gallery->idGallery, $gallery->lang) as $path => $image)
                return $path;
        });
    }

    public function renderDefault() {
        $this->template->galleries = $this->gallery->getAllByLang($this->locale );
        $this->template->galleryPath = galleryPath;
        $this->title('lang.gallery.title');
    }

    public function renderDetail($id,$lang) {
    }
    
}
