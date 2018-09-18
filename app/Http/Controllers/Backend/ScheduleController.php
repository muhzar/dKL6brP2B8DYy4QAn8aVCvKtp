<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use Auth;
use App\Shift;
use App\Schedule;
use App\Guard;
use App\Cluster;
use App\Track;

class ScheduleController extends Controller
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
            $data['posts'] = Schedule::paginate(config('app.record_per_page'));

        } 
        else 
        {
            $data['keyword'] = $request->input('keyword');
            $data['posts'] = Schedule::search($request->input('keyword'))->paginate(config('app.record_per_page'));
        }
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        $data['i'] = $number;
        return view('backend.schedule.list', $data);
    }

    public function create()
    {
        $data['title'] = $this->getTitle();
        $data['guards'] = Guard::get();
        $data['clusters'] = Cluster::get();
        $data['shifts'] = Shift::get();
        return view('backend.schedule.add', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'cluster' => 'required'
        ]);

        Schedule::create([
            'guard_username' => $request->input('guard_username'),
            'track_code' => $request->input('track_code'),
            'shift_id' => $request->input('shift_id'),
            'assign_date' => $request->input('date')

        ]);
        return redirect('cms/schedule')->with(['type' => 'success', 'message' => 'Success added Schedule']);
    }

    public function show()
    {
        $data['title'] = $this->getTitle();
        return view('backend.schedule.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = $this->getTitle();
        $data['post'] = Schedule::find($id);
        $data['guards'] = Guard::get();
        $data['clusters'] = Cluster::get();
        $data['shifts'] = Shift::get();
        return view('backend.schedule.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required',
            'cluster' => 'required'
        ]);

        $updateFields = [
            'guard_username' => $request->input('guard_username'),
            'track_code' => $request->input('track_code'),
            'shift_id' => $request->input('shift_id'),
            'assign_date' => $request->input('date')
        ];
        $category = Schedule::find($id);
        $category->fill($updateFields);
        $category->save();
        return Redirect::to('cms/schedule')->with(['type' => 'success', 'message' => 'success updated Schedule']);
    }

    public function destroy($id)
    {
        if(Schedule::find($id)){
            $category = Schedule::find($id);
            $category->delete();
            return Redirect::to('cms/schedule')->with(['type' => 'success', 'message' => 'success delete Schedule']);
        } else {
            return Redirect::to('cms/schedule');
        }
    }

}
