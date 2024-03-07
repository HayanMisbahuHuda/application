<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Album;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5000',
            'title' => 'required',
        ]);

        $post = new Post ;
        $post->title= $request->title;
        $post->description= $request->description;
        $post->user_id= auth()->id();
        $post->album_id = $request->input('album-id');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = time().','.$file->getClientOriginalExtension();
            $destinationaPath = public_path('/images');
            $file->move($destinationaPath, $fileName);
            $post->image = $fileName;
        }

        $post->save();
        return back()->withMessage('success','Photo post success!');

    }

    public function destroy($id) 
    {
        // $user_id = auth()->user()->id;
        // $post = Post::where('id', $id)->where('user_id', $user_id)->get();
        $post = Post::find($id);

        if (Storage::delete('/storage/albums/'.$post->album_id.'/' .$post->post)) {

            $post->delete();
            return back()->withMessage('success' , 'Photo deleted succesfully!');

        }
    }

    public function edit($id) 
    {
        $post = Post::find($id);
        return view('album.show', compact('album'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->title= $request->title;
        $post->description= $request->description;
        $post->user_id= auth()->id();

        if($request->hasFile('image'))
        {
            $destination = 'post-update'.$post->image;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
        $file = $request->file('image');
        $fileName = time().','.$file->getClientOriginalExtension();
        $destinationaPath = public_path('/images', $post->image);
        $file->move($destinationaPath, $fileName);
        $post->image = $fileName;
        }

        $post->update();
        return back()->withMessage('success' , 'Photo Update succesfully!');

    }
}
