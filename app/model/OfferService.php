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

    public function __construct(OfferRepository $offerRepository) {
        $this->offerRepository = $offerRepository;
    }

    /**
     * @return Offer[]
     */
    public function getAllOffers() {
        return $this->offerRepository->findAll();
    }

    public function getAllOffersByLang($lang) {
        return $this->offerRepository->findAllByLang($lang);
    }

    public function getAllOffersPair() {
        return $this->offerRepository->findPairsByLang(Languages::CS);
    }

    /**
     * Vrátí nabídku na základě nadpisu a jazykové verze.
     * @param String title
     * @param string $lang
     * @return Offer
     * @throws NotFoundException
     */
    public function getOffer($idOffer, $lang) {
        return $this->offerRepository->find($idOffer, $lang);
    }

    /**
     * @param array $data
     * @throws EntityExistsException Pokud existuje nabídka se stejným nadpisem.
     */
    public function save(array $data) {
        return $this->offerRepository->insert($data);
    }

    public function edit(array $data, $idOffer, $lang) {
        unset($data['idOffer']);
        unset($data['language']);
        return $this->offerRepository->update($data, ['idOffer' => $idOffer, 'lang' => $lang]);
    }

    /**
     * @param int $id
     * @param string $lang
     */
    public function delete($id, $lang) {
        $this->offerRepository->delete(['idOffer' => $id, 'lang' => $lang]);
    }

}
