<?php

use App\Livewire\Admin\Roles\{AssignPermissionToRole, CreateNewRole, RoleManagement};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Teams
    Route::group([
        'as' => 'teams.',
        'prefix' => 'teams',
        'controller' => \App\Http\Controllers\Teams\PermissionRoleController::class,
    ], function () {
        Route::get('/{team}/permissions-management', 'show')->can('manageTeam','team')->name('permissions-management');
    });

    // Roles
    Route::group([
        'as' => 'admin.roles.',
        'prefix' => 'roles',
    ], function () {
        Route::get('/', RoleManagement::class)->can('viewAny',\App\Models\Role::class)->name('list');
//        Route::get('/create', CreateNewRole::class)->can('create',\App\Models\Role::class)->name('create');
        Route::get('/create', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->can('create',\App\Models\Role::class)->name('create');
        Route::get('/{role}', AssignPermissionToRole::class)->can('view', 'role')->name('view');
        Route::delete('/{role}/delete', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->can('delete', 'role')->name('delete');
    });

    // Permissions
    Route::group([
        'as' => 'admin.permissions.',
        'prefix' => 'permissions',
        'controller' => \App\Http\Controllers\Admin\PermissionController::class,
    ], function () {
        Route::get('/', 'index')->can('viewAny', \App\Models\Permission::class)->name('list');
        Route::get('/create', 'create')->can('create', \App\Models\Permission::class)->name('create');
        Route::get('/{permission}', 'show')->can('view', 'permission')->name('view');
    });
});
