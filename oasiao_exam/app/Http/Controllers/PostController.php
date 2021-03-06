<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index',['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang = 'en')
    {
        App::setLocale($lang);
        session($lang);
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        Post::create([
            'title' => $request->input('title'),
            'extract' => $request->input('extract'),
            'content' => $request->input('content'),
            'access' => $request->input('access'),
            'publication' => $request->input('publication'),
            'user_id' => Auth::user()->id
        ]);

        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $currentPost = Post::find($id);
/*        if (Gate::forUser($user)->denies('update-post', $currentPost)) {
            // The user can't update the post...
            abort(403);
        }
        else{*/
            return view('posts.edit', ['post' => $currentPost]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Post::where('id',$id)->update([
            'title' => $request->input('title'),
            'extract' => $request->input('extract'),
            'content' => $request->input('content'),
            'access' => $request->input('access'),
            'publication' => $request->input('publication'),
        ]);

        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();
        $post->delete();

        return redirect('/posts');
    }
}
