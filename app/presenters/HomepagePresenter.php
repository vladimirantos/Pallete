<?php

namespace App\Presenters;

use Nette;
use App\Model;

class HomepagePresenter extends BasePresenter {

    /** @var Model\ArticleService @inject */
    public $article;

    public function renderNews() {
        $this->template->news = $this->article->getAllArticlesByLang($this->locale);
    }

}
