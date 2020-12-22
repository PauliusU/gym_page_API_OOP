<?php

namespace App\Views\Forms;

use Core\Views\Form;

class FeedbackCreateForm extends Form
{
    public function __construct()
    {
        parent::__construct([
            'fields' => [
                'text' => [
                    'label' => 'Leave feedback about us below',
                    'type' => 'textarea',
                    'validators' => [
                        'validate_not_empty',
                        'validate_length' => [
                            'max' => 500,
                        ],
                    ],
                    'extra' => [
                        'attr' => [
                            'placeholder' => 'Insert your feedback message here',
                        ],
                    ],
                ],
            ],
        ]);

        $this->data['attr']['id'] = 'comment-create-form';
        $this->data['buttons']['create'] = [
            'title' => 'Send',
        ];
    }
}