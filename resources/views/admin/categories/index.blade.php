@extends('layouts.admin')

@section('content')
    <div class="container py-4">

        <h2 class="display-4 mb-3">Categories List</h2>

        <form action="{{route('admin.categories.store')}}" method="post">
            @csrf
            <div class="input-group mb-3">


                <input type="text" name="name" id="name" class="form-control me-3 rounded-pill" placeholder="Category Name" aria-label="Recipient's username"
                    aria-describedby="button-addon2">

                <button class="btn btn-primary text-white rounded-pill px-4" type="submit" id="button-addon2">Add</button>

            </div>
        </form>

        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <form action="{{route('admin.categories.destroy', $category->id)}}" method="post">
                            
                            @csrf

                            @method('DELETE')

                            <button class="btn btn-danger btn-sm text-white" type="submit">Delete</button>
                            
                            </form>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td scope="row">No Category to show</td>
                    </tr>
                @endforelse



            </tbody>
        </table>


    </div>
@endsection
