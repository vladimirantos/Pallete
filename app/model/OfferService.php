<?php

namespace App\Model;

use App\Model\Repository\OfferRepository;
use App\Model\Repository\FileRepository;

/**
 * Description of OffersManager
 *
 * @author Bruno Puzják
 */
class OfferService {

    /** @var OfferRepository */
    private $offerRepository;

    /** @var FileRepository */
    private $fileRepository;

    public function __construct(OfferRepository $offerRepository) {
        $this->offerRepository = $offerRepository;
    }

    /**
     * @return Offer[]
     */
    public function getAllOffers() {
        return $this->offerRepository->findAll();
    }

    public function getAllOffersPair() {
        return $this->offerRepository->findPairsByLang(Languages::CS);
    }

}
