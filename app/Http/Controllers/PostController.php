<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function create(): View
    {
        return view('post.create',[
            'title' => 'Create POST page',
            'categories' => Category::query()->get(),
        ]);
    }

    public function store(StorePostRequest $request)
    {
//        App::setLocale('ru');
//        $request->validate();

        $data = $request->all();
        $data['slug'] = Str::slug($data['title']);
        $data['status'] = $request->status ? 1 : 0;

        Post::query()->create($data);
        return redirect()->route('post.create')->with('success', 'Post created!');
    }
}
