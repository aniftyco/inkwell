<?php

use App\Http\Pages\AllPosts;
use App\Http\Pages\ConfirmSubscription;
use App\Http\Pages\ShowPost;
use Illuminate\Support\Facades\Route;

Route::get('/', AllPosts::class)->name('posts.index');
Route::get('/subscription/{subscriber}', ConfirmSubscription::class)->name('subscription.confirm');
Route::get('/{slug}', ShowPost::class)->name('posts.show');
