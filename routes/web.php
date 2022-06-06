<?php

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('teste', function () {
    $client = Client::first();
    $token = $client->createToken('token-teste');

    dd($token->plainTextToken);
});

Route::prefix('admin')->namespace('Admin')->middleware('auth')->group(function () {
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

    // Roles
    Route::any('roles/search', 'ACL\RoleController@search')
        ->name('roles.search');
    Route::resource('roles', 'ACL\RoleController');

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
    
    // Permission x Role
    Route::get('roles/{role}/permissions', 'ACL\PermissionRoleController@index')
        ->name('roles.permissions');
    Route::get('permissions/{permission}/role', 'ACL\PermissionRoleController@roles')
        ->name('permissions.roles');
    Route::any('roles/{role}/permissions/create', 'ACL\PermissionRoleController@create')
        ->name('roles.permissions.create');
    Route::post('roles/{role}/permissions/store', 'ACL\PermissionRoleController@store')
        ->name('roles.permissions.store');
    Route::get('roles/{role}/permissions/{permission}/delete', 'ACL\PermissionRoleController@delete')
        ->name('roles.permissions.delete');
    
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

    // Users
    Route::any('users/search', 'UserController@search')->name('users.search');
    Route::resource('users', 'UserController');

    // Role x User
    Route::get('users/{user}/roles', 'ACL\RoleUserController@index')
        ->name('users.roles');
    Route::get('roles/{role}/users', 'ACL\RoleUserController@users')
        ->name('roles.users');
    Route::any('users/{user}/roles/create', 'ACL\RoleUserController@create')
        ->name('users.roles.create');
    Route::post('users/{user}/roles/store', 'ACL\RoleUserController@store')
        ->name('users.roles.store');
    Route::get('users/{user}/roles/{role}/delete', 'ACL\RoleUserController@delete')
        ->name('users.roles.delete');

    // Categories
    Route::any('categories/search', 'CategoryController@search')->name('categories.search');
    Route::resource('categories', 'CategoryController');

    // Products
    Route::any('products/search', 'ProductController@search')->name('products.search');
    Route::resource('products', 'ProductController');

    // Tables
    Route::any('tables/search', 'TableController@search')->name('tables.search');
    Route::get('tables/qrcode/{identify}', 'TableController@qrcode')->name('tables.qrcode');
    Route::resource('tables', 'TableController');

    // Tenants
    Route::any('tenants/search', 'TenantController@search')->name('tenants.search');
    Route::resource('tenants', 'TenantController');

    // Product x Category
    Route::get('products/{product}/categories', 'CategoryProductController@index')
        ->name('products.categories');
    Route::get('categories/{profile}/products', 'CategoryProductController@products')
        ->name('categories.products');
    Route::any('products/{product}/categories/create', 'CategoryProductController@create')
        ->name('products.categories.create');
    Route::post('products/{product}/categories/store', 'CategoryProductController@store')
        ->name('products.categories.store');
    Route::get('products/{product}/categories/{category}/delete', 'CategoryProductController@delete')
        ->name('products.categories.delete');

    // Orders
    Route::get('orders', 'OrderController@index')->name('orders.index');

    // Home dashboard
    Route::get('/', 'DashboardController@home')->name('admin.index');
});

Route::get('/', 'Site\SiteController@index')->name('site.home');
Route::get('/plan/{url}', 'Site\SiteController@plan')->name('plan.subscription');

Auth::routes();
