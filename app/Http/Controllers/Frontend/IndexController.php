<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use App\Track;
use App\Cluster;
use App\TempRoute;
use App\TrackCoordinate;
use App\TrackCheckpoint;

class IndexController extends FrontController
{

    public function __construct()
    {
        
    }

    public function index()
    {
    	$this->setTitle('Dashboard Alam Sutera');
        $cluster = Cluster::orderBy('name','asc')->get();

        $this->setVar('clusters', $cluster);
        $this->setVar('clusterName', 'All Cluster');
        return view('frontend.home', $this->getHTMLData());
    }

    public function cluster($clusterId = null)
    {
        if ($clusterId == null) {
            $this->setTitle('Dashboard Alam Sutera');
            $this->setVar('clusters', Cluster::orderBy('name', 'asc')->get());
            return view('frontend.guard-all', $this->getHTMLData());
        }
        $tracksCoo = [];
        $trackPoints = [];
        $cluster = Cluster::where('id', $clusterId)->first();
        $this->setTitle('Dashboard Alam Sutera | ' . $cluster->name);
        $this->setVar('clusterName', $cluster->name);
        $clusters = Cluster::get();
        $tracks = Track::where('cluster_id', $cluster->id)->get();
        $points = TempRoute::where('cluster_id', $cluster->id)->where('created_at', '>=', date('Y-m-d'))->get();

        foreach ($tracks as $track) {
            $tracksCoo = TrackCoordinate::where('track_id', $track->id)->orderBy('point_order', 'asc')->get();
            $trackPoints[] = TrackCheckpoint::where('track_id', $track->id)->orderBy('point_order', 'asc')->get();

            // dd($track->code);
        }

        // dd($tracks);
        // $track = TrackCoordinate::where('track_code', $track->code)->get();
        // $trackPoints = TrackCheckpoint::where('track_code', 1)->get();
        $this->setVar('clusters', $clusters);
        $this->setVar('cluster', $cluster);
        $this->setVar('points', $points);
        $this->setVar('coors', $tracksCoo);
        $this->setVar('track_points', $trackPoints);
        // dd($this);
        return view('frontend.cluster', $this->getHTMLData());
    }

    public function route()
    {
    	$this->setTitle('Dashboard Alam Sutera');
        $cluster = Cluster::orderBy('name','asc')->get();
        $this->setVar('clusters', $cluster);
        return view('frontend.route', $this->getHTMLData());
    }

    public function track()
    {
        $this->setTitle('Dashboard Alam Sutera');
        $track = TrackCoordinate::where('track_code', 1)->get();
        $trackPoints = TrackCheckpoint::where('track_code', 1)->get();
        $cluster = Cluster::get();
        $this->setVar('clusters', $cluster);
        $this->setVar('coordinates', $track);
        $this->setVar('track_points', $trackPoints);
        // $this->debug();
        return view('frontend.track', $this->getHTMLData());
    }

    public function saveTrack(Request $req) {
        // dd($req->all());
        $track = Track::where('code', $req->input('track_code'))->first();
        if (!$track) {
            Track::create(
                [
                    'code' => $req->input('track_code'), 
                    'cluster_code' => $req->input('cluster_code')
                ]
            );
        }
        
        $i = 0;
        TrackCoordinate::where('track_code', $req->input('track_code'))->delete();
        foreach ($req->input('data') as $val) {
            $i++;
            $result = TrackCoordinate::create(['point_order' => $i, 'checkpoint_code' => 'Point' + $i,'track_code' => $req->input('track_code'), 'latitude' => $val[0], 'longitude' => $val[1]]);
        }
        return response()->json(['response' => 'success']);
    }


    public function getCoordinate(Request $req) {
        $clusterCode = $req->input('cluster-code');
        $cluster = Cluster::where('code', $clusterCode)->first();
        $track = Track::where('cluster_code', $clusterCode)->get();

        return response()->json([
            'geo' => [
                'lat' => (float)$cluster->latitude, 
                'lng' => (float)$cluster->longitude
            ],
            'track' => $track
        ]);
    }
    
}
