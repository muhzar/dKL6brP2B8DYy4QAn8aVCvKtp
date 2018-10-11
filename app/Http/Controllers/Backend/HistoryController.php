<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use Auth;
use App\Shift;
use App\History;
use App\Cluster;
use App\TrackCoordinate;
use App\TrackCheckpoint;
use App\TempRoute;
use App\Track;

class HistoryController extends Controller
{
    protected $redirectTo = '/cms';
    
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {   
        $data['title'] = $this->getTitle();
        $data['keyword'] = '';
        $data['posts'] = History::paginate(config('app.record_per_page'));
        $data['i'] = 1;
        return view('backend.history.list', $data);
    }


    public function map(Request $req) 
    {

        $tracksCoo = [];
        $trackPoints = [];
        $cluster = Cluster::where('id', $req->input('cluster_id'))->first();
        $data['title'] = 'Dashboard Alam Sutera | ' . $cluster->name;
        $data['clusterName'] = $cluster->name;
        $tracks = Track::where('cluster_id', $cluster->id)->get();
        $points = TempRoute::where('cluster_id', $cluster->id)
                        ->where('guard_id', $req->input('guard_id'))
                        ->where('shift_id', $req->input('shift'))
                        ->whereDate('created_at', $req->input('date'))
                        ->get();
            
        foreach ($tracks as $track) {
            $tracksCoo = TrackCoordinate::where('track_id', $track->code)->orderBy('point_order', 'asc')->get();
            $trackPoints[] = TrackCheckpoint::where('track_id', $track->code)->orderBy('point_order', 'asc')->get();
        }

        // $data['clusters'] = $cluster;
        $data['cluster'] =  $cluster;
        $data['points'] =  $points;
        $data['coors'] =  $tracksCoo;
        $data['track_points'] = $trackPoints;
        return view('frontend.history', $data);
    
    }


}
