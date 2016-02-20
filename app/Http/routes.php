<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\UserController;

/** @var \Illuminate\Routing\Router $app */

/**
 * Helper to refactor Controllers
 * @param $class
 * @param $method
 * @return string
 */
function classie($class, $method)
{
    $namespace = 'App\Http\Controllers\'';
    return str_replace($namespace, "", $class) . '@' . $method;
}

$app->group(['middleware' => 'web'], function () use ($app) {

    $app->get('/', classie(HomeController::class, 'index'))->name('home');

    /**
     * Help
     */
    $app->group(['middleware' => 'web', 'prefix' => 'help', 'as' => 'help.'], function () use ($app) {
        $app->get('/', classie(HelpController::class, 'index'))->name('index');
        $app->get('create', classie(HelpController::class, 'create'))->name('create');
        $app->post('post', classie(HelpController::class, 'post'))->name('post');
    });

    // Authentication Routes...
    $this->get('login', classie(AuthController::class, 'create'))->name('login');
    $this->post('login', classie(AuthController::class, 'post'))->name('login.post');
    $this->get('logout', classie(AuthController::class, 'logout'))->name('logout');

    // Registration Routes...
    $this->get('register', classie(AuthController::class, 'showRegistrationForm'))->name('register');
    $this->post('register', classie(AuthController::class, 'register'))->name('register');

    // Password Reset Routes...
    $this->get('password/reset/{token?}', classie(PasswordController::class, 'showResetForm'))->name('reset.password');
    $this->post('password/email', classie(PasswordController::class, 'sendResetLinkEmail'))->name('reset.email');
    $this->post('password/reset', classie(PasswordController::class, 'reset'))->name('reset');

});

$app->group(['middleware' => ['web', 'auth', 'role:admin'], 'prefix' => 'admin'], function () use ($app) {

    /**
     * Users
     */
    $app->group(['as' => 'user.', 'prefix' => 'user'], function () use ($app) {
        $app->get('index', classie(UserController::class, 'index'))->name('index');
        $app->get('register', classie(UserController::class, 'create'))->name('register');
        $app->post('register', classie(UserController::class, 'post'))->name('register');
    });

    /**
     * Products
     */
    $app->group(['as' => 'product.', 'prefix' => 'product'], function () use ($app) {

        $app->get('index', classie(ProductController::class, 'index'))->name('index');
        $app->get('create', classie(ProductController::class, 'create'))->name('create');
        $app->post('post', classie(ProductController::class, 'post'))->name('post');

        /**
         * Codes
         */
        $app->group(['as' => 'code.', 'prefix' => '{product}/code'], function () use ($app) {
            $app->get('index', classie(CodeController::class, 'index'))->name('index');
            $app->get('export', classie(CodeController::class, 'export'))->name('export');
            $app->get('create', classie(CodeController::class, 'create'))->name('create');
            $app->post('post', classie(CodeController::class, 'post'))->name('post');
        });

    });

    /**
     * Push Notification
     */
    $app->group(['as' => 'notification.', 'prefix' => 'notification'], function () use ($app) {
        $app->get('index', classie(NotificationController::class, 'index'))->name('index');
        $app->get('create', classie(NotificationController::class, 'create'))->name('create');
        $app->post('post', classie(NotificationController::class, 'post'))->name('post');
    });

});

/**
 * Api
 */
$app->group(['prefix' => 'api', 'as' => 'api.'], function ($app) {

    /**
     * User
     */
    $app->group(['prefix' => 'user', 'as' => 'user.'], function ($app) {

        $app->post('login', classie(ApiAuthController::class, 'authenticate'))->name('login');
        $app->post('register', classie(ApiAuthController::class, 'register'))->name('register');


    });

    $app->group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => 'api'], function ($app) {
        $app->post('check', classie(ApiAuthController::class, 'check'))->name('check');
    });

    /**
     * Product Api
     */
    $app->group(['prefix' => 'product', 'as' => 'product.', 'middleware' => 'api'], function ($app) {

        $app->get('/', classie(ApiProductController::class, 'index'))->name('index');
        $app->get('{product}/show', classie(ApiProductController::class, 'show'))->name('show');

    });

    /**
     * Form Api
     */
    $app->group(['prefix' => 'form', 'as' => 'form.'], function ($app) {

        $app->get('countries', classie(FormController::class, 'countries'))->name('countries');

    });


});