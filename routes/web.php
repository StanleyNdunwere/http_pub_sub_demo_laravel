<?php

use App\Http\Controllers\Publisher\PublisherController;
use App\Http\Controllers\Subscription\SubscriptionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('app-status');
});

Route::get("/subscribe/all", [SubscriptionController::class, "getAllSubscriptionsAndTopics"]);
Route::get("/subscribe/{topic}", [SubscriptionController::class, "index"]);
Route::post("/subscribe/{topic}", [SubscriptionController::class, "create"]);


Route::post("publish/{topic}", [PublisherController::class, "broadcastToSubscribers"]);


