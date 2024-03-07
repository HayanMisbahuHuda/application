<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;

class AlbumController extends Controller
{
    public function index(){
        $albums = Album::get();

        return view('albums.index')->with('albums',$albums);
    }

    // public function create(){
    //     return view('albums.create');
    // }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'cover-image' => 'required|image|mimes:jpg,jpeg,png|max:5000',
        ]);

        $filenameWithExtension = $request->file('cover-image')->getClientOriginalName();

        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

        $extension = $request->file('cover-image')->getClientOriginalExtension();

        $filenameToStore = $filename . '_' . time() . '.' . $extension;

        $request->file('cover-image')->storeAs('public/album_covers', $filenameToStore);

        

        $album = new Album();
        $album->title = $request->input('title');
        $album->description = $request->input('description');
        $album->image = $filenameToStore;
        $album->user_id = auth()->user()->id;
        $album->save();
        
        return back()->withMessage('success','Album created successfully!');
    }
    
    public function show($id) {
        $album = Album::with('posts')->find($id);

        return view('albums.show',compact('album'));
    }
}
