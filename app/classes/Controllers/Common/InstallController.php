<?php

namespace App\Controllers\Common;

use App\App;
use Core\FileDB;

class InstallController
{
    public function install()
    {
        App::$db = new FileDB(DB_FILE);

        // Users
        App::$db->createTable('users');
        App::$db->insertRow('users', [
            'email' => 'test@test.lt',
            'password' => 'test',
            'user_name' => 'testas'
        ]);

//        App::$db->createTable('pizzas');
//        App::$db->createTable('orders');

        print 'DB setup completed';
    }
}

