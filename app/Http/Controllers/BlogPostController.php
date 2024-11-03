<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $postIds = Cache::remember('blog_post_ids', 60, function () {
            return BlogPost::latest()->pluck('id')->toArray();
        });
    
        $posts = BlogPost::with('user')
            ->whereIn('id', $postIds)
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);
    
        foreach ($posts as $post) {
            Cache::remember("blog_post_{$post->id}", 60, function () use ($post) {
                return $post; 
            });
        }
    
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        BlogPost::create([
            'title'   => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        Cache::forget('blog_post_ids');

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Cache::remember('blog_post_' . $id, 60, function () use ($id) {
            return BlogPost::findOrFail($id);
        });
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $post)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);
    
        $post->update($request->all());
    
        Cache::forget("blog_post_{$post->id}");
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $post)
    {
        $post->delete();

        Cache::forget('blog_post_' . $post->id);
        return redirect()->route('posts.index');
    }
}
