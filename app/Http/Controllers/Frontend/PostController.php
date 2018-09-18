<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{

    public function __construct()
    {
        
    }

    public function index(Request $request, $slug)
    {
        $data['title'] = 'Mega Finance';
        $data['post'] = Post::Slug($slug);
        $id = getCategoryIdBySlug($slug);

        if ($id == 0) { 
        	return abort(404);
        }

        $data['news'] = Post::GetByCategoryId([$id])->where('status', 1)->orderBy('created_at', 'desc')->paginate(config('app.paging_limit'));
        return view('frontend.news.index.' . $slug, $data);
    }
    
    public function detail(Request $request, $categorySlug, $slug)
    {
    	$data['title'] = 'Mega Finance';
        $data['post'] = Post::Slug($categorySlug);
        $id = getCategoryIdBySlug($categorySlug);
        $content = Post::where('slug', $slug)->first();
        $data['othersNews'] = Post::GetByCategoryId([$id])->where('status', 1)->orderBy('created_at', 'desc')->limit(config('app.others_news_limit'))->get();

        if (!$content) { 
            return abort(404);
        }

        $data['news'] = $content;
        return view('frontend.news.detail.' . $categorySlug, $data);
    }
}
