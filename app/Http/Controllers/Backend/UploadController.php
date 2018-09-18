<?php

namespace App\Http\Controllers\Backend;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use Response;

class UploadController extends Controller
{
    
    
    public function __construct()
    {
    }

    public function index(Request $request)
    {  
        
            $imageName = time().mt_rand() . "." . $request->images[0]->getClientOriginalExtension();
            $request->images[0]->move(public_path(config('app.folder_upload_images')), $imageName);
           
            $arrImage[] = array(
                'url' => $imageName,
                'thumbnail_url' => $imageName,
                'name' => $request->images[0]->getClientOriginalName(),
                'type' => $request->images[0]->getClientMimeType(),
                'size' => $request->images[0]->getClientSize(),
                'delete_url' => "http://url.to/delete /file/",
                'delete_type' => "DELETE"
            );
        
        return  Response::json(array('files' => $arrImage));

    }
}
