<?php

namespace App\Http\Controllers\Backend;

use Auth;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;


class UploaderController extends Controller
{
    public function __construct()
    {
        
    }

    public function action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);
        if(!$validator->fails())
        {
            $imageName = time().'.'.$request->upload->getClientOriginalExtension();
            $request->upload->move(public_path('backend/uploads/images'), $imageName);
            // return response()->json(['uploaded' => 1, 'fileName' => $imageName, 'url' => asset('backend/uploads/images') . $imageName]);
            echo '<script type="text/javascript">
    window.parent.CKEDITOR.tools.callFunction(' . $request->input('CKEditorFuncNum') . ', "' . asset('backend/uploads/images/'. $imageName ) . '", "");
</script>';
        } 
        else
        {
            return response()->json(['uploaded' => 0, 'error' => 'failed uploaded file']);
        }
        
    }


}
