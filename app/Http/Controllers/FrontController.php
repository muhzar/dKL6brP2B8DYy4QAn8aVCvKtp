<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FrontController extends Controller
{
    private $data = [];

    public function setTitle($value)
    {
        $this->data['title'] = $value;
    }

    public function setVar($var, $value) 
    {
        $this->data[$var] = $value;
    }
    public function setCss($value)
    {
        $this->data['css'] = $value;
    }
    
    public function setJs($value)
    {
        $this->data['js'] = $value;
    }

    public function setMeta($value)
    {
        $this->data['meta'] = $value;
    }
    
    public function setContent($value)
    {
        $this->data['posts'] = $value;
    }

    public function setPage($value)
    {
        $this->data['page'] = $value;
    }

    public function getHTMLData()
    {
        return $this->data;
    }

    public function debug()
    {
        dd($this->data);
    }
}
