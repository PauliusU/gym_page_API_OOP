<?php

namespace App\Controllers\Common\API;

use App\App;
use App\Views\Forms\FeedbackCreateForm;
use Core\Api\Response;

class FeedbackApiController
{
    /**
     * Get json-encoded API response when generating feedback (comments) table in feedback page
     *
     * @return string
     */
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
                'comment' => $comment['comment'],
                'date' => date("Y-m-d", $comment['timestamp']),
            ];
        }

        // Setting "what" to json-encode
        $response->setData($comments);

        // Returns json-encoded response
        return $response->toJson();
    }

    /**
     * Get json-encoded API response when creating feedback (comment) in feedback page
     *
     * @return string
     */
    public function create(): string
    {
        // This is a helper class to make sure
        // we use the same API json response structure
        $response = new Response();
        $form = new FeedbackCreateForm();

        if ($form->validate()) {
            $comment['name'] = App::$session->getUser()['name'];
            $comment['comment'] = $form->value('text');
            $comment['timestamp'] = date("Y-m-d", time());

            $comment['id'] = App::$db->insertRow('comments', [
                'user_id' => App::$db->getRowIdWhere('users', ['email' => App::$session->getUser()['email']]),
                'comment' => $comment['comment'],
                'timestamp' => time(),
            ]);

            $response->setData($comment);
        } else {
            $response->setErrors($form->getErrors());
        }

        // Returns json-encoded response
        return $response->toJson();
    }
}






