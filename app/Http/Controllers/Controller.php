<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function getTitle() {
    	return getCurrentController() . ' > ' . getCurrentMethod();
    }

    public function getView() {
    	return strtolower(getCurrentController());
    }

    public function setTitle($caption) {
    	return $caption . ' - ' . config('app.site_name');
    }
}
