<?php

namespace App\Controllers\Common;

use App\App;
use Core\FileDB;

class InstallController
{
    public function install()
    {
        App::$db = new FileDB(DB_FILE);

        // Users table
        App::$db->createTable('users');
        App::$db->insertRow('users', [
            'name' => 'testas',
            'surname' => 'testauskas',
            'email' => 'test@test.lt',
            'password' => 'test',
            'phone' => '+370612345678',
            'address' => 'Saulėtekio al. 15, Vilnius',
        ]);

//        App::$db->createTable('comments');

        print 'DB setup completed';
    }
}

