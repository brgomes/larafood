<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->namespace('Admin')->group(function () {
    // Details plans
    Route::get('plans/{url}/details', 'DetailPlanController@index')
        ->name('details.plan.index');
    Route::get('plans/{url}/details/create', 'DetailPlanController@create')
        ->name('details.plan.create');
    Route::post('plans/{url}/details/store', 'DetailPlanController@store')
        ->name('details.plan.store');
    Route::get('plans/{url}/details/{detail}/edit', 'DetailPlanController@edit')
        ->name('details.plan.edit');
    Route::put('plans/{url}/details/{detail}', 'DetailPlanController@update')
        ->name('details.plan.update');
    Route::get('plans/{url}/details/{detail}', 'DetailPlanController@show')
        ->name('details.plan.show');
    Route::delete('plans/{url}/details/{detail}', 'DetailPlanController@destroy')
        ->name('details.plan.destroy');

    // Plans
    Route::any('plans/search', 'PlanController@search')->name('plans.search');
    Route::get('plans', 'PlanController@index')->name('plans.index');
    Route::get('plans/create', 'PlanController@create')->name('plans.create');
    Route::post('plans/store', 'PlanController@store')->name('plans.store');
    Route::get('plans/{url}', 'PlanController@show')->name('plans.show');
    Route::get('plans/{url}/edit', 'PlanController@edit')->name('plans.edit');
    Route::put('plans/{url}', 'PlanController@update')->name('plans.update');
    Route::delete('plans/{url}', 'PlanController@destroy')->name('plans.destroy');

    // Profiles
    Route::any('profiles/search', 'ACL\ProfileController@search')
        ->name('profiles.search');
    Route::resource('profiles', 'ACL\ProfileController');

    // Permissions
    Route::any('permissions/search', 'ACL\PermissionController@search')
        ->name('permissions.search');
    Route::resource('permissions', 'ACL\PermissionController');

    // Permission x Profile
    Route::get('profiles/{profile}/permissions', 'ACL\PermissionProfileController@index')
        ->name('profiles.permissions');
    Route::get('permissions/{permission}/profile', 'ACL\PermissionProfileController@profiles')
        ->name('permissions.profiles');
    Route::any('profiles/{profile}/permissions/create', 'ACL\PermissionProfileController@create')
        ->name('profiles.permissions.create');
    Route::post('profiles/{profile}/permissions/store', 'ACL\PermissionProfileController@store')
        ->name('profiles.permissions.store');
    Route::get('profiles/{profile}/permissions/{permission}/delete', 'ACL\PermissionProfileController@delete')
        ->name('profiles.permissions.delete');
    
    // Plan x Profile
    Route::get('plans/{plan}/profiles', 'ACL\PlanProfileController@profiles')
        ->name('plans.profiles');
    Route::get('profiles/{profile}/plans', 'ACL\PlanProfileController@plans')
        ->name('profiles.plans');
    Route::any('plans/{plan}/profiles/create', 'ACL\PlanProfileController@create')
        ->name('plans.profiles.create');
    Route::post('plans/{plan}/profiles/store', 'ACL\PlanProfileController@store')
        ->name('plans.profiles.store');
    Route::get('plans/{plan}/profiles/{profile}/delete', 'ACL\PlanProfileController@delete')
        ->name('plans.profiles.delete');

    // Home dashboard
    Route::get('/', 'PlanController@index')->name('admin.index');
});

Route::get('/', function () {
    return view('welcome');
});
