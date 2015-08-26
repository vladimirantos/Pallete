<?php
namespace App\Model;
use Nette\Object;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;

/**
 * Class Authenticator
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model
 */
class Authenticator extends Object implements IAuthenticator {

    /** @var UserService */
    private $userService;

    /** @var array */
    public $onSignIn = [];

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }


    /**
     * Performs an authentication against e.g. database.
     * and returns IIdentity on success or throws AuthenticationException
     * @return IIdentity
     * @throws AuthenticationException
     */
    public function authenticate(array $credentials) {
        list($email, $password) = $credentials;
        $row = $this->userService->getByEmail($email);
        if (!$row) {
            throw new AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

        } elseif (!Passwords::verify($password, $row->password)) {
            throw new AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

        } elseif (Passwords::needsRehash($row->password)) {
            $this->userService->edit(['password' => Passwords::hash($password)], ['email' => $email]);
        }

        $row->password = null;
        $this->onSignIn($row->email);
        return new Identity($row->idUser, null, []); //TODO: přenášet informace o uživateli?
    }
}