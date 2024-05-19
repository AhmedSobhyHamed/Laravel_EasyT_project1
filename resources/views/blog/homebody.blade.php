@extends('layout.main')
@section('body')
    <div class="container">
        <div class="row border border-black rounded-3 mb-3">
            <a href="{{route('blogcreateui')}}" class=" btn btn-success p-3 fs-1 text-capitalize w-100">
                add a new post
            </a>
        </div>
        @foreach ($blogposts as $post)
            <div class="row border border-black rounded-3 p-3 mb-3 d-lg-flex">
                <div class="col-lg-2 d-flex d-lg-block">
                    <img src="" alt="" class="rounded-circle border border-2 bg-success mb-2 me-2" width="30" height="30">
                    <div class="">{{$post->authername}}</div>
                </div>
                <div class="col-lg-10 d-flex flex-column align-items-end">
                    <div class="">who can see: <span class="badge bg-secondary">
                        @switch($post->visabilty)
                            @case(0)
                                Private
                                @break
                            @case(1)
                                Frinds
                                @break
                            @case(2)
                                Follows
                                @break
                            @case(3)
                                Frinds of follow
                                @break
                            @case(4)
                                public
                                @break
                            @default
                                
                        @endswitch
                        </span></div>
                    <h3 class="align-self-start">{{$post->title}}</h3>
                    <div class="">{{$post->updated_at}}</div>
                    <a href="{{route('blogpost',['id'=>$post->id])}}" class="align-self-center btn btn-success text-capitalize">open this article</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
