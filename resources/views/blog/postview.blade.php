@extends('layout.main')
@section('body')
    <div class="container">
        <div class="border p-2">
            <p>{{$blogtitle}}</p>
            <p>Auther : {{$blogauther}}</p>
            <p>content : {{$blogcontent}}</p>
            <br>
            <br>
            <p>visability : 
                @switch($blogvisabilty)
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
            </p>
            <br>
            <br>
            <p>
                <span>created at:{{$blogCRdate}}</span>
                <span>upated at:{{$blogUPdate}}</span>
            </p>
        </div>
        <div class="border p-2">
            <p>likes: <span>{{$likecount}}</span></p>
            <p>dislikes: <span>{{$dislikecount}}</span></p>
        </div>
        <div class="border p-3">
            @foreach ($comments as $comment)
                <div class="p-2 border mb-2">
                    <p>user: {{App\Models\User::find($comment->user)->name}}</p>
                    <p>{{$comment->content}}</p>
                    <p>date: {{$comment->updated_at}}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
