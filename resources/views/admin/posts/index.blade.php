@extends('layouts.admin')

@section('content')
    <div class="container py-4">

{{--         @php
            //dd($posts[1]);
            dd($posts[3]->tags);
        @endphp --}}

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="display-4 m-0">Posts List</h2>

            <a class="btn btn-primary btn-lg text-white" href="{{ route('admin.posts.create') }}">Create New Post</a>
        </div>

        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Tags</th>
                    <th>Slug</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category_id ? $categories[$post->category_id - 1]->name : 'null' }}</td>
                        <td>
                            <ul class="list-unstyled">
                                @forelse ($post->tags as $tag)
                                    <li>{{ $tag->name }} </li>
                                @empty

                                <li>None</li>
                                    
                                @endforelse
         
                            </ul>
                        </td>
                        <td>{{ $post->slug }}</td>
                        <td>{{ $post->content }}</td>
                        <td><img width="50px" src="{{ $post->image }}" alt="{{ $post->slug }}"></td>
                        <td>{{ date('d-m-Y', strtotime($post->date)) }}</td>
                        <td>

                            <div class="d-flex flex-column text-center">
                                <a class="mb-1 text-white btn btn-primary btn-sm"
                                    href="{{ route('admin.posts.show', $post->id) }}">View</a>
                                <a class="mb-1 text-white btn btn-info btn-sm"
                                    href="{{ route('admin.posts.edit', $post->id) }}">Edit</a>

                                <button type="button" class="text-white btn btn-danger btn-sm" data-bs-toggle="modal"
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
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
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
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td scope="row">No post to show</td>
                    </tr>
                @endforelse



            </tbody>
        </table>


    </div>
@endsection
