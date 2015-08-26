<?php
namespace App\Model;
use Kdyby\Events\Subscriber;
use Nette\Http\Request;

/**
 * Class LogListener
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model
 */
class LogListener implements Subscriber {

    /** @var LogService */
    private $log;

    /** @var Request */
    private $httpRequest;

    public function __construct(LogService $logService, Request $httpRequest) {
        $this->log = $logService;
        $this->httpRequest = $httpRequest;
    }

    public function getSubscribedEvents() {
        return ["App\Model\Authenticator::onSignIn" => 'insert'];
    }

    public function insert($email){
        $this->log->save($email, ip2long('192.168.11.8'));
        //TODO: na ostrém webu používat httpRequest - ip2long neumí IPv6 která je na localhostu.
        //$this->log->save($idUser, ip2long($this->httpRequest->getRemoteAddress()));
    }
}