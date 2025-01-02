<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CsrfController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SqlInjectionController;

Route::get('/', [SecurityController::class, 'menu'])->name('security.menu');
Route::get('/xss', [SecurityController::class, 'xssDetail'])->name('security.xss');
Route::get('/csrf', [SecurityController::class, 'csrfDetail'])->name('security.csrf');
Route::get('/sql-injection', [SecurityController::class, 'sqlInjectionDetail'])->name('security.sql_injection');

Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comment', [CommentController::class, 'store']);
Route::delete('/comment/{id}', [CommentController::class, 'delete']);
Route::post('/comment/toggleSanitizeXss', [CommentController::class, 'toggleSanitizeXss']);

Route::get('/sqlInjection/userUnsecure/{email}', [SqlInjectionController::class, 'userSecure']);
Route::get('/sqlInjection/userSecured/{email}', [SqlInjectionController::class, 'userUnsecure']);

Route::post('/csrf/toggleEnableCsrfToken', [CsrfController::class, 'toggleEnableCsrfToken']);
Route::post('/csrf/transfer', [CsrfController::class, 'transfer']);