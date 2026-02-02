<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

// TODO: Tambahkan resource routes untuk CRUD di sini
