<?php
namespace App\AdminModule\Presenters;
use Asterix\Flash;
use Nette\Http\IRequest;

/**
 * Class DashboardPresenter
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\AdminModule\Presenters
 */
class DashboardPresenter extends AdminPresenter {

    public function startup() {
        parent::startup();
        b(long2ip(-1062728952));
    }

    public function renderDefault(){
        $this->title('admin.dashboard.title', 'admin.dashboard.subtitle');
    }
}