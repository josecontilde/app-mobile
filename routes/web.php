<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/my-tasks', function () {
    return view('my-tasks');
})->name('my-tasks');

Route::get('my-teams', function () {
    return view('my-teams');
})->name('my-teams');

Route::get('/team/{team}/task/new', function () {
    return view('new-task');
})->name('new-task');

Route::get('/team/{team}', function () {
    return view('team');
})->name('team');

Route::get('/team/{team}/task/{task}', function () {
    return view('team-task');
})->name('team-task');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');