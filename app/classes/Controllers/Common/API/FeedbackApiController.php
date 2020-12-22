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
            $form_values = $form->values();

            $discount['id'] = App::$db->insertRow('discounts', $form_values);
            $discount['name'] = App::$db->getRowById('pizzas', $form_values['pizza_id'])['name'];
            $discount['price'] = $form_values['price'];
            $discount['pizza_id'] = $form_values['pizza_id'];
            $discount['old_price'] = App::$db->getRowById('pizzas', $form_values['pizza_id'])['price'];
            $discount['buttons']['edit'] = 'Edit';
            $discount['buttons']['delete'] = 'Delete';

            $response->setData($discount);
        } else {
            $response->setErrors($form->getErrors());
        }

        // Returns json-encoded response
        return $response->toJson();
    }
}






