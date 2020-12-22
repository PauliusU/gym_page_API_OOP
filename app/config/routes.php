<?php

use Core\Router;

// Auth Controllers
Router::add('login', '/login', \App\Controllers\Common\Auth\LoginController::class, 'login');
Router::add('register', '/register', \App\Controllers\Common\Auth\RegisterController::class, 'register');
Router::add('logout', '/logout', \App\Controllers\Common\Auth\LogoutController::class, 'logout');

// Common Routes
Router::add('index', '/', \App\Controllers\Common\HomeController::class);
Router::add('index2', '/index', \App\Controllers\Common\HomeController::class);
Router::add('install', '/install', \App\Controllers\Common\InstallController::class, 'install');
Router::add('feedback', '/feedback', \App\Controllers\Common\FeedbackController::class);

// API Routes
Router::add('api_comment_get', '/api/comment/get', \App\Controllers\Common\API\FeedbackApiController::class);
Router::add('api_comment_create', '/api/comment/create', \App\Controllers\Common\API\FeedbackApiController::class, 'create');