<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


        $filename = time() . '.' . $request->image->extension();

        // chemin des images stocker dans le storage
        $image = $request->file('image')->storeAs('images', $filename, 'public');



        $post = Post::create([
            'text' => $request['text'],
            'like' => 0,
            'id_user' => $request['id_user'],
            'title' => $request['title'],
            'image' => $image

        ]);



        return response()->json(['post' => $post, 'message' => 'Post publié']);
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
        //
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
        // récupérer id du post a modifier

        $update_post = Post::find($id);

        $update_post->title = $request['title'];
        $update_post->text = $request['text'];


        $update_post->save();

        return response()->json(["message" => "Post modifié", 'post' => $update_post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function file(Request $request)
    {
        $result = $request->file('file')->store("apiDocs");

        return ["result" => $result];
    }
}
