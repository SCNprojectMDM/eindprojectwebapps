<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /** Zorgt ervoor dat je alleen op de pagina's home en op de blog post unt kijken als je niet ingelogd bent */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // hier kun je de berichten laten pagineren en sorteren

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
//      $posts = Post::orderBy('title', 'desc')->get();
        return view('posts.index')->with('posts', $posts);

        //$post = DB:select('select * from posts');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // dit zorgt ervoor dat je de pagina 'create' te zien krijgt

    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // hier check je of alle velden zijn ingevuld

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_image')){

            // filename krijgen met extensie

            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // alleen file naam krijgen

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // alleen extensie

            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // Filename to store

            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Upload Image

            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

        } else {
            $fileNameToStore = 'noimage.jpg';
        }


        // Hier maak je het bericht aan
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('succes', 'Post Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // hier laat je de volledige pagina van een bericht zien als je erop hebt geklikt

    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    // hier laat je de bewerk pagina zien

    public function edit($id)
    {

        $post = Post::find($id);

        // kijken of het de goede gebruiker is

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Log in om deze pagina te bekekijken.');
        }

        return view('posts.edit')->with('post', $post);
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

        // hier kijk je of de gebruiker nieuwe data heeft opgegeven om te vervangen met de oude informatie

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        if($request->hasFile('cover_image')){

            // filename krijgen met extensie

            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // alleen file naam krijgen

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // alleen extensie

            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // Filename to store

            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Upload Image

            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }


        // hier update je het bericht

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')) {
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('succes', 'Post Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        // als het niet de goede gebruiker is krijg je de pagina niet te zien

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Log in om deze actie uit te voeren.');
        }

        if($post->cover_image != 'noimage.jpg'){
            //  Verwijder de afbeelding
            Storage::delete('public/cover_image/'.'$post->cover_image');
        }

        $post->delete();

        return redirect('/posts')->with('succes', 'Post removed!!');

    }
}
