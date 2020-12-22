<?php

namespace App\Controllers\Common;

use App\App;
use App\Views\BasePage;
use App\Views\Forms\FeedbackCreateForm;
use App\Views\Tables\Feedback\FeedbackTable;
use Core\View;
use Core\Views\Link;

class FeedbackController
{
    protected BasePage $page;

    /**
     * Controller constructor.
     *
     * We can write logic common for all
     * other methods
     *
     * For example, create $page object,
     * set it's header/navigation
     * or check if user has a proper role
     *
     * Goal is to prepare $page
     */
    public function __construct()
    {
        $this->page = new BasePage([
            'title' => 'Feedback | Golden gym',
            'js' => ['/media/js/feedback/feedback.js']
        ]);
    }

    /**
     * Home Controller Index
     *
     * @return string|null
     * @throws \Exception
     */
    public function index(): ?string
    {

        $table = new FeedbackTable();

        if (App::$session->getUser()) {
            $feedbackForm = (new FeedbackCreateForm())->render();
        } else {
            $link = new Link([
                'text' => 'Want to write a comment? Please register',
                'url' => App::$router::getUrl('register'),
            ]);

            $feedbackForm = $link->render();
        }

        $content = (new View([
            'title' => 'Feedback',
            'form' => $feedbackForm ?? [],
            'table' => $table->render(),
        ]))->render(ROOT . '/app/templates/content/feedback.tpl.php');

        $this->page->setContent($content);

        return $this->page->render();
    }
}

