<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        $manager = app('impersonate');
        if($manager->getImpersonatorId()) {
            return redirect()->route('dashboard');
        }
        return view('welcome');
    });

    Route::prefix('admin')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/index', [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/user-data', [UserController::class, 'paginatedProjects'])->name('admin.user.data');
            Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        });

        Route::prefix('notification')->group(function () {
            Route::get('/index', [NotificationController::class, 'index'])->name('admin.notification.index');
            Route::get('/notification-data', [NotificationController::class, 'paginatedProjects'])->name('admin.notification.data');
            Route::get('/create', [NotificationController::class, 'create'])->name('admin.notification.create');
            Route::post('/store', [NotificationController::class, 'store'])->name('admin.notification.store');
            Route::post('/read', [NotificationController::class, 'read'])->name('admin.notification.read');
        });
    });

    // Route::resource('users', UserController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::prefix('admin')->group(function () {
    Route::prefix('project')->group(function () {
        Route::get('/index', [ProjectController::class, 'index'])->name('admin.project.index');
        Route::get('/projects-data', [ProjectController::class, 'paginatedProjects'])->name('admin.project.projects.data');
        Route::post('/store', [ProjectController::class, 'store'])->name('admin.project.projects.store');
    });
});

Route::prefix('admin')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('/categories-project', [CategoryController::class, 'projectsByCategory'])->name('admin.categories.projects');
        Route::get('/categories-projects-data', [CategoryController::class, 'projectsByCategoryId'])->name('admin.categories.projects.byid');
    });
});

require __DIR__.'/auth.php';

Route::impersonate();
