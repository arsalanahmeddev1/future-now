<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\User\AuthController as AuthController;
use App\Http\Controllers\User\FrontController as FrontController;
use App\Http\Controllers\User\PlanController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'admin'], function () {
    require __DIR__.'/admin.php';
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [FrontController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
    Route::controller(PlanController::class)->prefix('plans')->as('user.')->group(function (){
        Route::get('/', 'index')->name('plan');
        Route::post('/', 'payment')->name('payment');
    });
    Route::post('post/like', [\App\Http\Controllers\LikeController::class, 'likes'])->name('post.like');
    Route::post('/post/comment', [CommentController::class, 'comments'])->name('post.comment');
    Route::get('post/comment', [CommentController::class, 'showComments'])->name('show.comment');
});


//guest
Route::group(['middleware' => 'guest'], function () {

    Route::get('/auth/google/redirect', function () {
        return Socialite::driver('google')->redirect();
    })->name('auth.google');
    Route::get('/auth/google/callback', function () {

        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::updateOrCreate([
            'google_id' => $googleUser->id,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
        ]);
        Auth::login($user);
        return redirect('/home');
    });

    Route::get('/auth/facebook/redirect', function () {
        return Socialite::driver('facebook')->redirect();
    })->name('auth.facebook');
    Route::get('/auth/facebook/callback', function () {

        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        // dd($facebookUser);
        $user = User::updateOrCreate([
            'facebook_id' => $facebookUser->id,
        ], [
            'name' => $facebookUser->name,
            'email' => $facebookUser->email?:'',
            'facebook_token' => $facebookUser->token,
            'facebook_refresh_token' => $facebookUser->refreshToken,
        ]);
        Auth::login($user);
        return redirect('/home');
    });

    Route::get('/login', function () {
        return view('auth.front.login');
    })->name('user.login');
    Route::get('/', function () {
        return view('auth.front.login');
    })->name('r');
    Route::post('/login', [AuthController::class, 'login'])->name('user.login');
    Route::get('/register', function () {
        return view('auth.front.register');
    })->name('user.register');
    Route::post('/register', [AuthController::class, 'register'])->name('user.register');
    Route::get('/forgot-password', function () {
        return view('auth.front.forgot-password');
    })->name('user.forgot-password');

    Route::get('/reset-password', function () {
        return view('auth.front.reset-password');
    })->name('reset-password');
    Route::get('/contact', function () {
        return view('front.contact-us');
    })->name('contact-us');
});
