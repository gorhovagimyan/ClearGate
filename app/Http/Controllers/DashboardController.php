<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'totalPosts' => Post::where('user_id', $user->id)->count(),
            'recentPosts' => Post::where('user_id', $user->id)
                ->where('created_at', '>=', now()->subDays(7))
                ->count()
        ];

        $recentPosts = Post::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentPosts' => $recentPosts
        ]);
    }
} 