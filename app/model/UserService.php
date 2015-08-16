<?php
namespace App\Model;
use App\Model\Entity\User;
use App\Model\Repository\IUserRepository;

/**
 * Fasáda nad UserRepository.
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model
 */
class UserService {

    /** @var IUserRepository */
    private $userRepository;

    public function __construct(IUserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     */
    public function save(array $data){
        $this->userRepository->insert($data);
    }

    /**
     * @param array $data
     * @param array $by
     */
    public function edit(array $data, array $by){
        $this->userRepository->update($data, $by);
    }

    /**
     * @param string $email
     * @return User
     */
    public function getByEmail($email) {
        return $this->get(['email' => $email]);
    }

    /**
     * Vrací informace o uživatelích podle ID nebo pole zadaných parametrů.
     * Pokud je parametr $by null, vrátí všechny záznamy.
     * @param int|array $by
     * @return User|User[]
     */
    public function get($by = null){
        if($by == null)
            return $this->userRepository->findAll();
        elseif(is_int($by))
            return $this->userRepository->findById($by);
        return $this->userRepository->findBy($by); // array
    }
}