<?php

namespace App\Controllers\Common\API;

use App\App;
use App\Views\Forms\FeedbackCreateForm;
use Core\Api\Response;

class FeedbackApiController
{

    public function index(): string
    {
        // This is a helper class to make sure
        // we use the same API json response structure
        $response = new Response();

        $comments = App::$db->getRowsWhere('comments');

        foreach ($comments as $comment_id => &$comment) {
            $comment = [
                'id' => $comment_id,
                'name' => App::$db->getRowById('users', $comment['user_id'])['name'],
                'date' => date("Y-m-d", $comment['timestamp']),
                'comment' => $comment['comment'],
            ];
        }

        // Setting "what" to json-encode
        $response->setData($comments);

        // Returns json-encoded response
        return $response->toJson();
    }

    public function create(): string
    {
        // This is a helper class to make sure
        // we use the same API json response structure
        $response = new Response();
        $form = new FeedbackCreateForm();

        if ($form->validate()) {
            $comment = [
                'user_id' => App::$db->getRowIdWhere('users', ['email' => App::$session->getUser()['email']]),
                'timestamp' => time(),
                'comment' => $form->value('text'),
            ];

            App::$db->insertRow('comments', $comment);

            $response->setData($comment);
        } else {
            $response->setErrors($form->getErrors());
        }

        // Returns json-encoded response
        return $response->toJson();
    }
}






