<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

// TODO: Tambahkan resource routes untuk CRUD di sini
// Contoh:
// Route::resource('study-programs', StudyProgramController::class);
// Route::resource('students', StudentController::class);
// Route::resource('subjects', SubjectController::class);
