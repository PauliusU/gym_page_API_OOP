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
        App::$db->insertRow('users', [
            'name' => 'J',
            'surname' => 'testauskas',
            'email' => 'test@test.lt',
            'password' => 'test',
            'phone' => '+370612345678',
            'address' => 'Saulėtekio al. 15, Vilnius',
        ]);

        // Feedback (comments) table
        App::$db->createTable('comments');
        App::$db->insertRow('comments', [
            'user_id' => 1,
            'timestamp' => 1608641838,
            'comment' => 'Golden gym is the greatest gym in town.',
        ]);
        App::$db->insertRow('comments', [
            'user_id' => 2,
            'timestamp' => 1608641800,
            'comment' => 'Could not recommend group trainings more. Personal trainers in Golden gym are the best!',
        ]);

        print 'DB setup completed';
    }
}

