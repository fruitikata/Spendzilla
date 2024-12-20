<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $query = Post::where('user_id', auth()->id());

        // Search Functionality
        if ($request->filled('search')) {
            $query->where('category', 'like', '%' . $request->search . '%')
                  ->orWhere('amount', 'like', '%' . $request->search . '%');
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'date_asc':
                    $query->orderBy('date', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('date', 'desc');
                    break;
                case 'category_asc':
                    $query->orderBy('category', 'asc');
                    break;
                case 'category_desc':
                    $query->orderBy('category', 'desc');
                    break;
                case 'amount_asc':
                    $query->orderBy('amount', 'asc');
                    break;
                case 'amount_desc':
                    $query->orderBy('amount', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Default sort
        }


        // Fetch Results
        $posts = $query->get();

        return view('posts.home', compact('posts'));
    }

    //upload expense
    public function store(Request $request)
    {

        $post = FacadesAuth::user()->posts()->create($request->all());

        //send email
        Mail::to(FacadesAuth::user())->send(new WelcomeMail(FacadesAuth::user(), $post));


        return back()->with('success', 'Expense added. What a splurger!');

    }

    public function destroy(Post $post)
    {
        // Check if the post belongs to the authenticated user
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action');
        }

        // Delete the post
        $post->delete();

        // Redirect back with a success message
        return redirect()->route('posts.index')->with('success', 'Expense deleted successfully');
    }

    public function edit(Post $post)
    {
        // Check if the post belongs to the authenticated user
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action');
        }

        // Return the view with the post data
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Check if the post belongs to the authenticated user
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action');
        }

        // Validate the input
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Update the post with the validated data
        $post->update($validated);

        // Redirect with a success message
        return redirect()->route('posts.index')->with('success', 'Expense updated successfully');
    }
}
