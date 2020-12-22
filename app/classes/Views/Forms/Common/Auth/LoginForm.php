<?php

namespace App\Views\Forms\Common\Auth;

use Core\Views\Form;

class LoginForm extends Form
{
public function __construct()
{
    parent::__construct([
        'fields' => [
            'email' => [
                'label' => 'Email',
                'type' => 'text',
                'validators' => [
                    'validate_not_empty',
                    'validate_email',
                    'validate_user_exists',
                ],
                'extra' => [
                    'attr' => [
                        'placeholder' => 'Įvesk emailą',
                    ],
                ],
            ],
            'password' => [
                'label' => 'Password',
                'type' => 'password',
                'validators' => [
                    'validate_not_empty',
                ],
                'extra' => [
                    'attr' => [
                        'placeholder' => 'Įvesk slaptažodį',
                    ],
                ],
            ],
        ],
        'buttons' => [
            'login' => [
                'title' => 'Login',
            ],
        ],
        'validators' => [
            'validate_login' => [
                'email',
                'password',
            ]
        ]
    ]);
}
}