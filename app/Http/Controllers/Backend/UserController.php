<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;
use Redirect;
use Auth;
use Validator;
use Hash;

class UserController extends Controller
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
            $data['users'] = User::paginate(config('app.record_per_page'));
        } 
        else 
        {
            $data['keyword'] = $request->input('keyword');
            $data['users'] = User::search($request->input('keyword'))->paginate(config('app.record_per_page'));
        }

        $data['title'] = $this->getTitle();
        
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        
        $data['i'] = $number;
        return view('backend.user.list', $data);
    }

    public function create()
    {
        $data['title'] = $this->getTitle();
        return view('backend.user.add', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'image' => 'required',
            'privilege' => 'required',
        ]);

       //$imageName = time() . '.' . $request->image->getClientOriginalExtension();
       //$request->image->move(public_path('backend/uploads/images'), $imageName);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'privilege' => $request->input('privilege'),
            'image' => $request->input('image'),
            'created_by' => Auth::id()

        ]);
        return redirect('cms/user')->with(['type' => 'success', 'message' => 'You success added new user']);
    }

    public function show()
    {
        $data['title'] = $this->getTitle();
        return view('backend.user.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = $this->getTitle();
        $data['post'] = User::find($id);
        return view('backend.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'privilege' => 'required',
            'name' => 'required|max:255',
            'image' => 'required'
        ]);

        $updateFields = [
                            'name' => $request->input('name'),
                            'privilege' => $request->input('privilege'),
                            'image' => $request->input('image')
                        ];
        $user = User::find($id);
        $user->fill($updateFields);
        $user->save();
        return Redirect::to('cms/user')->with(['type' => 'success', 'message' => 'success updated user']);
    }

    public function destroy($id)
    {
        if ($id == 1) {
            return Redirect::to('cms/user')->with(['type' => 'danger', 'message' => 'You can not delete this user']);
        }
        if(User::find($id)){
            $user = User::find($id);
            $user->delete();
            return Redirect::to('cms/user')->with(['type' => 'success', 'message' => 'success delete user']);
        } else {
            return Redirect::to('cms/user');
        }
    }

    public function indexChangePassword() 
    {
        $data['title'] = "User Change Password";
        return view('backend.user.change-password', $data);
    }

    public function actionChangePassword(Request $request) 
    {
        Validator::extend('passcheck', function ($attribute, $value, $parameters) 
        {
            return Hash::check($value, Auth::user()->getAuthPassword());
        }, 'Wrong Current Password');

        $this->validate($request, [
            'current-password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'current-password' => 'passcheck' 
        ]);

        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->save();
        return Redirect::to('cms/user')->with(['type' => 'success', 'message' => 'success change user password']);
    }
    
}
