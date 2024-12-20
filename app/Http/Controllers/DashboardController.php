<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){

        $posts = Auth::user()->posts;

        return view('users.dashboard', ['posts' => $posts]);
    }

    public function dashboard(){
        $category = Post::where('user_id', auth()->id())
                    ->groupBy('category')
                    ->selectRaw('category, sum(amount) as total_amount')
                    ->get();
        
        $categoryLabels = $category->pluck('category');
        $categoryData = $category->pluck('total_amount');
    
        return view('users.dashboard', compact('categoryLabels', 'categoryData'));

    }
    


}