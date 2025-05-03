<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppController;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/search', [AppController::class, 'search'])->name('search');

Route::get('/profile/{user}', [ProfileController::class, 'show'])->where('user', '[0-9]+')->name('profile');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/photo', [ProfileController::class, 'uploadProfilePhoto'])->name('profile.photo.update');
Route::put('/profile/cover', [ProfileController::class, 'uploadCoverPhoto'])->name('profile.cover.update');

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('posts', PostController::class)->middleware('auth');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/posts/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('likes.store');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('likes.destroy');

// Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
// Route::post('/messages/{messageId}/read', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');
Route::post('/messenger/send_message', [MessageController::class, 'sendMessage'])->name('messages.sendMessage');
Route::get('/messenger/to/{receiver_id}', [MessageController::class, 'getMessages'])->name('messages.getMessages');
Route::get('/messenger/chat_users', [MessageController::class, 'getChatUsers'])->middleware('auth');


Route::post('/notifications/{userId}', [NotificationController::class, 'store'])->name('notifications.store');
Route::get('/notifications', [NotificationController::class, 'show'])->name('notifications.show');
Route::get('/notifications/form', [NotificationController::class, 'showForm'])->name('notifications.showform');
Route::post('/notifications/{notificationId}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::middleware('auth')->group(function () {
    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/{id}', [PageController::class, 'show'])->name('pages.show');
    Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{id}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('pages.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{id}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('/groups/{id}/leave', [GroupController::class, 'leave'])->name('groups.leave');
});

Route::post('/friends/request/{user}', [FriendshipController::class, 'sendRequest'])->name('friends.request');
Route::get('/friends/accept/{id}', [FriendshipController::class, 'acceptRequest'])->name('friends.accept');
Route::get('/friends/cancel/{id}', [FriendshipController::class, 'cancelRequest'])->name('friends.cancel');
Route::get('/friends/reject/{id}', [FriendshipController::class, 'rejectRequest'])->name('friends.reject');
Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');