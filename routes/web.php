<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Frontend\IndexController@blank');
Route::get('route', 'Frontend\IndexController@route');
Route::get('track', 'Frontend\IndexController@track');
Route::post('track/save', 'Frontend\IndexController@saveTrack');
Route::get('cluster', 'Frontend\IndexController@cluster');
Route::get('cluster/all', 'Frontend\IndexController@cluster');
Route::get('cluster/{cluster}', 'Frontend\IndexController@cluster');



Route::get('geo', 'Frontend\IndexController@getCoordinate');





Route::get('pencarian', 'Frontend\SearchController@index');


Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/dashboard', 'Frontend\IndexController@index');
    Route::get('cms', 'Backend\IndexController@index');
	Route::get('cms/dashboard', 'Backend\IndexController@dashboard');
	Route::get('cms/index', 'Backend\IndexController@index');
	Route::post('uploader', 'Backend\UploaderController@action');
	Route::post('cms/uploads/images', 'Backend\UploadController@index');
	Route::put('cms/uploads/images', 'Backend\UploadController@index');
	Route::get('cms/user/password/change', 'Backend\UserController@indexChangePassword');
	Route::post('cms/user/password/change', 'Backend\UserController@actionChangePassword');
	Route::resource('cms/news', 'Backend\NewsController');
    Route::resource('cms/report', 'Backend\ReportController');
    Route::get('cms/log', 'Backend\LogController@index');
	Route::get('cms/history', 'Backend\HistoryController@index');
    Route::get('cms/history/map', 'Backend\HistoryController@map');
    Route::resource('cms/guardoncluster', 'Backend\GuardClusterController');
    Route::post('clusters/checkpoint/save', 'Backend\TrackPointController@saveByMap');



	Route::group(['middleware' => 'acl'], function () {
		//just for administrator

        Route::get('cms/cluster/setcheckpoint', 'Backend\TrackCoordinateController@setByMap');

	    Route::resource('cms/user', 'Backend\UserController');
		Route::resource('cms/category', 'Backend\CategoryController');
		Route::resource('cms/page', 'Backend\PageController');
		Route::resource('cms/faq', 'Backend\FaqController');
		Route::resource('cms/contact', 'Backend\ContactController');
		Route::resource('cms/banner', 'Backend\BannerController');
        Route::resource('cms/gallery', 'Backend\GalleryController');
        Route::resource('cms/guard', 'Backend\GuardController');
        Route::resource('cms/track', 'Backend\TrackPointController');
        Route::resource('cms/track/checkpoint', 'Backend\TrackCheckController');
        Route::resource('cms/track/coordinate', 'Backend\TrackCoordinateController');
        Route::resource('cms/cluster', 'Backend\ClusterController');
        Route::resource('cms/route', 'Backend\RouteController');
        Route::resource('cms/schedule', 'Backend\ScheduleController');
        Route::resource('cms/shift', 'Backend\ShiftController');
		Route::resource('cms/livestreaming', 'Backend\LiveController');


	});
	
});

Route::get('{slug}', 'Frontend\PageController@index');