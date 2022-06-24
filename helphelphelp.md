# Many to Many

Add many to many relationship between tags and posts

## Step 1

create methods in Post and Tag models

in Tag.php

```php
    /**
     * The posts that belong to the Tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
```

in Post.php

```php
    /**
     * The tags that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
```

## Step 2. Create migration for the pivot table

```bash
php artisan make:migration create_post_tag_table
```

## Step 3. Add foreing keys to the pivot table

```php
 Schema::create('post_tag', function (Blueprint $table) {
            
    $table->unsignedBigInteger('post_id');
    $table->foreign('post_id')->references('id')->on('posts');
    $table->unsignedBigInteger('tag_id');
    $table->foreign('tag_id')->references('id')->on('tags');
    $table->primary(['post_id', 'tag_id']);

});
```

## Step 4. run the migration

```bash

php artisan migrate
```

Attention!
La tabella Tags era stata creata a lezione vuota, non ha colonne eccetto id e timestamps, se hai seguito quanto fatto in classe bisogna aggiungere la colonna name alla tabella tags.

```bash
php artisan make:migration add_name_to_tags_table --table=tags
```

inside the migration file just created:

```php
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->string('name', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
```

Run the migration again

```bash

php artisan migrate
```

## Step 5

Seed the tags table

```php
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 10; $i++) { 
            $newTag = new App\Tag();
            $newTag->name = $faker->word(); 
            $newTag->save();
        }
    }
}

```

run the seeder

```
php artisan db:seed --class=TagSeeder
```

## Step 6. Attach and detach

Attach tags to posts via tinker

```bash
php artisan tinker

// show all tags
Tag::all()
// take the first tag
$tag = Tag::first()
// show all posts associated with a tag
$tag->posts
// attach to the tag the post with and id of 1
$tag->posts()->attach(1)

// Do the same starting from a post
// show all posts
Post::all()
// take the first tag
$post = Post::first()
// show all posts associated with a tag
$post->tags
// attach to the tag the post with and id of 1
$post->tags()->attach(1)

// Attach other posts to other tags
$post = Post::find(2)
$post->tags()->attach(2)
$post->tags()->attach(3)

// Detach from a post all tags
$post->tags()->detach()
// Detach from a post a tag - only incase has other tags attached
$post->tags()->detach(1)
```

## step 7. Add tags to the Posts CRUD (create/store)

### show all tags attached to a post in the post.show view

```html
<div class="tags">
        tags:
        @if(count($post->tags) > 0) 
            @foreach($post->tags as $tag)
                {{$tag->name}}
            @endforeach
        @else 
            <span>No tags</span>

        @endif
   
    </div>
    
```

### Add tags to a post when it's created (PostController.php)

Change the create method on the Post controller and returns all tags in the db

in the PostController@create method

```php
public function create()
{
    //get all tags
    $tags = Tag::all();
    //dd($tags);
    return view('posts.create', compact('tags'));
}
```

A Multiple select needs a name=tags[] to return multiple elements
posts/create.blade.php

```html

 <div class="form-group">
    <label for="tags">Tags</label>
    <select multiple class="form-control" name="tags[]" id="tags">
        @if($tags)
            @foreach($tags as $tag)
                <option value="{{$tag->id}}">{{$tag->name}}</option>
            @endforeach
        @endif
    </select>
    </div>
    @error('tags')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
```

### Attach tags to the post via the store method

```php
    public function store(Request $request)
    {
        //dd($request->all()); // get the request
        //dd($request->tags); // get all tags

        // validare i dati
        $validatedData = $request->validate([
           'title' => 'required',
           'body' => 'required' 
        ]);
       $new_post = Post::create($validatedData);
        
        
        // attach all tags to the post
        $new_post->tags()->attach($request->tags);
        
        return redirect()->route('posts.show', $new_post);
    }
```

### Validate tags before storing them in the database

Hack the form and add a tag that does not exit to prove db issue then
Add the tags validation like so.

```php
    $validatedData = $request->validate([
        'title' => 'required',
        'body' => 'required',
        'tags'=>'exists:tags,id'
    ]);
```

## Step 8. Add tags to the CRUD (edit/update)

add select form field to the edit form

```html
<div class="form-group">
<label for="tags">Tags</label>
<select multiple class="form-control" name="tags[]" id="tags">
    @if($tags)
        @foreach($tags as $tag)
            <option value="{{$tag->id}}" {{$post->tags->contains($tag) ? 'selected' : ''}}>{{$tag->name}}</option>
        @endforeach
    @endif
</select>
</div>
@error('tags')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

```

### update and validate

```php
    public function update(Request $request, Post $post)
    {
        
        //dd($request->tags); // check the tags first with a dd
        
        // validare i dati
         $validatedData = $request->validate([
           'title' => 'required',
           'body' => 'required',
           'tags' => 'exists:tags,id' //validate tags
        ]);

        //update post data
        $post->update($validatedData); 

        // Update tags with sync
        $post->tags()->sync($request->tags);
        return redirect()->route('posts.index');
    }
```