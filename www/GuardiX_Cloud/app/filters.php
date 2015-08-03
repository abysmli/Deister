<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

// create by Li, Yuan at main version 3.0
// use administration table for administration authentication
// defined a filter, which will be used for administration authentication 
Route::filter('webauth', function()
{
	// check whether user logined 
	if (!Session::has('WebAuth')) {
		return Redirect::to('/login');
	}
	$userid=Session::get('WebAuth.userid');
	$username=Session::get('WebAuth.username');
	$usergroup=Session::get('WebAuth.usergroup');
	$user = array(
		'userid'=>reset($userid),
		'username'=>reset($username),
		'group'=>reset($usergroup)
	);
	View::share('user',$user);
});

// create by Li, Yuan at main version 4.0
// check whether the user belong to admins group
Route::filter('admingroup', function()
{
	$usergroup = Session::get('WebAuth.usergroup');
	// check whether the user belong to admins group
	if (reset($usergroup)!=='admins') {
		return Response::make("Permission denied");
	}
});

// modified by Li, Yuan at main version 3.0
// authentication for mandants
// defined a filter, which will be used for mandants authentication 
Route::filter('auth', function()
{
	// check whether mandant logined 
	if (Auth::guest()) {
		$response = Response::json(array('status'=>'401 Unauthorized','result'=>'Error', 'message'=>'Not Login!'));
		$response->header('Status','401 Unauthorized');
		return $response;	
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic("username");
});


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});