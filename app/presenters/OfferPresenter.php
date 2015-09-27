<?php

namespace App\Presenters;

use Nette;
use App\Model;

class OfferPresenter extends BasePresenter {

    /** @var Model\OfferService @inject */
    public $offer;

     public function startup() {
        parent::startup();
        $this->setActive('Nabídka');
    }
    
    public function renderDefault() {
        $this->template->offers = $this->offer->getAllOffersByLang($this->locale);
        $this->title('lang.offer.title');
    }

    public function renderDetail($id){
        $this->template->offer = $this->offer->getOffer($id, $this->translator->getLocale());
    }
}
