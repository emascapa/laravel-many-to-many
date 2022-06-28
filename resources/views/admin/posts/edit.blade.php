@extends('layouts.admin')

@section('content')

    {{-- @php
    dd($post->content);
@endphp --}}

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('admin.posts.update', $post->id) }}" method="post" enctype="multipart/form-data"> {{-- {{route('admin.posts.update')}} --}}

            <h2 class="text-center">Edit post '{{ $post->title }}'</h2>

            @csrf

            @method('PUT')


            <div class="mb-3">
                <label for="title">Post Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ $post->title }}">

                @error('title')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id">Category</label>
                {{-- <textarea rows="3" type="text" name="category" id="category"
                    class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}">
                </textarea> --}}
                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                    <option disabled>Choose a category</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach

                </select>

            </div>

            <div class="mb-3">
                <label for="tag_id">Tags</label>

                <select class="form-control @error('category_id') is-invalid @enderror" multiple
                    data-mdb-placeholder="Select here tags" multiple name="tag_id[]" id="tag_id">

                    @forelse ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'selected' : '' }}>
                            {{ $tag->name }}</option>

                    @empty

                        <option value="">No tag</option>
                    @endforelse

                </select>
            </div>

            <div class="mb-3">
                <label for="content">Content</label>
                <textarea rows="3" type="text" name="content" id="content"
                    class="form-control @error('content') is-invalid @enderror" value="">
                    {{ $post->content }}
                </textarea>
            </div>

            <div class="mb-3">
                <label for="image">Post Image</label>
                <div class="row">
                    <div class="col">
                        <input type="file" name="image" id="image"
                            class="form-control @error('image') is-invalid @enderror">
                    </div>
                    <div class="col-2 text-end">

                        @if (substr($post->image, 0, 11) == 'post_images')
                            <img width="50px" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->slug }}">
                        @else
                            <img width="50px" src="{{ $post->image }}" alt="{{ $post->slug }}">
                        @endif

                    </div>
                </div>
            </div>

            <div class="mb-5">
                <label for="date">Date of the Post</label>
                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                    value="{{ $post->date }}">

                @error('date')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class=" btn btn-dark">Update Post</button>

        </form>
    </div>

@endsection
