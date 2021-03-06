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
            'js' => ['/media/js/feedback.js']
        ]);
    }

    /**
     * FeedbackController Index
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
            $paragraph = 'Want to write a comment? &nbsp;';

            $link = new Link([
                'text' => 'Please register',
                'url' => App::$router::getUrl('register'),
            ]);

            $link = $link->render();
        }

        $content = (new View([
            'title' => 'Feedback about Golden gym',
            'table' => $table->render(),
            'form' => $feedbackForm ?? [],
            'paragraph' => $paragraph ?? [],
            'link' => $link ?? [],
        ]))->render(ROOT . '/app/templates/content/feedback.tpl.php');

        $this->page->setContent($content);

        return $this->page->render();
    }
}

