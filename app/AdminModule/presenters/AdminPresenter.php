<?php
namespace App\AdminModule\Presenters;


use App\Model\Entity\User;
use App\Model\UserService;
use App\Presenters\BasePresenter;
use Asterix\NavigationCollection;
use Nette\Security\Identity;

class AdminPresenter extends BasePresenter{

    /**
     * @var Identity
     */
    protected $identity;

    /**
     * @var NavigationCollection
     */
    protected $navigation;

    /** @var UserService @inject*/
    public $userService;

    /** @var User */
    protected $userEntity;

    public function startup(){
        parent::startup();
        if(!$this->user->isLoggedIn())
            $this->redirect(':Sign:in');
        $this->identity = $this->user->identity;
        $this->userEntity = $this->userService->get($this->identity->id);
        $this->navigation = new NavigationCollection($this->translator);
        $this->template->navigation = $this->navigation;
        $this->template->systemName = systemName;
        $this->template->author = $this->userEntity->getEmail();
    }
}