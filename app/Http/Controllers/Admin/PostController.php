<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Http\Requests\PostRequest;

use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::orderByDesc('id')->get();

        $categories = Category::all();

        $tags = Tag::all();

/*         $posts_tags = 
 */
        return view('admin.posts.index', compact('posts', 'categories', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();

        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //

        //dd($request->all());
        
        $data = $request->validated();
        
        
        
        //$data = $request->all();
        
        //dd($request->tag_id);

        $data['slug'] = Str::slug($request->title, '-');


        if (array_key_exists('image', $request->all())) {

            $request->validate([
                'image' => 'nullable|image|max:300'
            ]);


            //dd($request->all());


            $img_path = Storage::put('post_images', $request->image);

            //dd(Storage::put('post_images', $request->cover_image));
            $data['image'] = $img_path;

        };

        //dd($data);

        $new_post = Post::create($data);

        $new_post->tags()->attach($request->tag_id);
        

        return redirect()->route('admin.posts.index'); 
   /*      Post::create($data);



        return redirect()->route('admin.posts.index'); */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        //dd($post);

        $categories = Category::all();

        $tags = Tag::all();



        return view('admin.posts.show', compact('post', 'categories', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        $categories = Category::all();

        $tags = Tag::all();
        


        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        //
        $data = $request->validated();
        
        //$data = $request->all();
        
        //dd($data);

        $data['slug'] = Str::slug($request->title, '-');

 

        
        $post->update($data);


        $post->tags()->sync($request->tag_id);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
