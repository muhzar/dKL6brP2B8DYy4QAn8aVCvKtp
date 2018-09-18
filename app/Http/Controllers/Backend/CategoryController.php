<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use Auth;

class CategoryController extends Controller
{
    protected $redirectTo = '/cms';
    
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {   
        $data['title'] = $this->getTitle();
        if($request->input('keyword') == '') 
        {
            $data['keyword'] = '';
            $data['categories'] = Category::paginate(config('app.record_per_page'));
        } 
        else 
        {
            $data['keyword'] = $request->input('keyword');
            $data['categories'] = Category::search($request->input('keyword'))->paginate(config('app.record_per_page'));
        }
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        $data['i'] = $number;
        return view('backend.category.list', $data);
    }

    public function create()
    {
        $data['title'] = $this->getTitle();
        $data['categories'] = Category::get();
        return view('backend.category.add', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:200',
            'slug' => 'required|max:200',
            'parent_id' => 'required',
            'image' => 'required'
        ]);

        Category::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'parent_id' => $request->input('parent_id'),
            'image' => $request->input('image'),
            'created_by' => Auth::id()

        ]);
        return redirect('cms/category')->with(['type' => 'success', 'message' => 'Success added Category']);
    }

    public function show()
    {
        $data['title'] = $this->getTitle();
        return view('backend.category.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = $this->getTitle();
        $data['post'] = Category::find($id);
        $data['categories'] = Category::get();
        return view('backend.category.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:200',
            'slug' => 'required|max:200',
            'parent_id' => 'required'
        ]);

        $updateFields = [
                            'title' => $request->input('title'),
                            'slug' => $request->input('slug'),
                            'image' => $request->input('image'),
                            'parent_id' => $request->input('parent_id'),

                        ];
        $category = Category::find($id);
        $category->fill($updateFields);
        $category->save();
        return Redirect::to('cms/category')->with(['type' => 'success', 'message' => 'success updated category']);
    }

    public function destroy($id)
    {
        if(Category::find($id)){
            $category = Category::find($id);
            $category->delete();
            return Redirect::to('cms/category')->with(['type' => 'success', 'message' => 'success delete category']);
        } else {
            return Redirect::to('cms/category');
        }
    }

}
