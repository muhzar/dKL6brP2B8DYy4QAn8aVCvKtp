<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;
use Redirect;
use Auth;
use Validator;
use Hash;
use App\GuardCluster;
use App\Guard;
use App\Cluster;

class GuardClusterController extends Controller
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
            $data['users'] = GuardCluster::paginate(config('app.record_per_page'));
        } 
        else 
        {
            $data['keyword'] = $request->input('keyword');
            $data['users'] = GuardCluster::search($request->input('keyword'))->paginate(config('app.record_per_page'));
        }

        $data['title'] = $this->getTitle();
        
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        
        $data['i'] = $number;
        return view('backend.guardcluster.list', $data);
    }

    public function create()
    {
        $data['title'] = $this->getTitle();
        $data['guards'] =  Guard::get();
        $data['clusters'] =  Cluster::get();
        return view('backend.guardcluster.add', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'cluster_id' => 'required',
            'guard_id' => 'required',
        ]);

        $guardCount = GuardCluster::where('cluster_id', $request->input('cluster_id'))->count();
        if ($guardCount >= 30) {
            return redirect('cms/guardoncluster')->with(['type' => 'error', 'message' => 'To many guards on this cluster']);
        }

        $exist = GuardCluster::where('cluster_id', $request->input('cluster_id'))->where('guard_id', $request->input('guard_id'))->first();
        if ($exist) {
            return redirect('cms/guardoncluster')->with(['type' => 'error', 'message' => 'Guard already assign to that cluster']);
        } else {
            GuardCluster::create([
                'guard_id' => $request->input('guard_id'),
                'cluster_id' => $request->input('cluster_id')

            ]);
            return redirect('cms/guardoncluster')->with(['type' => 'success', 'message' => 'Success assign guard']);
        }
        
    }

    public function show()
    {
        $data['title'] = $this->getTitle();
        return view('backend.guardcluster.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = $this->getTitle();
        $data['post'] = Guard::find($id);
        return view('backend.guardcluster.edit', $data);
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
        return Redirect::to('cms/guardoncluster')->with(['type' => 'success', 'message' => 'success updated Guard']);
    }

    public function destroy($id)
    {
        if(GuardCluster::find($id)){
            $user = GuardCluster::find($id);
            $user->delete();
            return Redirect::to('cms/guardoncluster')->with(['type' => 'success', 'message' => 'success delete guard']);
        } else {
            return Redirect::to('cms/guardoncluster');
        }
    }
    
}
