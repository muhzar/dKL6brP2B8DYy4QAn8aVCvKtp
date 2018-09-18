<?php

namespace App\Http\Controllers\Backend;

use App\Track;
use App\Cluster;
use App\TrackCheckpoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;
use Redirect;
use Auth;
use Validator;
use Hash;

class TrackPointController extends Controller
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
            $data['users'] = Track::orderBy('created_at', 'desc')->paginate(config('app.record_per_page'));

        } 
        else 
        {
            $data['keyword'] = $request->input('keyword');
            $data['users'] = Track::search($request->input('keyword'))->paginate(config('app.record_per_page'));
        }

        $data['title'] = $this->getTitle();
        
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        
        $data['i'] = $number;
        return view('backend.track.list', $data);
    }

    public function create()
    {
        $data['title'] = $this->getTitle();
        $data['clusters'] = Cluster::get();
        $data['points'] = [];
        return view('backend.track.add', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'code' => 'required',
            'cluster_code' => 'required',
        ]);

        Track::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'cluster_code' => $request->input('cluster_code')

        ]);



        $orders = $request->input('order');
        $checkpoint_code = $request->input('checkpoint_code');
        $lats = $request->input('lat');
        $longs = $request->input('long');
        $descriptions = $request->input('description');
        $beacons = $request->input('beacon');

        TrackCheckpoint::where('track_code', $request->input('code'))->delete();

        for($i=0; $i<count($orders); $i++) {
            TrackCheckpoint::create([
                'track_code' => $request->input('code'),
                'checkpoint_code' => $checkpoint_code[$i],
                'point_order' => $orders[$i],
                'latitude' => $lats[$i],
                'longitude' => $longs[$i],
                'description' => $descriptions[$i],
                'beacon_id' => $beacons[$i]
            ]);
        };

        return redirect('cms/track')->with(['type' => 'success', 'message' => 'You success added new track']);
    }

    public function show()
    {
        $data['title'] = $this->getTitle();
        return view('backend.track.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $track = Track::find($id);
        $data['title'] = $this->getTitle();
        $data['clusters'] = Cluster::get();
        $data['post'] = $track;
        $data['points'] = TrackCheckpoint::where('track_code', $track->code)->get();
        return view('backend.track.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'code' => 'required',
            'cluster_code' => 'required',
        ]);

        $updateFields = [
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'cluster_code' => $request->input('cluster_code')
        ];
        $user = Track::find($id);
        $user->fill($updateFields);
        $user->save();

        $orders = $request->input('order');
        $checkpoint_code = $request->input('checkpoint_code');
        $lats = $request->input('lat');
        $longs = $request->input('long');
        $descriptions = $request->input('description');
        $beacons = $request->input('beacon');

        TrackCheckpoint::where('track_code', $request->input('code'))->delete();

        for($i=0; $i<count($orders); $i++) {
            TrackCheckpoint::create([
                'track_code' => $request->input('code'),
                'checkpoint_code' => $checkpoint_code[$i],
                'point_order' => $orders[$i],
                'latitude' => $lats[$i],
                'longitude' => $longs[$i],
                'description' => $descriptions[$i],
                'beacon_id' => $beacons[$i]
            ]);
        };


        return Redirect::to('cms/track')->with(['type' => 'success', 'message' => 'success updated track']);
    }

    public function destroy($id)
    {
        if(Track::find($id)){
            $user = Track::find($id);
            $user->delete();
            return Redirect::to('cms/track')->with(['type' => 'success', 'message' => 'success delete track']);
        } else {
            return Redirect::to('cms/track');
        }
    }


    public function saveByMap(Request $request) {
        $i = 0;
        $data = json_decode($request->input('content'));
        TrackCheckpoint::where('track_code', $data->track_code)->delete();
        foreach($data->checkpoint as $checkpoint ) {
            $i++;
            TrackCheckpoint::create([
                'track_code' => $data->track_code,
                'checkpoint_code' => $data->track_code . $i,
                'point_order' => $i,
                'latitude' => $checkpoint->lat,
                'longitude' => $checkpoint->lng,
                'description' => $checkpoint->caption,
                'beacon_id' => ''
            ]);
        };

        return response()->json(['status' => 'OK']);


    }
    
}
