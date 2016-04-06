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

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\ExtraController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Web\UserWebController;

/** @var \Illuminate\Routing\Router $app */

/**
 * Helper to refactor Controllers
 *
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

    $app->get('/', classie(HomeController::class, 'index'))->middleware('auth')->name('home');

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
    $this->post('register/post', classie(AuthController::class, 'registerPost'))->name('post_register');

    // Password Reset Routes...
    $this->get('password/reset/{token?}', classie(PasswordController::class, 'showResetForm'))->name('reset.password');
    $this->post('password/email', classie(PasswordController::class, 'sendResetLinkEmail'))->name('reset.email');
    $this->post('password/reset', classie(PasswordController::class, 'reset'))->name('reset');
    $this->get('password/reset-success', classie(PasswordController::class, 'resetSuccess'))->name('reset.success');

    /*
     * Media Streaming with Hash values
     */
    $app->group(['prefix' => 'media', 'as' => 'media.'], function ($app) {
        $app->get('{media_type}/{hashkey}', classie(MediaController::class, 'streamData'))->name('stream');
        $app->get('video/{hashkey}/play', classie(MediaController::class, 'streamVideo'))->name('video');
        $app->get('image/{hashkey}/show', classie(MediaController::class, 'showImage'))->name('image');
    });
    $app->get('image/products-extras/{hashkey}', classie(MediaController::class, 'showImageByPath'))->name('image.path');

});

$app->group(['middleware' => ['web', 'auth', 'role:admin'], 'prefix' => 'admin'], function () use ($app) {

    /**
     * Users
     */
    $app->group(['as' => 'user.', 'prefix' => 'user'], function () use ($app) {
        $app->get('index', classie(UserController::class, 'index'))->name('index');
        $app->get('register', classie(UserController::class, 'create'))->name('register');
        $app->post('register', classie(UserController::class, 'post'))->name('register');
        /* added by vivek 03/16/2016 */
        $app->get('edit/{user}', classie(UserController::class, 'edit'))->name('edit');
        $app->post('update/{user}', classie(UserController::class, 'update'))->name('update');
        $app->get('reset/{user}', classie(UserController::class, 'resetPassword'))->name('reset');
    });

    /**
     * Products
     */
    $app->group(['as' => 'product.', 'prefix' => 'product'], function () use ($app) {

        $app->get('index', classie(ProductController::class, 'index'))->name('index');
        $app->get('create', classie(ProductController::class, 'create'))->name('create');
        $app->post('post', classie(ProductController::class, 'post'))->name('post');
        $app->get('edit/{product}', classie(ProductController::class, 'edit'))->name('edit');
        $app->post('update/{product}', classie(ProductController::class, 'update'))->name('update');

        /**
         * Codes
         */
        $app->group(['as' => 'code.', 'prefix' => '{product}/code'], function () use ($app) {
            $app->get('index', classie(CodeController::class, 'index'))->name('index');
            $app->get('export', classie(CodeController::class, 'export'))->name('export');
            $app->get('create', classie(CodeController::class, 'create'))->name('create');
            $app->post('post', classie(CodeController::class, 'post'))->name('post');
            $app->get('unlink/{code}', classie(CodeController::class, 'removeUser'))->name('unlink');
        });

        /**
         * Extras
         */
        $app->group(['as' => 'extra.', 'prefix' => '{product}/extra'], function () use ($app) {
            $app->get('index', classie(ExtraController::class, 'index'))->name('index');
            $app->get('create', classie(ExtraController::class, 'create'))->name('create');
            $app->post('post', classie(ExtraController::class, 'post'))->name('post');
            /* added by vivek 03/15/2016 */
            $app->get('edit/{extra}', classie(ExtraController::class, 'edit'))->name('edit');
            $app->post('update/{extra}', classie(ExtraController::class, 'update'))->name('update');
            $app->get('delete/{extra}', classie(ExtraController::class, 'delete'))->name('delete');
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
        $app->post('reset', classie(ApiAuthController::class, 'resetPassword'))->name('reset');

    });

    $app->group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => 'api'], function ($app) {
        $app->post('check', classie(ApiAuthController::class, 'check'))->name('check');
    });

    /**
     * Product Api
     */
    $app->post('products', classie(ApiProductController::class, 'index'))->name('product.index');
    $app->group(['prefix' => 'product', 'as' => 'product.'], function ($app) {
        $app->post('/', classie(ApiProductController::class, 'show'))->name('show');
        $app->post('register', classie(ApiProductController::class, 'register'))->name('register');
    });

    /**
     * Form Api
     */
    $app->group(['prefix' => 'form', 'as' => 'form.'], function ($app) {
        $app->get('countries', classie(FormController::class, 'countries'))->name('countries');
        $app->get('ages', classie(FormController::class, 'ages'))->name('ages');
    });

    /**
     * Video API Call
     */
    $app->get('video', classie(MediaController::class, 'streamVideoApi'))->name('video');


});

$app->group(['middleware' => ['web', 'auth', 'role:user'], 'prefix' => 'user'], function () use ($app) {
    $app->group(['prefix' => 'web', 'as' => 'web.'], function ($app) {
        $app->get('index', classie(UserWebController::class, 'index'))->name('index');
        $app->group(['prefix' => 'product', 'as' => 'product.'], function ($app) {
            $app->get('register', classie(UserWebController::class, 'registerProduct'))->name('register');
            $app->post('create', classie(UserWebController::class, 'createProduct'))->name('create');
            $app->get('{code}/view', classie(UserWebController::class, 'viewProductByCode'))->name('view');
        });
    });

});