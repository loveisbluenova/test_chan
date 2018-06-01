<?php
include_once 'web_builder.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('index');
//});



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::model('blogcategory', 'App\BlogCategory');
Route::model('blog', 'App\Blog');
Route::model('task','App\Task');
Route::pattern('slug', '[a-z0-9- _]+');

Route::group(array('prefix' => 'admin'), function() {
    //All basic routes defined here
    Route::get('login', array('as' => 'admin-login','uses' => 'AuthController@getLogin'));
    Route::post('login','AuthController@postLogin');
    Route::get('register', array('as' => 'admin-register','uses' => 'AuthController@getRegister'));
    Route::post('register','AuthController@postRegister');
    Route::get('logout', array('as' => 'logout','uses' => 'AuthController@getLogout'));

    Route::get('forgot_password',array('as' => 'forgot_password','uses' => 'AuthController@getForgotPassword'));
    Route::post('forgot_password','AuthController@postForgotPassword');
    # Forgot Password Confirmation
    Route::get('forgot_password/{userId}/{passwordResetCode}', array('as' => 'forgot_password_confirm', 'uses' => 'AuthController@getForgotPasswordConfirm'));
    Route::post('forgot_password/{userId}/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');
    //lockscreen
    Route::get('{id}/lockscreen', array('as' => 'lockscreen', 'uses' =>'UsersController@lockscreen'));
    Route::post('{id}/lockscreen', array('as' => 'lockscreen', 'uses' =>'UsersController@postLockscreen'));
});

Route::group(array('prefix' => 'admin', 'middleware' => 'SentinelAdmin','as'=>'admin.'), function () {

    Route::get('/', array('as' => 'dashboard','uses' => 'ChandraController@showHome'));

    // GUI Crud Builder
    Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder');
    Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');
    Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');
    // Model checking
    Route::post('modelCheck', 'Admin\ModelcheckController@modelCheck');


    # User Management
    Route::group(array('prefix' => 'users'), function () {
        Route::get('/', array('as' => 'users', 'uses' => 'UsersController@index'));
        Route::get('create',array('as' => 'users.create', 'uses' => 'UsersController@create'));
        Route::post('create', 'UsersController@store');
        Route::get('{userId}/edit', array('as' => 'users.edit', 'uses' => 'UsersController@edit'));
        Route::post('{userId}/edit', 'UsersController@update');
        Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'UsersController@destroy'));
        Route::get('{userId}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'UsersController@getModalDelete'));
        Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'UsersController@restore'));
        Route::get('{userId}', array('as' => 'users.show', 'uses' => 'UsersController@show'));
    });

    # Group Management
    Route::group(array('prefix' => 'groups'), function () {
        Route::get('/', array('as' => 'groups', 'uses' => 'GroupsController@index'));
        Route::get('create', array('as' => 'create/group', 'uses' => 'GroupsController@create'));
        Route::post('create', 'GroupsController@store');
        Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'GroupsController@edit'));
//        Route::post('{groupId}/edit', 'GroupsController@update');
        Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'GroupsController@destroy'));
        Route::get('{groupId}/confirm-delete', array('as' => 'confirm-delete/group', 'uses' => 'GroupsController@getModalDelete'));
        Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'GroupsController@restore'));
    });
    Route::resource('groups', 'GroupsController');

    /*routes for blog*/
    Route::group(array('prefix' => 'blog','before' => 'Sentinel'), function () {
        Route::get('/', array('as' => 'blogs', 'uses' => 'BlogController@index'));
        Route::get('create', array('as' => 'create/blog', 'uses' => 'BlogController@create'));
        Route::post('create', 'BlogController@store');
        Route::get('{blog}/edit', array('as' => 'update/blog', 'uses' => 'BlogController@edit'));
        Route::post('{blog}/edit', 'BlogController@update');
        Route::get('{blog}/delete', array('as' => 'delete/blog', 'uses' => 'BlogController@destroy'));
        Route::get('{blog}/confirm-delete', array('as' => 'confirm-delete/blog', 'uses' => 'BlogController@getModalDelete'));
        Route::get('{blog}/restore', array('as' => 'restore/blog', 'uses' => 'BlogController@restore'));
        Route::get('{blog}/show', array('as' => 'blog/show', 'uses' => 'BlogController@show'));
        Route::post('{blog}/storecomment', 'BlogController@storeComment');
    });

    /*routes for blog category*/
    Route::group(array('prefix' => 'blogcategory','before' => 'Sentinel'), function () {
        Route::get('/', array('as' => 'blogcategories', 'uses' => 'BlogCategoryController@index'));
        Route::get('create', array('as' => 'create/blogcategory', 'uses' => 'BlogCategoryController@create'));
        Route::post('create', 'BlogCategoryController@store');
        Route::get('{blogcategory}/edit', array('as' => 'update/blogcategory', 'uses' => 'BlogCategoryController@edit'));
        Route::post('{blogcategory}/edit', 'BlogCategoryController@update');
        Route::get('{blogcategory}/delete', array('as' => 'delete/blogcategory', 'uses' => 'BlogCategoryController@destroy'));
        Route::get('{blogcategory}/confirm-delete', array('as' => 'confirm-delete/blogcategory', 'uses' => 'BlogCategoryController@getModalDelete'));
        Route::get('{blogcategory}/restore', array('as' => 'restore/blogcategory', 'uses' => 'BlogCategoryController@restore'));
    });

    Route::group(array('prefix' => 'file'), function () {
        Route::post('create', 'FileController@store');
        Route::post('createmulti', 'FileController@postFilesCreate');
        Route::delete('delete', 'FileController@delete');
    });

    # datatables
    Route::get('ajaxDatatables', 'DataTablesController@index');
    Route::get('datatables/data', array('as' => 'datatables.data', 'uses' => 'DataTablesController@data'));

    # editable datatables
    Route::get('editable_datatables', 'EditableDataTablesController@index');
    Route::get('editable_datatables/data', array('as' => 'editable_datatables.data', 'uses' => 'EditableDataTablesController@data'));
    Route::post('editable_datatables/create','EditableDataTablesController@store');
    Route::post('editable_datatables/{id}/update', 'EditableDataTablesController@update');
    Route::get('editable_datatables/{id}/delete', array('as' => 'admin.editable_datatables.delete', 'uses' => 'EditableDataTablesController@destroy'));
    //tasks section
    Route::post('task/create', 'TaskController@store');
    Route::get('task/data', 'TaskController@data');
    Route::post('task/{task}/edit', 'TaskController@update');
    Route::post('task/{task}/delete', 'TaskController@delete');

    //Remaining pages will be called from below controller method
    //in real world scenario, you may be required to define all routes manually
    Route::get('{name?}', 'ChandraController@showView');



});

#FrontEndController
Route::get('login', array('as' => 'login','uses' => 'FrontEndController@getLogin'));
Route::post('login','FrontEndController@postLogin');
Route::get('register', array('as' => 'register','uses' => 'FrontEndController@getRegister'));
Route::post('register','FrontEndController@postRegister');
Route::get('forgot-password',array('as' => 'forgot-password','uses' => 'FrontEndController@getForgotPassword'));
Route::post('forgot-password','FrontEndController@postForgotPassword');
# Forgot Password Confirmation
Route::get('forgot-password/{userId}/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'FrontEndController@getForgotPasswordConfirm'));
Route::post('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@postForgotPasswordConfirm');
# My account display and update details
Route::group(array('middleware' => 'SentinelUser'), function () {
    Route::get('my-account', array('as' => 'my-account', 'uses' => 'FrontEndController@myAccount'));
    Route::post('my-account', 'FrontEndController@updateAccount');
});
Route::get('logout', array('as' => 'logout','uses' => 'FrontEndController@getLogout'));
# contact form
Route::post('contact',array('as' => 'contact','uses' => 'FrontEndController@postContact'));

#frontend views
Route::get('/', array('as' => 'home', function () {
    return view('index');
}));

Route::get('blog', array('as' => 'blog', 'uses' => 'FrontendBlogController@index'));
Route::get('blog/{slug}/tag', 'FrontendBlogController@getBlogTag');
Route::get('blog/{slug?}', 'FrontendBlogController@show');
Route::post('blog/{blog}/comment', 'FrontendBlogController@storeComment');

Route::get('{name?}', 'ChandraController@showFrontEndView');
# End of frontend views
