<?php

namespace App\Views;

use Core\View;

class Footer extends View
{
    public function __construct()
    {
        parent::__construct($this->generate());
    }

    public function generate()
    {
        $current_year = date('Y');
        return "Copyright © $current_year Paulius Uosis, all rights reserved.";
    }

    public function render($template_path = ROOT . '/app/templates/footer.php')
    {
        return parent::render($template_path);
    }
}