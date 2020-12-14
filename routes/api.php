<?php

use App\Http\Controllers\AuditResultsController;
use App\Http\Controllers\AuditsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeasurementsController;
use App\Http\Controllers\RegularAuditsController;
use App\Http\Requests\RegularAuditsPost;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('audits', [AuditsController::class, 'index']);
Route::post('audit-results', [AuditResultsController::class, 'index']);

Route::post('measurements', [MeasurementsController::class, 'index']);
Route::post('measurements/store', [MeasurementsController::class, 'store']);

Route::post('measurements/store', [MeasurementsController::class, 'store']);

Route::middleware('auth:api')->group(function () {
    Route::put('regular-audits', [RegularAuditsController::class, 'store']);
    Route::get('regular-audits', [RegularAuditsController::class, 'index']);
    Route::get('regular-audits/{id}', [RegularAuditsController::class, 'show']);
});