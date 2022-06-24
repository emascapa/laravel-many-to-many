@extends('layouts.admin')

@section('content')
{{--     @php
    //dd($posts[1]);
    dd($posts->tags);
    @endphp --}}

    <div class="container py-4">

        <div class="row g-3">
            <div class="col-12 col-md-6">
                <img class="img-fluid rounded rounded-4" src="{{ $post->image }}" alt="{{ $post->slug }}">
            </div>
            <div class="col-12 col-md-6 p-3">
                <div class="text-center d-flex flex-column">
                    <h2 class="mb-1">{{ $post->title }}</h2>
                    <span class="mb-3">Slug: {{ $post->slug }}</span>
                    <p class="mb-3">Category: {{ ($post->category_id) ? $categories[$post->category_id - 1]->name : 'none' }}</p>
                    <span>Tags: 
                        @forelse ($post->tags as $tag)
                            #{{$tag->name}}
                        @empty
                            None
                        @endforelse
                    </span>
                    <p class="mb-3">{{ $post->content }}</p>
                    <span class="mb-3">Date: {{ date('d-m-Y', strtotime($post->date)) }}</span>

                    <div class="">
                        <a class="me-3 text-white btn btn-info btn-lg"
                            href="{{ route('admin.posts.edit', $post->id) }}">Edit</a>

                        <button type="button" class="text-white btn btn-danger btn-lg" data-bs-toggle="modal"
                            data-bs-target="#delete-post-{{ $post->id }}">
                            Delete
                        </button>
                    </div>

                    <div class="modal fade" id="delete-post-{{ $post->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Post</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure to delete the post named: "{{ $post->title }}"?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    {{-- <button type="button" class="btn btn-primary">Save</button> --}}

                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post">

                                        @csrf

                                        @method('DELETE')

                                        <button class="text-white btn btn-danger" type="submit">Delete</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
