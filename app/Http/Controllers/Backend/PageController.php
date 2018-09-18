<?php

namespace App\Http\Controllers\Backend;

use Auth;
use App\Post;
use App\Category;
use App\PostCategory;
use App\CustomField;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class PageController extends Controller
{
    protected $redirectTo = '/cms';
    private $postType;
    private $postCategory;

    
    public function __construct()
    {
        $this->postType = config('app.page_type_id');
        $this->postCategory = config('app.page_category_id');
        $this->modelCategory = config('app.post_category_id');
    }

    public function index(Request $request)
    {   
        $data['title'] = $this->getTitle();

        if($request->input('keyword') == '') 
        {
            $data['keyword'] = '';
            $data['posts'] = Post::getByType($this->postType)->orderBy('created_at','desc')->paginate(config('app.record_per_page'));
        
        } 
        else 
        {
            $data['keyword'] = $request->input('keyword');
            $data['posts'] = Post::search($request->input('keyword'), $this->postType)->orderBy('created_at','desc')->paginate(config('app.record_per_page'));
        }

        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        $data['i'] = $number;
        return view('backend.page.list', $data);
    }

    public function create()
    {
        $data['title'] = $this->getTitle();
        $data['posts'] = Post::get();
        $data['categories'] = Category::where('parent_id', $this->postCategory)->get();

        // getChildId($this->modelCategory, $childId);
        // $data['data_queries'] = Post::getByCategoryId($childId);
        return view('backend.page.add', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:200',
            'slug' => 'required|unique:posts',
            'summary' => 'required|max:1000',
            'content' => 'required',
            'status' => 'required',
            'category_id' => 'required|numeric',
            'image' => 'required',
        ]);

        

        $insertId = Post::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'summary' => $request->input('summary'),
            'content' => $request->input('content'),
            'status' => $request->input('status'),
            'template' => $request->input('template'),
            'image' => $request->input('image'),
            'data_query' => $request->input('data_query'),
            'data_model' => $request->input('data_model'),
            'type' => $this->postType,
            'created_by' => Auth::id()
        ]);

        PostCategory::create([
            'post_id' => $insertId->id,
            'category_id' => $request->input('category_id')
            ]);

        $names = $request->input('custom-field-name');
        $values = $request->input('custom-field-value');
        if ($names != null) {
            foreach ($names as $key => $name) {
                CustomField::create([
                'post_id' => $insertId->id,
                'name' => $name,
                'value' => $values[$key]
                ]);
            };
        }
        

        return redirect('cms/page')->with(['type' => 'success', 'message' => 'Success added Page']);
    }

    public function show()
    {
        $data['title'] = $this->getTitle();
        return view('backend.page.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = $this->getTitle();
        $data['post'] = Post::find($id);
        $data['categories'] = Category::where('parent_id', $this->postCategory)->get();
        $data['customFields'] = CustomField::where('post_id', $id)->get();

        return view('backend.page.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:200',
            'slug' => 'required',
            'summary' => 'required|max:1000',
            'category_id' => 'required|numeric',
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
                            'template' => $request->input('template'),
                            'data_query' => $request->input('data_query'),
                            'data_model' => $request->input('data_model'),

                        ];
                        
        $post = Post::find($id);
        $post->fill($updateFields);
        $post->save();

        $customFields = CustomField::where('post_id', $id);
        $customFields->delete();

        $names = $request->input('custom-field-name');
        $values = $request->input('custom-field-value');

        if ($names != null) {
            foreach ($names as $key => $name) {
                CustomField::create([
                'post_id' => $id,
                'name' => $name,
                'value' => $values[$key]
                ]);
            };
        }

        $postCategory = PostCategory::updateOrCreate(['post_id' => $id], ['category_id' => $request->input('category_id')]);

        return Redirect::to('cms/page')->with(['type' => 'success', 'message' => 'success updated Page']);
    }

    public function destroy($id)
    {
        if(Post::find($id)){
            $post = Post::find($id);
            $post->delete();
            return Redirect::to('cms/page')->with(['type' => 'success', 'message' => 'success delete Page']);
        } else {
            return Redirect::to('cms/page');
        }
    }

}
