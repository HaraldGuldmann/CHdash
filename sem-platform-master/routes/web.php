<?php

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
    return redirect()->route('dashboard');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('earnings', 'EarningController@index')->name('earnings.index');

    Route::resource('contracts', 'ContractController')->only('index', 'show', 'create', 'store', 'destroy');
    Route::resource('videos', 'VideoController')->only('index', 'create', 'store', 'show');
    Route::resource('teams', 'TeamController')->only('index', 'create', 'store', 'destroy');
    Route::resource('claims', 'ClaimController')->only('index', 'create', 'store', 'show');
    Route::get('claims/{claim}/claim', 'ClaimController@claim')->name('claims.claim');
    Route::get('claims/{claim}/reject', 'ClaimController@reject')->name('claims.reject');
    Route::get('videos/{video}/approve', 'VideoController@approve')->name('videos.approve');
    Route::get('videos/{video}/deny', 'VideoController@deny')->name('videos.deny');

    Route::get('contracts/{contract}/sign', 'ContractController@sign')->name('contracts.sign');
    Route::patch('contracts/{contract}/sign', 'ContractController@patchSign')->name('contracts.sign.patch');
    Route::get('contracts/{contract}/delete', 'ContractController@delete')->name('contracts.delete');

    Route::middleware(['admin'])->group(function () {
        Route::resource('earningruns', 'EarningRunController')->except('destroy');
        Route::get('earningruns/{earningrun}/delete', 'EarningRunController@destroy')->name('earningruns.delete');
        Route::get('earningruns/{earningrun}/lock', 'EarningRunController@lock')->name('earningruns.lock');
        Route::get('earningruns/{earningrun}/paid', 'EarningRunController@paid')->name('earningruns.paid');
        Route::get('earningruns/{earningrun}/paypal', 'EarningRunController@paypal')->name('earningruns.paypal');
        Route::post('earningruns/{earningrun}/reports', 'ReportController@store')->name('reports.store');
        Route::resource('users', 'UserController')->except('show');
        Route::get('users/{user}/impersonate', 'UserController@impersonate')->name('users.impersonate');
        Route::resource('contentowners', 'ContentOwnerController')->only('index');
        Route::resource('channels', 'ChannelController')->only('index');
    });
});
