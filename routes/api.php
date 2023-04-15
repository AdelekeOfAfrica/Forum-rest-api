<?php

use App\Models\book;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\SendTestMailJob;
use App\Http\Controllers\iceandcube;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\user\UserAuthController;
use App\Http\Controllers\Admin\AdminAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/jobs', function(){
        $book = book::findOrFail(1);
        SendTestMailJob::dispatch($book)->delay(now()->addSeconds(5));
        echo "mail sent";
});

Route::resource('/external-books', iceandcube::class);

Route::prefix('v1')->group( function (){
    Route::get('/books', [BookController::class,'index']);
    Route::post('/books', [BookController::class,'store']);
    Route::put('/books/{id}', [BookController::class,'update']);
    Route::delete('/books/{id}', [BookController::class,'destroy']);
});
Route::post('/register',[UserAuthController::class,'register']);
Route::post('/login',[UserAuthController::class,'login']);
Route::post('/logout',[UserAuthController::class,'logout']);


require __DIR__ . '/admin.php';
