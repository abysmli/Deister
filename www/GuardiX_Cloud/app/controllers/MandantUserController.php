<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : MandantUserController.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     MandantUserController Class is used to handle mandant login action. Use
 | Auth::attempt() method to check mandant credentials. When login successed, 
 | this mandnat user will log into the application.
 |
 |============================================================================
 */

class MandantUserController extends Controller
{
	// handle login action
	public function loginAction()
	{
		// create a credentials array to store username and password from POST requests
		$credentials['username'] = $_POST['username'];
		$credentials['password'] = $_POST['password'];
		// use Auth::attempt method to log a user into application
		Auth::attempt($credentials);
		// to determine if the user is already logged into application
		if (Auth::check()) {
			// set user id into session variable
			Session::put('userid',Auth::user()->user_id);
			// set mandant id into session variable
			Session::put('mandantid',Auth::user()->mandant_id);
			// get all mandant informations from database
			$mandant_info = new StdClass();
			$mandant_info->user_id=Auth::user()->user_id;
			$mandant_info->mandant_id=Auth::user()->mandant_id;
			$mandant_info->username=Auth::user()->username;
			$mandant_info->mandant_firmname=Auth::user()->mandant_firmname;
			$mandant_info->mandant_address=Auth::user()->mandant_address;
			$mandant_info->mandant_contact=Auth::user()->mandant_contact;
			$mandant_info->date_insert=Auth::user()->date_insert;
			// write mandant action log
			DB::table('mandant_log')->insert(array(
				'mandant_id'=>$mandant_info->mandant_id,
				'user_id'=>$mandant_info->user_id,
				'action'=>'Login', 
				'ip'=>$_SERVER['REMOTE_ADDR']
			));
			// return mandant informatons in form of json
			$response = Response::json(array('status'=>'200 OK','result'=>'Success','message'=>'User Login Successed!'));
			$response->header('Status','200 OK');
			return $response;
		} else {
			// if the user logged failed, return "401 Unauthorized"
			$response = Response::json(array('status'=>'401 Unauthorized','result'=>'Error', 'message'=>'Username or Password Error!'));
			$response->header('Status','401 Unauthorized');
			return $response;
		}
	}

	// handle logout action
	public function logoutAction()
	{
		// write mandant action log
		DB::table('mandant_log')->insert(array(
			'mandant_id'=>Session::get('mandantid'),
			'user_id'=>Session::get('userid'),
			'action'=>'Logout', 
			'ip'=>$_SERVER['REMOTE_ADDR']
		));
		// release session variable
		Session::forget('userid');
		Session::forget('mandantid');
		// log the user out of the application
		Auth::logout();

		// return a string "Logout" to foreend
		$response = Response::json(array('status'=>'200 OK','result'=>'Success','message'=>'Logout'));
		$response->header('Status','200 OK');
		return $response;
	}
}