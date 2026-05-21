<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Audit;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'total_users' => User::count(),
            'total_comments' => Comment::count(),
            'recent_posts' => Post::latest()->take(5)->get(),
            'recent_audits' => Audit::latest()->take(10)->get(),
        ];

        return view('admin.dashboard', $stats);
    }
}