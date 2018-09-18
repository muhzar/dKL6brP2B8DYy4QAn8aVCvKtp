<?php

namespace App\Http\Controllers\Backend;

use App\Guard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;
use Redirect;
use Auth;
use Validator;
use Hash;

class TrackController extends Controller
{
    protected $redirectTo = '/cms';
    
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {   
        if($request->input('keyword') == '') 
        {
            $data['keyword'] = '';
            $data['users'] = Guard::paginate(config('app.record_per_page'));
        } 
        else 
        {
            $data['keyword'] = $request->input('keyword');
            $data['users'] = Guard::search($request->input('keyword'))->paginate(config('app.record_per_page'));
        }

        $data['title'] = $this->getTitle();
        
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        
        $data['i'] = $number;
        return view('backend.guard.list', $data);
    }

    public function create()
    {
        $data['title'] = $this->getTitle();
        return view('backend.guard.add', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            // 'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'username' => 'required',
            // 'privilege' => 'required',
        ]);

       //$imageName = time() . '.' . $request->image->getClientOriginalExtension();
       //$request->image->move(public_path('backend/uploads/images'), $imageName);

        Guard::create([
            'name' => $request->input('name'),
            'username' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            // 'privilege' => $request->input('privilege'),
            // 'image' => $request->input('image'),
            // 'created_by' => Auth::id()

        ]);
        return redirect('cms/guard')->with(['type' => 'success', 'message' => 'You success added new Guard']);
    }

    public function show()
    {
        $data['title'] = $this->getTitle();
        return view('backend.guard.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = $this->getTitle();
        $data['post'] = Guard::find($id);
        return view('backend.guard.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required',
            'name' => 'required|max:255',
            'password' => 'required'
        ]);

        $updateFields = [
                            'name' => $request->input('name'),
                            'username' => $request->input('username'),
                            'password' => $request->input('password')
                        ];
        $user = Guard::find($id);
        $user->fill($updateFields);
        $user->save();
        return Redirect::to('cms/guard')->with(['type' => 'success', 'message' => 'success updated Guard']);
    }

    public function destroy($id)
    {
        if(Guard::find($id)){
            $user = Guard::find($id);
            $user->delete();
            return Redirect::to('cms/guard')->with(['type' => 'success', 'message' => 'success delete guard']);
        } else {
            return Redirect::to('cms/guard');
        }
    }
    
}
