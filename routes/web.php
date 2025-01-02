<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CsrfController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SqlInjectionController;

Route::get('/', [SecurityController::class, 'menu']);
Route::get('/stored-xss', [SecurityController::class, 'storedXss']);
Route::get('/attacked', [SecurityController::class, 'attacked']);
Route::get('/reflected-xss', [SecurityController::class, 'reflectedXss'])->name("reflected.xss");
Route::post('/search-order', [SecurityController::class, 'searchOrder'])->name('orders.search');

Route::get('/sql-injection', [SecurityController::class, 'sqlInjectionDetail'])->name('security.sql_injection');

Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comment', [CommentController::class, 'store']);
Route::delete('/comment/{id}', [CommentController::class, 'delete']);
Route::post('/comment/toggleSanitizeXss', [CommentController::class, 'toggleSanitizeXss']);

Route::get('/sqlInjection/userUnsecured/{email}', [SqlInjectionController::class, 'userUnsecured']);
Route::get('/sqlInjection/userSecured/{email}', [SqlInjectionController::class, 'userSecured']);
Route::get('/sqlInjection/userUnsecuredSqlMapTest', [SqlInjectionController::class, 'userUnsecuredSqlMapTest']);

Route::get('/csrf', [SecurityController::class, 'csrfDetail'])->name('security.csrf');
Route::get('/csrf-attacker', [SecurityController::class, 'csrfAttacker'])->name('security.csrf.attacker');

Route::post('/csrf/toggleEnableCsrfToken', [CsrfController::class, 'toggleEnableCsrfToken']);
Route::post('/csrf/transfer', [CsrfController::class, 'transfer']);