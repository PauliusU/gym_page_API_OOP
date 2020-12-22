<?php

namespace App\Controllers\Common\API;

use App\App;
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
            $user = App::$db->getRowById('user', $comment['user_id']);

            $comment = [
                'id' => $comment_id,
                'name' => $user['name'] . ' ' . $user['surname'],
                'date' => date("Y-m-d", $comment['timestamp']),
                'comment' => $comment['$comment'],
            ];
        }

        // Setting "what" to json-encode
        $response->setData($comments);

        // Returns json-encoded response
        return $response->toJson();
    }

}






