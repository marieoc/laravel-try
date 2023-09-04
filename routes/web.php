<?php

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

use App\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    $posts = [];

    // load all posts from all users
    // $posts = Post::all();

    // Getting the posts from the Post Model
    // load posts where the 'user_id' is the id of the logged in user
    // after calling 'where()', we must call 'get()'
    // $posts = Post::where('user_id', auth()->id())->get();

    // Getting the posts from the User perspective
    //auth()->user(): return an instance of the current logged in user (thus the User Model!)

    if (auth()->check()) {
        $posts = auth()->user()->usersCoolPosts()->latest()->get();
    }

    return view('home', ['posts' => $posts]); // we do not need to specify '.blade.php'
});

// User Controller
Route::post('/register', [UserController::class, 'register']); // 2nd argument is the name of the function
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

// Post Controller
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
Route::put('/edit-post/{post}', [PostController::class, 'editPost']);
Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);