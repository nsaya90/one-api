<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $list = DB::table('posts')->where('id_user', $id)->get();
        return response()->json(["list" => $list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string', 'max:255'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg'],
        ]);

        $filename = time() . '.' . $request->image->extension();

        // // chemin des images stocker dans le storage
        $image = $request->file('image')->storeAs('images', $filename, 'public');

        $id_user = Auth::id();

        $post = Post::create([
            'text' => $request['text'],
            'like' => 0,
            'title' => $request['title'],
            'image' => $image,
            'id_user' => $id_user,


        ]);



        return response()->json(['post' => $post, 'message' => 'Post publié']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id_user = Auth::user();
        $post = $id_user->post;
        return response()->json(["message" => "post affiché", 'post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request, $id)
    {
        // récupérer id du post a modifier
        $user_id = Auth::id();

        $refresh_post = Post::where([
            ["id", $id],
            ["id_user", $user_id]
        ])->firstOrFail();

        $refresh_post->title = $request->title;
        $refresh_post->text = $request->text;
        $refresh_post->image = $request->image;

        $refresh_post->save();

        return response()->json(["message" => "post modifié"]);

        // $update_post = Post::whereIn($id);

        // $update_post->title = $request['title'];
        // $update_post->text = $request['text'];


        // $update_post->save();

        // return response()->json(["message" => "Post modifié", 'post' => $update_post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destro($id)
    // {
    //     //
    // }

    public function file(Request $request)
    {
        $result = $request->file('file')->store("apiDocs");

        return ["result" => $result];
    }

    public function showPost($id)
    {

        $user_id = Auth::id();

        $post = Post::where([
            ["id", $id],
            ["id_user", $user_id]
        ])->firstOrFail();

        return response()->json(["post" => $post]);
    }
}
