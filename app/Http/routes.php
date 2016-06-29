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
use App\Http\Controllers\MediaControllerNew as MediaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Web\UserWebController;


/** @var \Illuminate\Routing\Router $app */

$app->group(['middleware' => 'web'], function () use ($app) {

    $app->get('/', HomeController::class . '@index')->middleware('auth')->name('home');

    $app->get('hostname', function () {

        echo 'hostname' . gethostname();
       
        dd(request()->isSecure());

    });

    /**
     * Help
     */
    $app->group(['middleware' => 'web', 'prefix' => 'help', 'as' => 'help.'], function () use ($app) {
        $app->get('/', HelpController::class . '@index')->name('index');
        $app->get('create', HelpController::class . '@create')->name('create');
        $app->post('post', HelpController::class . '@post')->name('post');
    });

    // Authentication Routes...
    $this->get('login', AuthController::class . '@create')->name('login');
    $this->post('login', AuthController::class . '@post')->name('login.post');
    $this->get('logout', AuthController::class . '@logout')->name('logout');

    // Registration Routes...
    $this->get('register', AuthController::class . '@showRegistrationForm')->name('register');
    $this->post('register/post', AuthController::class . '@registerPost')->name('post_register');

    // Password Reset Routes...
    $this->get('password/reset/{token?}', PasswordController::class . '@showResetForm')->name('reset.password');
    $this->post('password/email', PasswordController::class . '@sendResetLinkEmail')->name('reset.email');
    $this->post('password/reset', PasswordController::class . '@reset')->name('reset');
    $this->get('password/reset-success', PasswordController::class . '@resetSuccess')->name('reset.success');

    /*
     * Media Streaming with Hash values
     */
    $app->group(['prefix' => 'media', 'as' => 'media.'], function ($app) {
        $app->get('{media_type}/{hashkey}', MediaController::class . '@streamData')->name('stream');
//        $app->get('video/{hashkey}/play', MediaController::class . '@streamVideo')->name('video');
//        $app->get('image/{hashkey}/show', MediaController::class . '@showImage')->name('image');
    });
    $app->get('image/products-extras/{hashkey}', MediaController::class . '@showImageByPath')->name('image.path');
    // to temporarily avoid issue on loading videos in APP created below route 04/06/2016
    $app->get('video', MediaController::class . '@streamVideoApi')->name('video.temp');

});

$app->group(['middleware' => ['web', 'auth', 'role:admin'], 'prefix' => 'admin'], function () use ($app) {

    /**
     * Users
     */
    $app->group(['as' => 'user.', 'prefix' => 'user'], function () use ($app) {
        $app->get('index', UserController::class . '@index')->name('index');
        $app->get('register', UserController::class . '@create')->name('register');
        $app->post('register', UserController::class . '@post')->name('register');
        $app->get('edit/{user}', UserController::class . '@edit')->name('edit');
        $app->post('update/{user}', UserController::class . '@update')->name('update');
        $app->get('reset/{user}', UserController::class . '@resetPassword')->name('reset');
        // for User's Code related
        $app->get('{user}/codes', UserController::class . '@userCodes')->name('codes');
        $app->get('code/{product}/unlink/{code}/{action}', CodeController::class . '@removeUser')->name('code.unlink');
        $app->get('{user}/add/code', UserController::class . '@registerCodeForm')->name('add.code');
        $app->post('{user}/add/code', UserController::class . '@registerCode')->name('add.code.post');
    });

    /**
     * Products
     */
    $app->group(['as' => 'product.', 'prefix' => 'product'], function () use ($app) {

        $app->get('index', ProductController::class . '@index')->name('index');
        $app->get('create', ProductController::class . '@create')->name('create');
        $app->post('post', ProductController::class . '@post')->name('post');
        $app->get('edit/{product}', ProductController::class . '@edit')->name('edit');
        $app->post('update/{product}', ProductController::class . '@update')->name('update');

        /**
         * Codes
         */
        $app->group(['as' => 'code.', 'prefix' => '{product}/code'], function () use ($app) {
            $app->get('index', CodeController::class . '@index')->name('index');
            $app->get('export', CodeController::class . '@export')->name('export');
            $app->get('create', CodeController::class . '@create')->name('create');
            $app->post('post', CodeController::class . '@post')->name('post');
            $app->get('unlink/{code}', CodeController::class . '@removeUser')->name('unlink');
        });

        /**
         * Extras
         */
        $app->group(['as' => 'extra.', 'prefix' => '{product}/extra'], function () use ($app) {
            $app->get('index', ExtraController::class . '@index')->name('index');
            $app->get('create', ExtraController::class . '@create')->name('create');
            $app->post('post', ExtraController::class . '@post')->name('post');
            /* added by vivek 03/15/2016 */
            $app->get('edit/{extra}', ExtraController::class . '@edit')->name('edit');
            $app->post('update/{extra}', ExtraController::class . '@update')->name('update');
            $app->get('delete/{extra}', ExtraController::class . '@delete')->name('delete');
        });

    });

    /**
     * Push Notification
     */
    $app->group(['as' => 'notification.', 'prefix' => 'notification'], function () use ($app) {
        $app->get('index', NotificationController::class . '@index')->name('index');
        $app->get('create', NotificationController::class . '@create')->name('create');
        $app->post('post', NotificationController::class . '@post')->name('post');
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

        $app->post('login', ApiAuthController::class . '@authenticate')->name('login');
        $app->post('register', ApiAuthController::class . '@register')->name('register');
        $app->post('reset', ApiAuthController::class . '@resetPassword')->name('reset');

    });

    $app->group(['middleware' => ['api']], function ($app) {
        $app->post('user/changePass', ApiAuthController::class . '@changePassword')->name('password.change');
    });

    $app->group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => 'api'], function ($app) {
        $app->post('check', ApiAuthController::class . '@check')->name('check');
    });

    /**
     * Product Api
     */
    $app->post('products', ApiProductController::class . '@index')->name('product.index');
    $app->group(['prefix' => 'product', 'as' => 'product.'], function ($app) {
        $app->post('/', ApiProductController::class . '@show')->name('show');
        $app->post('register', ApiProductController::class . '@register')->name('register');
    });

    /**
     * Form Api
     */
    $app->group(['prefix' => 'form', 'as' => 'form.'], function ($app) {
        $app->get('countries', FormController::class . '@countries')->name('countries');
        $app->get('ages', FormController::class . '@ages')->name('ages');
    });

    /**
     * Video API Call
     */
    $app->get('video', MediaController::class . '@streamVideoApi')->name('video');


});

$app->group(['middleware' => ['web', 'auth', 'role:user'], 'prefix' => 'user'], function () use ($app) {
    $app->group(['prefix' => 'web', 'as' => 'web.'], function ($app) {
        $app->get('index', UserWebController::class . '@index')->name('index');
        $app->group(['prefix' => 'product', 'as' => 'product.'], function ($app) {
            $app->get('register', UserWebController::class . '@registerProduct')->name('register');
            $app->post('create', UserWebController::class . '@createProduct')->name('create');
            $app->get('{code}/view', UserWebController::class . '@viewProductByCode')->name('view');
        });
    });

});
