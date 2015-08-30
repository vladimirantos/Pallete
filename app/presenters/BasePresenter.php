<?php

namespace App\Presenters;

use Asterix\Flash;
use Nette;
use App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

    /** @persistent */
    public $locale;

    /** @var \Kdyby\Translation\Translator @inject */
    public $translator;

    public function startup() {
        parent::startup();
        $this->template->title = null;
        $this->template->subtitle = null;
    }

    public function beforeRender() {
        $this->template->setTranslator($this->translator);
    }

    /**
     * @param string $message
     * @param string $type
     * @param string $title
     * @return \stdClass
     */
    public function flashMessage($message, $type = Flash::SUCCESS, $title = ''){
        $message = $this->translator->translate($message, null, ['AHOJ']);
        $flash = parent::flashMessage($message, $type);
        switch ($type) {
            case Flash::SUCCESS:
                $flash->title = 'Výborně!';
                break;
            case Flash::ERROR:
                $flash->title = 'Chyba!';
                break;
            case Flash::INFO:
                $flash->title = 'Informace!';
                break;
            case Flash::WARNING:
                $flash->title = 'Upozornění!';
                break;
            default: $flash->title = $title;
                break;
        }
        return $flash;
    }

    /**
     * @param string $title
     * @param string $subtitle
     * @return BasePresenter
     */
    protected function title($title, $subtitle = null){
        $this->template->title = $this->translator->translate($title);
        $this->template->subtitle = $this->translator->translate($subtitle);
        return $this;
    }

    protected function createTemplate($class = NULL) {
        $template = parent::createTemplate($class);
        $template->addFilter(NULL, 'Asterix\Filters::common');

        return $template;
    }

    public function handleChangeLocale($locale) {
        $this->translator->setLocale($locale);
        $this->redirect('this');
    }
}
