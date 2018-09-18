<?php

function getCurrentMethod() 
{
	$currentAction = \Route::currentRouteAction();
	list($controller, $method) = explode('@', $currentAction);
	return ucfirst($method);
}

function getBodyClass() {
	$classReturn = '';
	$firstSegment = \Request::segment(1);
	switch ($firstSegment) {
	 	case 'value':
	 		# code...
	 		break;
	 	
	 	case '':
	 		$classReturn = 'indexPage';
	 		break;
 	}
	return $classReturn;
}

function getCurrentController() 
{
	$currentAction = \Route::currentRouteAction();
	list($controller, $method) = explode('@', $currentAction);
	$controller = preg_replace('/.*\\\/', '', $controller);
	return ucfirst(substr($controller, 0, -10));
}
function getChildId($parentId, &$arr = array())
{
	$categories = App\Category::where('parent_id', $parentId)->get();
	if ($categories->count() > 0)
	{
		foreach ($categories as $category) 
		{
			getChildId($category->id, $arr);
		}
	}
	else
	{
		$arr[] = $parentId;
	}
	
}

function status($status) 
{
	switch ($status) {
		case 0:
			$return = 'Unpublish';
			break;
		case 1:
			$return = 'Publish';
			break;
		default:
			# code...
			break;
	}
	return $return;
}

function getUsername($id) 
{
	$user = App\User::find($id);
	if ($user)
	{
		return $user->name;
	}
	else
	{
		return 'N/A';
	}
	
}

function getCategoryIdBySlug($slug) 
{
	$category = App\Category::where('slug', $slug)->first();
	if ($category)
	{
		return $category->id;
	}
	else
	{
		return 0;
	}
	
}

function formatedDate($date, $format = NULL)
{
	if($format == NULL)
	{
		return date('d M Y H:i:s', strtotime($date));
	}
	else
	{
		return date($format, strtotime($date));

	}
}

function formatedDateFrontend($date, $format = NULL)
{
	if ($date == '0000-00-00 00:00:00') {
		$date = date('Y-m-d');
		$convert = config('app.month_en_id');
		return date('d', strtotime($date)) . ' ' . $convert[date('M', strtotime($date))] . ' ' . date('Y', strtotime($date));
	}
	if($format == NULL )
	{
		$convert = config('app.month_en_id');
		return date('d', strtotime($date)) . ' ' . $convert[date('M', strtotime($date))] . ' ' . date('Y', strtotime($date));
	}
	else
	{
		return date($format, strtotime($date));

	}
}

function getCustomField($post_id, $key) 
{
	$customField = App\CustomField::where('post_id', $post_id)->where('name', $key)->first();
	if ($customField == false) return '';
	return $customField->value;
}
