<?php
use App\Mail\LoginMail;
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

Route::get('/', function () {
    // send an email to "batman@batcave.io"
    // Mail::to('mid90120@gmail.com')->send(new LoginMail);
    Mail::to('mid90120@gmail.com')->queue(new LoginMail);

    return view('welcome');
});

// social Authentication
Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
