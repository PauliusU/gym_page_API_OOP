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
            'name' => 'Adam',
            'surname' => 'Johnson',
            'email' => 'test@test.lt',
            'password' => 'test',
            'phone' => '+370612345678',
            'address' => 'Saulėtekio al. 15, Vilnius',
        ]);
        App::$db->insertRow('users', [
            'name' => 'John',
            'surname' => 'Smith',
            'email' => 'joch@smith.com',
            'password' => '12345678',
            'phone' => '+490987654321',
            'address' => 'Sunset avenue 43-2, London, UK',
        ]);

        // Feedback (comments) table
        App::$db->createTable('comments');
        App::$db->insertRow('comments', [
            'user_id' => 0,
            'timestamp' => 1607641838,
            'comment' => 'Golden gym is the greatest gym in town.',
        ]);
        App::$db->insertRow('comments', [
            'user_id' => 1,
            'timestamp' => 1608641838,
            'comment' => 'Could not recommend group trainings more. Personal trainers in Golden gym are the best!',
        ]);

        print 'DB setup completed';
    }
}

