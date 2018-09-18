<?php

namespace App\Http\Controllers\Backend;

use App\Cluster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;
use Redirect;
use Auth;
use Validator;
use Hash;

class ClusterController extends Controller
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
            $data['users'] = Cluster::orderBy('created_at', 'desc')->paginate(config('app.record_per_page'));
        } 
        else 
        {
            $data['keyword'] = $request->input('keyword');
            $data['users'] = Cluster::search($request->input('keyword'))->paginate(config('app.record_per_page'));
        }

        $data['title'] = $this->getTitle();
        
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        
        $data['i'] = $number;
        return view('backend.cluster.list', $data);
    }

    public function create()
    {
        $data['title'] = $this->getTitle();
        return view('backend.cluster.add', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'code' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        Cluster::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'description' => $request->input('description')
        ]);
        return redirect('cms/cluster')->with(['type' => 'success', 'message' => 'You success added new Cluster']);
    }

    public function show()
    {
        $data['title'] = $this->getTitle();
        return view('backend.cluster.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = $this->getTitle();
        $data['post'] = Cluster::find($id);
        return view('backend.cluster.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required|max:50',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $updateFields = [
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'description' => $request->input('description')
        ];
        $user = Cluster::find($id);
        $user->fill($updateFields);
        $user->save();
        return Redirect::to('cms/cluster')->with(['type' => 'success', 'message' => 'success updated Cluster']);
    }

    public function destroy($id)
    {
        if(Cluster::find($id)){
            $user = Cluster::find($id);
            $user->delete();
            return Redirect::to('cms/cluster')->with(['type' => 'success', 'message' => 'success delete Cluster']);
        } else {
            return Redirect::to('cms/cluster');
        }
    }

    
}
