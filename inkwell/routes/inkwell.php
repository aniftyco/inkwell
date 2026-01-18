<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use NiftyCo\Inkwell\Livewire\Auth\Login;
use NiftyCo\Inkwell\Livewire\Dashboard\Campaigns\Index as CampaignsIndex;
use NiftyCo\Inkwell\Livewire\Dashboard\Campaigns\Show as CampaignsShow;
use NiftyCo\Inkwell\Livewire\Dashboard\Home;
use NiftyCo\Inkwell\Livewire\Dashboard\Posts\Editor as PostsEditor;
use NiftyCo\Inkwell\Livewire\Dashboard\Posts\Index as PostsIndex;
use NiftyCo\Inkwell\Livewire\Dashboard\Posts\Show as PostsShow;
use NiftyCo\Inkwell\Livewire\Dashboard\Settings\General as SettingsGeneral;
use NiftyCo\Inkwell\Livewire\Dashboard\Settings\Roles as SettingsRoles;
use NiftyCo\Inkwell\Livewire\Dashboard\Settings\Segments as SettingsSegments;
use NiftyCo\Inkwell\Livewire\Dashboard\Settings\Tags as SettingsTags;
use NiftyCo\Inkwell\Livewire\Dashboard\Settings\Themes as SettingsThemes;
use NiftyCo\Inkwell\Livewire\Dashboard\Settings\Users as SettingsUsers;
use NiftyCo\Inkwell\Livewire\Dashboard\Subscribers\Index as SubscribersIndex;
use NiftyCo\Inkwell\Livewire\Dashboard\Subscribers\Show as SubscribersShow;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// Logout (requires auth)
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('inkwell.logout');

// Authenticated dashboard routes
Route::middleware('auth')->group(function () {
    Route::get('/', Home::class)->name('inkwell.dashboard');

    // Posts
    Route::prefix('posts')->name('inkwell.posts.')->group(function () {
        Route::get('/', PostsIndex::class)->name('index');
        Route::get('/create', PostsEditor::class)->name('create');
        Route::get('/{post}', PostsShow::class)->name('show');
        Route::get('/{post}/edit', PostsEditor::class)->name('edit');
    });

    // Subscribers
    Route::prefix('subscribers')->name('inkwell.subscribers.')->group(function () {
        Route::get('/', SubscribersIndex::class)->name('index');
        Route::get('/{subscriber}', SubscribersShow::class)->name('show');
    });

    // Campaigns
    Route::prefix('campaigns')->name('inkwell.campaigns.')->group(function () {
        Route::get('/', CampaignsIndex::class)->name('index');
        Route::get('/{campaign}', CampaignsShow::class)->name('show');
    });

    // Settings
    Route::prefix('settings')->name('inkwell.settings.')->group(function () {
        Route::get('/', SettingsGeneral::class)->name('general');
        Route::get('/themes', SettingsThemes::class)->name('themes');
        Route::get('/users', SettingsUsers::class)->name('users');
        Route::get('/roles', SettingsRoles::class)->name('roles');
        Route::get('/tags', SettingsTags::class)->name('tags');
        Route::get('/segments', SettingsSegments::class)->name('segments');
    });
});
