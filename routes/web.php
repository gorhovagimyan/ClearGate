<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Inertia\Inertia;
use App\Http\Middleware\ApiTokenMiddleware;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;

// Share auth data with all requests
Inertia::share([
    'auth' => function () {
        return [
            'user' => auth()->user() ? [
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'created_at' => auth()->user()->created_at,
            ] : null
        ];
    },
]);

// API routes that require authentication
// Route::middleware(['auth:sanctum', 'web'])->group(function () {
//     Route::get('/api/user', function (Request $request) {
//         return $request->user();
//     });
    
//     // Add other API routes that need authentication here
//     Route::get('/api/dashboard', [DashboardController::class, 'index']);
// });

// Public routes
// Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });

    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
// });

// Protected routes
Route::middleware('auth')->group(function () {
    // Redirect root to dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Dashboard route
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'stats' => [
                'tasksCount' => \App\Models\Task::where('user_id', auth()->id())->count(),
            ]
        ]);
    })->name('dashboard');

    // Tasks routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    
    // Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Catch-all route for guest users
Route::get('{all}', function () {
    return redirect('/login');
})->where('all', '.*')->middleware('guest');
