@extends('layout.main')
@section('body')
    <div class="container">
        <div class="row">
            <form action="{{route('createblog')}}" method="post">
                @csrf
                <label for="" class="form-label">title:</label>
                <input type="text" name="title" id="" class="form-control mb-2" placeholder="post title">
                <span class="text-danger d-block mb-2">
                    @error('title')
                        {{$message}}
                    @enderror
                </span>
                <label for="" class="form-label">post content:</label>
                <textarea name="content" id="" rows="8" class="form-control mb-2" placeholder="text here"></textarea>
                <span class="text-danger d-block mb-2">
                    @error('title')
                        {{$message}}
                    @enderror
                </span>
                <label for="" class="form-label">how can see thi post:</label>
                <input type="range" name="restrection" id="" class="form-range mb-2" min="0" max="4" step="1" value="3">
                <div class="d-flex justify-content-between mb-5">
                    <span>private</span>
                    <span>frinds</span>
                    <span>follows</span>
                    <span>frinds of follow</span>
                    <span>public</span>
                </div>
                <button type="submit" class="btn btn-outline-success fs-4 d-block  ms-auto">create</button>
            </form>
        </div>
    </div>
@endsection