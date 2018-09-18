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

class GuardController extends Controller
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
            'username' => 'required',
            'password' => 'required'
        ]);

        Guard::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'username' => $request->input('username')

        ]);
        return redirect('cms/guard')->with(['type' => 'success', 'message' => 'You success added new guard']);
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
            'name' => 'required|max:255'
        ]);

        $updateFields = [
                            'name' => $request->input('name'),
                            'password' => Hash::make($request->input('name')),
                            'username' => $request->input('username')
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
