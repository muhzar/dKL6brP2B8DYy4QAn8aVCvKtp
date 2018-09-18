<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use App\Post;

class PageController extends FrontController
{

    public function __construct()
    {
        
    }

    public function index(Request $request, $slug = null)
    {
        
        if ($slug == null) $slug = \Request::segment(1);
        $page = Post::Slug($slug);
        if ($page->exists()) {
            $this->setTitle('halo');
            $this->setPage($page);
        	if ( $page->data_model != null ||  $page->data_model != '') {
        		$model = 'App\\' . ucfirst($page->data_model);
        		$query = [config('app.post_type_id')];
	        	
                if ($page->data_query != null || $page->data_query != '') {
	        		$query = [$page->data_query];
	        	}
	        	
                $posts = new $model;
                $limit = config('app.max_items');
                
                //exception end 
                if (strtolower($page->data_model) == 'post') {
                    $this->setContent($posts::getByCategoryId($query)->paginate($limit));
                } else {
                    $this->setContent($posts::paginate($limit));
                }
		        
	        }
        	if ( $page->template != null ||  $page->template != '') {
        		return view('frontend.customs.' . $page->template, $this->getHTMLData());
        	} else {
        		return view('frontend.page', $this->getHTMLData());
        	}
	        
        } else {
        	return abort(404);
        }
        
    }

    public function single(Request $request, $category, $slug)
    {
        $data['title'] = config('app.name');
        $templatePage = Post::Slug($category);
        $page = Post::Slug($slug);
        if ($page->exists()) {
        	$data['page'] = $page;
            $query = [config('app.post_type_id')];

        	if ( ($templatePage->template != null ||  $templatePage->template != '') && view()->exists('frontend.customs.' . $templatePage->template . '_single')) {
        		$data['template'] = $page;
                return view('frontend.customs.' . $templatePage->template . '_single', $data);
        	} else {
        		return view('frontend.single', $data);
        	}
	        
        } else {
        	return abort(404);
        }
        
    }
    
}
