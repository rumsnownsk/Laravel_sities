
@extends('layouts.default')

@section('content')


    <h1>{{ $title }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('post.store') }}" class="pt-2" method="post">

        @csrf
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" class="form-select form-select-lg mb-3" aria-label="Default select example">
                <option selected>Select category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{$category->title}}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="title" class="form-label">TITLE</label>
            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Post title" value="{{ old('title') }}">
{{--            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>--}}
            @if($errors->has('title'))
                <div class="invalid-feedback">
                    {{$errors->first('title')}}
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">content</label>
            <textarea name="content" class="form-control @error('title') is-invalid @enderror" id="content">{{old('content')}}</textarea>
            @if($errors->has('content'))
                <div class="invalid-feedback">
                    {{$errors->first('content')}}
                </div>
            @endif
        </div>
        <div class="mb-3 form-check">
            <input name="status" type="checkbox" class="form-check-input" id="status" @checked(old('status'))>
            <label class="form-check-label" for="status">status</label>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>



@endsection
