<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Phone;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Barryvdh\Debugbar\Twig\Extension\Dump;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/users'), true);
        return view('admin.index')->with([
            'title2' => 'Postssssss',
            'footerData' => 'foooooter',
            'users' => $users,
        ]);
    }

    public function workWithFacadeDB()
    {
        $countCats = DB::table('categories')->count();
        $random_category = array_rand(range(1, $countCats))+1;
        try {
            $nsrt = DB::insert('insert into posts (title, content, category_id) values (:title, :content, :category_id)', [
                'title'=>'post #',
                'content'=>'lorem ipsum',
                'category_id'=> $random_category
            ]);
            dump("insert success: " . $nsrt);
        } catch (\Throwable $th) {
            dump("insert ERROR: " . $th->getMessage());
        }

        try {
            $pdt = DB::update('update posts set category_id = :category_id, updated_at = NOW() where id = :id', [
                'category_id' => $random_category,
                'id' => 3,
            ]);
            dump("update success: " . $pdt);
        } catch (\Throwable $th) {
            dump("update ERROR: " . $th->getMessage());
        }

        $res = DB::select("select * from users where id > :id and name != :name",[
            'id' => 1,
            'name' => 'Nicholas'
        ]);
        dump($res);

    }

    public function relationOneToOne()
    {
//        $user = DB::table('users')->find(1);
        $user = User::query()->find(1);

        dump('связь HasOne: $user->phone->phone = '.$user->phone->phone);

        $phone = Phone::query()->find(3);
        dump('связь beLongsTo: $phone->user->name = '.$phone->user->name);
    }

    public function relationOneToMany()
    {
        $post = Post::query()->find(1);
        dump('связь beLongsTo: = '.$post->category->title);

        $category = Category::query()->find(1);
        dump(['связь: ' => $category->posts->toArray()]);

        dump(['работа со связанной моделью' => $category->posts()->orderBy('id', 'desc')->get()->toArray()]);


        $allCategories = Category::query()->withCount('posts')->get();
        dump($allCategories->toArray());

    }

    public function relationManyToMany()
    {
        $post = Post::query()->find(1);
        dump($post->tags->toArray());

        $tag = Tag::query()->find(1);
        dump($tag->posts->toArray());

        $posts = Post::with('tags')->get();
        foreach ($posts as $post) {
            echo '<ul>'.$post->title.'</ul>';
            foreach ($post->tags as $tag) {
                echo '<li>'.$tag->title.'</li>';
            }
        }

        \dump(Category::query()->find(1)->oldestPost->toArray());
    }

    public function relationSave(): void
    {
//        Post::query()->create([
//            'title' => 'post #',
//            'content' => 'lorem ipsum',
//            'category_id' => 3,
//            'slug' => Str::slug('lorem ipsum'),
//            'user_id' => 3,
//        ]);

        $category1 = Category::query()->find(1);
//        $category1->posts()->save(new Post([
//            'title' => 'post #',
//            'content' => 'loremjjj ipsum',
//            'slug' => Str::slug('lor2dem ipsum'),
//            'user_id' => 3,
//        ]));

        $post = Post::query()->find(7);
        $post->tags()->attach([2, 3]);



    }

    public function about(): View
    {
        return view('admin.about')->with([
            'title' => 'Posts',
        ]);
    }

    public function insertUsers()
    {
        $usersList = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/users'), true);

        if (empty($usersList)) {
            return redirect()->route('admin.index');
        }
        User::query()->truncate();

        $values = [];
        foreach ($usersList as $user) {
            $values[] = [
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make(Str::random(10)),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
//            dump($user['name']);
        }
        $inserts = DB::table('users')->insertOrIgnore($values);
        return "count inserted users: " . $inserts. '; <a href="/admin"  >back</a>';

    }
    public function contact(): View
    {
        return view('admin.contact')->with([
            'title' => 'Posts',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
