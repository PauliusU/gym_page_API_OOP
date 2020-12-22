<?php

namespace App\Views\Forms\Common\Auth;

use Core\Views\Form;

class RegisterForm extends Form
{
    public function __construct()
    {
        parent::__construct([
                'fields' => [
                    'name' => [
                        'label' => 'Name',
                        'type' => 'text',
                        'validators' => [
                            'validate_not_empty',
                            'validate_not_numeric',
                            'validate_length' => [
                                'max' => 40,
                            ],
                        ],
                        'extra' => [
                            'attr' => [
                                'placeholder' => 'Enter your name',
                            ]
                        ]
                    ],
                    'surname' => [
                        'label' => 'Surname',
                        'type' => 'text',
                        'validators' => [
                            'validate_not_empty',
                            'validate_not_numeric',
                            'validate_length' => [
                                'max' => 40,
                            ],
                        ],
                        'extra' => [
                            'attr' => [
                                'placeholder' => 'Enter your surname',
                            ]
                        ]
                    ],
                    'email' => [
                        'label' => 'Email',
                        'type' => 'text',
                        'validators' => [
                            'validate_not_empty',
                            'validate_email',
                            'validate_user_unique',
                        ],
                        'extra' => [
                            'attr' => [
                                'placeholder' => 'Enter email',
                            ]
                        ]
                    ],
                    'password' => [
                        'label' => 'Password',
                        'type' => 'password',
                        'validators' => [
                            'validate_not_empty',
                        ],
                        'extra' => [
                            'attr' => [
                                'placeholder' => 'Enter password',
                            ]
                        ]
                    ],
                    'password_repeat' => [
                        'label' => 'Password Repeat',
                        'type' => 'password',
                        'validators' => [
                            'validate_not_empty',
                        ],
                        'extra' => [
                            'attr' => [
                                'placeholder' => 'Repeat password',
                            ]
                        ]
                    ],
                    'phone' => [
                        'label' => 'Phone (optional)',
                        'type' => 'text',
                        'extra' => [
                            'attr' => [
                                'placeholder' => 'E.g. 612345678',
                            ]
                        ]
                    ],
                    'address' => [
                        'label' => 'Address (optional)',
                        'type' => 'text',
                        'extra' => [
                            'attr' => [
                                'placeholder' => 'Enter your home address',
                            ]
                        ]
                    ],
                ],
                'buttons' => [
                    'register' => [
                        'title' => 'Register',
                    ]
                ],
                'validators' => [
                    'validate_fields_match' => [
                        'password',
                        'password_repeat'
                    ]
                ]
            ]
        );

    }
}