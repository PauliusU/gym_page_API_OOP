<?php

namespace App\Controllers\Common;

use App\App;
use App\Views\BasePage;
use Core\View;
use Core\Views\Link;

class FeedbackController
{
    protected $page;

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
//            'js' => ['/media/js/home.js']
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

        if (App::$session->getUser()) {
            $feedbackForm = new FeedbackForm();
            $feedbackForm = $feedbackForm->render();
        } else {
             $link= new Link([
                'text' => 'Want to write a comment? Sign up',
                'url' => App::$router::getUrl('register'),
            ]);

            $feedbackForm = $link->render();
        }


        $content = (new View([
            'form' => $feedbackForm ?? [],
            'map' => $map_source ?? '',
        ]))->render(ROOT . '/app/templates/content/feedback.tpl.php');

        $this->page->setContent($content);

        return $this->page->render();
    }
}

