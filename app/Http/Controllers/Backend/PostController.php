<?php

namespace App\Http\Controllers\Backend;

use Auth;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class PostController extends Controller
{
    protected $redirectTo = '/cms';
    
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {   
        $data['title'] = $this->getTitle();
        $data['posts'] = Post::paginate(config('app.record_per_page'));
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        $data['i'] = $number;
        return view('backend.post.list', $data);
    }

    public function create()
    {
        $data['title'] = $this->getTitle();
        $data['posts'] = Post::get();
        $data['categories'] = Category::get();
        return view('backend.post.add', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:200',
            'slug' => 'required',
            'summary' => 'required',
            'content' => 'required',
            'status' => 'required',
            'image' => 'required',
        ]);

        

        Post::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'summary' => $request->input('summary'),
            'content' => $request->input('content'),
            'status' => $request->input('status'),
            'image' => $request->input('image'),
            'created_by' => Auth::id()
        ]);
        return redirect('cms/post')->with(['type' => 'success', 'message' => 'Success added Post']);
    }

    public function show()
    {
        $data['title'] = $this->getTitle();
        return view('backend.post.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = $this->getTitle();
        $data['post'] = Post::find($id);
        $data['categories'] = Category::get();
        return view('backend.post.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:200',
            'slug' => 'required',
            'summary' => 'required',
            'content' => 'required',
            'status' => 'required',
        ]);

        $updateFields = [
                            'title' => $request->input('title'),
                            'slug' => $request->input('slug'),
                            'summary' => $request->input('summary'),
                            'content' => $request->input('content'),
                            'status' => $request->input('status'),
                            'image' => $request->input('image'),
                        ];
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path(config('app.folder_upload_images')), $imageName);
            $updateFields = array_merge($updateFields, ['image' => $imageName]);
        } 
  

        $post = Post::find($id);
        $post->fill($updateFields);
        $post->save();
        return Redirect::to('cms/post')->with(['type' => 'success', 'message' => 'success updated post']);
    }

    public function destroy($id)
    {
        if(Post::find($id)){
            $post = Post::find($id);
            $post->delete();
            return Redirect::to('cms/post')->with(['type' => 'success', 'message' => 'success delete post']);
        } else {
            return Redirect::to('cms/post');
        }
    }

}
