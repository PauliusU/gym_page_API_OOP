<?php

namespace App\Views;

use App\App;
use Core\View;

class Navigation extends View
{
    public function __construct()
    {
        parent::__construct($this->generate());
    }

    public function generate()
    {
        $this->addLink('Home', App::$router::getUrl('index'), 'left');

        if (App::$session->getUser()) {
            $this->addLink('Feedback', App::$router::getUrl('user_orders'), 'left');

            // TODO: parašyti su this->value()
            $user_email = App::$session->getUser()['email'];
            $this->addLink("Logout ($user_email)", App::$router::getUrl('logout'), 'right');
        } else {
            $this->addLink('Register', App::$router::getUrl('register'), 'right');
            $this->addLink('Login', App::$router::getUrl('login'), 'right');
        }

        return $this->data;
    }

    public function addLink($title, $url, $section)
    {
        $link = [
            'title' => $title,
            'url' => $url,
        ];

        if ($_SERVER['REQUEST_URI'] === $link['url']) {
            $link['active'] = true;
        } else {
            $link['active'] = false;
        }

//        $this->data[$section][] = $link;
        $this->data[$section][] = $link;
    }

    public function render($template_path = ROOT . '/app/templates/nav.php')
    {
        return parent::render($template_path);
    }
}


