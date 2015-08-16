<?php
namespace App\Model;
use app\model\Repository\ILogRepository;

/**
 * Class LogService
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model
 */
class LogService {

    /** @var ILogRepository */
    private $logRepository;

    public function __construct(ILogRepository $logRepository) {
        $this->logRepository = $logRepository;
    }

    /**
     * @param int $idUser
     * @param int $ip
     */
    public function save($idUser, $ip){
        $this->logRepository->insertToLog($idUser, $ip);
    }
}