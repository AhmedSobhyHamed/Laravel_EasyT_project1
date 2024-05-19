<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Rules\alphnumonly;

use function Laravel\Prompts\error;
use function PHPUnit\Framework\callback;

class BlogController extends Controller
{
    protected $friends = [];
    protected $follows = [];
    protected $friendfriends = [];

    /**
     * utilities
     */
    protected function relasionships (int $id):void {
        // get user 
        // get user frinds
        // that i follow so i can see posts for follows and more 
        $result = Follow::all()->where('user',$id);
        foreach($result as $friend) {
            $this->follows [] = $friend->followed;
        }
        // that i follow and he follow back so i can see posts for frind and more 
        $result = Follow::where('followed',$id)->whereIn('user',$this->follows)->get();
        foreach($result as $friend) {
            $this->friends [] = $friend->user;
        }
        // get frinds of user follow
        // that frinds follows and so i can see posts for frinds of frind and more 
        $result = Follow::whereIn('user',$this->follows)->where('followed','!=',$id)->distinct()->get(['followed']);
        foreach($result as $friend) {
            $this->friendfriends [] = $friend->followed;
        }
        $result = Follow::whereIn('user',$this->friendfriends)->whereIn('followed',$this->follows)->get();
        $this->friendfriends = [];
        foreach($result as $friend) {
            $this->friendfriends [] = $friend->user;
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        if(isset($req->lastblogfrind)) $fndlimitstart = $req->lastblogfrind+1;
        else $fndlimitstart = 0;
        if(isset($req->lastblogfrind)) $flwlimitstart = $req->lastblogfollow+1;
        else $flwlimitstart = 0;
        if(isset($req->lastblogfrind)) $ffdlimitstart = $req->lastblogfrindfollow+1;
        else $ffdlimitstart = 0;
        if(isset($req->lastblogfrind)) $publimitstart = $req->lastblogpublic+1;
        else $publimitstart = 0;
        // $fndlimitstart = $req->lastblogfrind+1;
        // $flwlimitstart = $req->lastblogfollow+1;
        // $ffdlimitstart = $req->lastblogfrindfollow+1;
        // $publimitstart = $req->lastblogpublic+1;

        $blogArray = [];

        $blogIDpvt = [];
        $blogIDfnd = [];
        $blogIDflw = [];
        $blogIDfnfd = [];
        $blogIDpub = [];

        $blogposts = [];
        // setup relationships
        $this->relasionships(Auth::id());
        // get all posts for private -- posts must be >= private
        $HomeBlogs = Blog::where('auther',Auth::id())->where('visabilty','>=',0)->orderByDesc('updated_at')->offset($fndlimitstart)->limit(100)->get(['id']);
        foreach($HomeBlogs as $blg) {
            $blogIDpvt [] = $blg->id;
        }
        // get all posts for frinds -- posts must be >= frinds
        $HomeBlogs = Blog::whereIn('auther',$this->friends)->where('visabilty','>=',1)->orderByDesc('updated_at')->offset($fndlimitstart)->limit(600)->get(['id']);
        foreach($HomeBlogs as $blg) {
            $blogIDfnd [] = $blg->id;
        }
        // get all posts for follows -- posts must be >= follows
        $HomeBlogs = Blog::whereIn('auther',$this->follows)->where('visabilty','>=',2)->orderByDesc('updated_at')->offset($flwlimitstart)->limit(400)->get(['id']);
        foreach($HomeBlogs as $blg) {
            $blogIDflw [] = $blg->id;
        }
        // get all posts for friends of frinds -- posts must be >= frinds of friends
        $HomeBlogs = Blog::whereIn('auther',$this->friendfriends)->where('visabilty','>=',3)->orderByDesc('updated_at')->offset($ffdlimitstart)->limit(200)->get(['id']);
        foreach($HomeBlogs as $blg) {
            $blogIDfnfd [] = $blg->id;
        }
        // get all posts for all -- posts must be >= public
        $HomeBlogs = Blog::where('visabilty','>=',4)->orderByDesc('updated_at')->offset($publimitstart)->limit(100)->get(['id']);
        foreach($HomeBlogs as $blg) {
            $blogIDpub [] = $blg->id;
        }
        // sort by date 
        $pvtcount  =0;
        $fndcount  =0;
        $flwcount  =0;
        $fnfdcount =0;
        $pubcount  =0;
        while(true) {
            if($fndcount > count($blogIDfnd)-1 &&
                $flwcount > count($blogIDflw)-1 &&
                $fnfdcount > count($blogIDfnfd)-1 &&
                $pvtcount > count($blogIDpvt)-1 &&
                $pubcount > count($blogIDpub)-1 ) break;
            if($fndcount < count($blogIDfnd)) $blogArray[] = $blogIDfnd[$fndcount++];
            if($fndcount < count($blogIDfnd)) $blogArray[] = $blogIDfnd[$fndcount++];
            if($flwcount < count($blogIDflw)) $blogArray[] = $blogIDflw[$flwcount++];
            if($fndcount < count($blogIDfnd)) $blogArray[] = $blogIDfnd[$fndcount++];
            if($flwcount < count($blogIDflw)) $blogArray[] = $blogIDflw[$flwcount++];
            if($fnfdcount < count($blogIDfnfd)) $blogArray[] = $blogIDfnfd[$fnfdcount++];
            if($fndcount < count($blogIDfnd)) $blogArray[] = $blogIDfnd[$fndcount++];
            if($flwcount < count($blogIDflw)) $blogArray[] = $blogIDflw[$flwcount++];
            if($fnfdcount < count($blogIDfnfd)) $blogArray[] = $blogIDfnfd[$fnfdcount++];
            if($pubcount < count($blogIDpub)) $blogArray[] = $blogIDpub[$pubcount++];
            if($pvtcount < count($blogIDpvt)) $blogArray[] = $blogIDpvt[$pvtcount++];
        }
        $blogArray = array_unique($blogArray);
        // send title and id to view
        foreach($blogArray as $blogpost) {
            $authname = Blog::where('id',$blogpost)->get(['auther']);
            $post = Blog::where('id',$blogpost)->first();
            $post->authername = User::find($post->auther)->name;
            $blogposts[] = $post;
        }
        return view('blog.homebody')
        ->with('title','Blog Home')
        ->with('pageicon','')
        ->with('pageDescription','')
        ->with('pageKeywords','')
        ->with('pageOGimg','')
        ->with('pageStyle',url('storage/css/signup.css'))
        ->with('pageScript','')
        ->with('blogposts',$blogposts);
        // return $blogposts;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create')
        ->with('title','Create Blog')
        ->with('pageicon','')
        ->with('pageDescription','')
        ->with('pageKeywords','')
        ->with('pageOGimg','')
        ->with('pageStyle',url('storage/css/signup.css'))
        ->with('pageScript','');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:255|min:5',
            'content'=> 'required',
            'restrection'=> 'required|integer|min:0|max:4'
        ]);
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->visabilty = $request->restrection;
        $blog->auther = Auth::id();
        $blog->save();
        // Blog::create([
        //     'title'=>$request->title,
        //     'content'=>$request->content,
        //     'visabilty'=>$request->restrection,
        //     'auther'=>Auth::id()
        // ]);
        redirect(route('blogRoute'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $r, Blog $blog)
    {        
        $postVisabilty = false;
        $blog = Blog::find($r->route('id'));
        //get relationshps
        $this->relasionships(Auth::id());
        // check if user allowed to see 

        switch ($blog->visabilty) {
            case 4: //public
                $postVisabilty |= true;
            case 3: //follows of frinds
                foreach ($this->friendfriends as $var) {
                    if($blog->auther === $var) {
                        $postVisabilty |= true;
                        break;
                    }
                }
            case 2: //follows only
                foreach ($this->follows as $var) {
                    if($blog->auther === $var) {
                        $postVisabilty |= true;
                        break;
                    }
                }
            case 1: //friends only
                foreach ($this->friends as $var) {
                    if($blog->auther === $var) {
                        $postVisabilty |= true;
                        break;
                    }
                }
            case 0: //private
                if($blog->auther === Auth::id()) {
                    $postVisabilty |= true;
                }
        }
        // see if auth::id and blog->auther relationship under the allowed blog-<visabilty
        if($postVisabilty) {
            $comments = Comment::where('blog',$blog->id)->get();
            $likereactcount    = count(Reaction::where('blog',$blog->id)->where('is_likes',1)->get());
            $dislikereactcount = count(Reaction::where('blog',$blog->id)->where('is_likes',0)->get());
            return view('blog.postview')
            ->with('title',$blog->title)
            ->with('pageicon','')
            ->with('pageDescription','')
            ->with('pageKeywords','')
            ->with('pageOGimg','')
            ->with('pageStyle',url('storage/css/signup.css'))
            ->with('pageScript','')
            ->with('blogtitle',$blog->title)
            ->with('blogvisabilty',$blog->visabilty)
            ->with('blogauther',User::find($blog->auther)->name)
            ->with('blogcontent',$blog->content)
            ->with('blogCRdate',$blog->created_at)
            ->with('blogUPdate',$blog->updated_at)
            ->with('likecount',$likereactcount)
            ->with('dislikecount',$dislikereactcount)
            ->with('comments',$comments);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
