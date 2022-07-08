<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth'], function () {
    Route::post('login','AuthController@authenticate');
    Route::post('register','AuthController@store');
    Route::get('logout','AuthController@logout');
    Route::get('check','AuthController@check');
    Route::group(['prefix' => 'new'], function () {
        Route::post('/register', [
            'as' => 'auth.new.register', 'uses' => 'AuthController@newMemberAdd'
        ]);
    });
});

// session route
Route::post('email-exist',[
    'as' => 'email-exist','uses' => 'Demo\PagesController@emailExist'
]);

// admin route
Route::group(['prefix' => 'admin', 'middleware' => 'api.auth'], function (){

    Route::resource('todos', 'Demo\TodosController');

    Route::post('todos/toggleTodo/{id}', [
        'as' => 'admin.todos.toggle', 'uses' => 'Demo\TodosController@toggleTodo'
    ]);

    Route::group(['prefix' => 'settings'], function () {

        Route::post('/social', [
            'as' => 'admin.settings.social', 'uses' => 'Demo\SettingsController@postSocial'
        ]);
    });

    Route::group(['prefix' => 'users'], function (){

        Route::get('/get',[
            'as' => 'admin.users', 'uses' => 'Demo\PagesController@allUsers'
        ]);

        Route::get('/get/allAdminUsers', [
            'as' => 'admin.users.all', 'uses' => 'Demo\PagesController@allAdminUsers' 
        ]);

        Route::delete('/{id}',[
            'as' => 'admin.users.delete', 'uses' => 'Demo\PagesController@destroy'
        ]);

        Route::delete('/all', [
            'as' => 'admin.users.all.delete', 'uses' => 'Demo\PagesController@allDestroy'
        ]);

    });

    Route::group(['prefix' => 'user'], function (){

        Route::get('/get/{id}',[
            'as' => 'admin.user', 'uses' => 'Demo\PagesController@getUserWithId'
        ]);        

        Route::post('/edit/{id}', [
            'as' => 'admin.user.edit', 'uses' => 'Demo\PagesController@editUserWithId'
        ]);

        Route::post('/changeUserAvatar', [
            'as' => 'admin.user.change.avatar', 'uses' => 'AvatarsController@changeUserAvatar'
        ]);

        Route::post('/updatePassword/{id}', [
            'as' => 'admin.user.updatePassword', 'uses' => 'Demo\PagesController@updateUserPasswordWithId'
        ]);

        Route::group(['prefix' => 'avatar'], function (){
            Route::get('/get/{id}', [
                'as' => 'admin.user.avatar', 'uses' => 'AvatarsController@getUserAvatarWithId'
            ]);
            Route::get('/getAll', [
                'as' => 'admin.user.avatar.getall', 'uses' => 'AvatarsController@getAllAvatars'
            ]);
        });        
    });
});

