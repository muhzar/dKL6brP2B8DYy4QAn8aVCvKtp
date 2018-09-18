<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use Auth;
use App\Shift;

class ShiftController extends Controller
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
            $data['posts'] = Shift::paginate(config('app.record_per_page'));

        } 
        else 
        {
            $data['keyword'] = $request->input('keyword');
            $data['posts'] = Shift::search($request->input('keyword'))->paginate(config('app.record_per_page'));
        }
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        $data['i'] = $number;
        return view('backend.shift.list', $data);
    }

    public function create()
    {
        $data['title'] = $this->getTitle();
        return view('backend.shift.add', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:200',
            'start_at' => 'required|date_format:H:i',
            'end_at' => 'required|date_format:H:i',
            // 'end_at' => 'required|date_format:H:i|after:end_at',
        ]);

        Shift::create([
            'name' => $request->input('name'),
            'start_at' => $request->input('start_at'),
            'end_at' => $request->input('end_at'),
            'description' => $request->input('description')

        ]);
        return redirect('cms/shift')->with(['type' => 'success', 'message' => 'Success added Shif']);
    }

    public function show()
    {
        $data['title'] = $this->getTitle();
        return view('backend.shift.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = $this->getTitle();
        $data['post'] = Shift::find($id);
        return view('backend.shift.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:200',
            'start_at' => 'required|date_format:H:i',
            'end_at' => 'required|date_format:H:i',
            // 'end_at' => 'required|date_format:H:i|after:end_at',
        ]);

        $updateFields = [
                            'name' => $request->input('name'),
                            'start_at' => $request->input('start_at'),
                            'end_at' => $request->input('end_at'),
                            'description' => $request->input('description'),

                        ];
        $shif = Shift::find($id);
        $shif->fill($updateFields);
        $shif->save();
        return Redirect::to('cms/shift')->with(['type' => 'success', 'message' => 'success updated shif']);
    }

    public function destroy($id)
    {
        if(Shift::find($id)){
            $shif = Shift::find($id);
            $shif->delete();
            return Redirect::to('cms/shift')->with(['type' => 'success', 'message' => 'success delete shif']);
        } else {
            return Redirect::to('cms/shift');
        }
    }

}
