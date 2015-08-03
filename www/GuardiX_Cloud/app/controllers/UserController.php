<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : UserController.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     UserController Class is used to handle administration login action. Use
 | PHP PAM module to check user credentials. When login successed, this user 
 | will log into the application.
 |
 |============================================================================
 */

 class UserController extends Controller
 {
	// handle login action
 	public function loginAction()
 	{
		// release session variable "WebAuth"
 		Session::forget('WebAuth');
		// can only login by using ajax request
 		if (Request::ajax()) {
			// certificate variable for storing username and password from post request
 			$certificate = array (
 				'username'=>$_POST['username'],
 				'password'=>$_POST['password']
 				);
			// get all user informations from database
 			$user = DB::table('administration')->where('active','1')->get();
			// search user table in order to find the posted username 
 			foreach ($user as $_user) {
				// username fond in user table
 				if($_user->username==$certificate['username']) {
					// check whether the username and password are legal
 					if (Hash::check($certificate['password'],$_user->password)) {
						// get user informations like user id, username and user group 
						// from table and set them into a session array
 						Session::push('WebAuth.userid',$_user->user_id);
 						Session::push('WebAuth.username',$_user->username);
 						Session::push('WebAuth.usergroup',$_user->group);
 						// write admin log
 						AdminLog::insert(array(
 							'actor_id'=>$_user->user_id,
 							'action'=>'Login',
 							'ip'=>$_SERVER['REMOTE_ADDR']
 							));
						// return string "Success" to foreend
 						return 'Success';
 					} else {
						// login failed return "Username or Password Error. Login failed!" 
 						return 'Username or Password Error. Login failed!';
 					}
 				}
 			}
 			return 'Can not find this user!';
 		} else {
 			return View::make("user/login")->with('title','Login');
 		}
 	}

	// handle logout action
 	public function logoutAction()
 	{
 		// get actor id from session variable
 		$actorid = Session::get('WebAuth.userid');
 		// write admin log
 		AdminLog::insert(array(
 			'actor_id'=>reset($actorid),
 			'action'=>'Logout',
 			'ip'=>$_SERVER['REMOTE_ADDR']
 		));
		// release session variable "WebAuth"
		// if session variable'"WebAuth" is empty,
		// this user can not use application any more
 		Session::forget('WebAuth');

		// redirect to url "/login"
 		return Redirect::to('/login');
 	}

	// get user informations from administration table for displaying in foreend
 	public function getUsers()
 	{
		// ajax request
 		if (Request::ajax()) { 
			// get user list according conditions which defined in foreend
 			$users = DB::table('administration')->where('active','1')->where($_POST['field'],$_POST['field_operator'],$_POST['value'])->orderBy($_POST['orderby'],$_POST['inc'])->get();
			// generate HTML page by using usercontrol_content.blade.php template
 			return View::make('usercontrol/usercontrol_content')->with('users',$users);
 		}
		// not ajax request
 		else {
			// get all user informations from database
 			$users = DB::table('administration')->where('active','1')->get();
			// generate HTML page by using usercontrol.blade.php template
 			return View::make('usercontrol/usercontrol')->with('page',0)->with('title','Account Setting')->with('users',$users);
 		}
 	}

	// add user into administration table
 	public function addUser() {
		// ajax request
 		if (Request::ajax()) { 
 			if($_POST['username']=="") {
 				return Response::make("Username can not be empty!");
 			} else if ($_POST['password']=="") {
 				return Response::make("Password can not be empty!");
 			} else {
				try {
	 				// check whether the username already existed in administration table
	 				if(!$this->checkSame($_POST['username'])) {
						// insert a user into administration table
	 					DB::table('administration')->insert(array(
	 						'username'=>$_POST['username'],
	 						'password'=>Hash::make($_POST['password']),
	 						'group'=>$_POST['group']
	 					));
	 					//get user id which be added just before
	 					$userid = DB::table('administration')->orderby('user_id','DESC')->first()->user_id;
	 					// get actor id from session variable
	 					$actorid = Session::get('WebAuth.userid');
	 					// write admin log
	 					AdminLog::insert(array(
							'actor_id'=>reset($actorid),
							'action'=>'Add User         | User ID: '.$userid.', User Name: '.$_POST['username'].', User Group: '.$_POST['group'],
							'ip'=>$_SERVER['REMOTE_ADDR']
						));
	 					return Response::make('Success');
	 				} else {
	 					return Response::make('Username existed! Please change the username and try again!');
	 				}
	 			} catch (Exception $exception) {
					// when error occurred!
	 				return Response::make('Error: Can not add User');		
	 			} 				
 			}
 			
 		}
 	}

	// delete a user of administration table
 	public function delUser() {
		// ajax request
 		if (Request::ajax()) { 
 			try {
				// delete a user from administration table
 				DB::table('administration')->where('user_id',(int)($_POST['user_id']))->update(array('active'=>'0'));
 				// get actor id from session variable
 				$actorid = Session::get('WebAuth.userid');				
				// write admin log
				AdminLog::insert(array(
					'actor_id'=>reset($actorid),
					'action'=>'Delete User      | User ID: '.$_POST['user_id'].', User Name: '.$_POST['username'].', User Group: '.$_POST['group'],
					'ip'=>$_SERVER['REMOTE_ADDR']
				));
 				return Response::make('Success');
 			} catch (Exception $exception) {
				// when error occurred!
 				return Response::make('Error: Can not delete User');		
 			}
 		}
 	}

	// edit a user of administration table
 	public function editUser() {
		// ajax request
 		if (Request::ajax()) {
 			if($_POST['username']=="") {
				return Response::make("Username can not be empty!");
 			} else {
				if($_POST['password']==""){
					try {
		 				// check whether the username already existed in administration table
		 				if(!$this->checkSame($_POST['username'])||(int)($this->checkSame($_POST['username'])==(int)($_POST['user_id']))) {
							// edit a user from administration table
		 					DB::table('administration')->where('user_id',(int)($_POST['user_id']))->update(array(
		 						'username'=>$_POST['username'],
		 						'group'=>$_POST['group']
		 						));
		 					 // get actor id from session variable
		 					$actorid = Session::get('WebAuth.userid');	
							// write admin log
							AdminLog::insert(array(
								'actor_id'=>reset($actorid),
								'action'=>'Edit User        | User ID: '.$_POST['user_id'].', User Name: '.$_POST['username'].', User Group: '.$_POST['group'],
								'ip'=>$_SERVER['REMOTE_ADDR']
							));
		 					return Response::make('Success');
		 				} else {
		 					return Response::make('Username existed! Please change the username and try again!');
		 				}
		 			} catch (Exception $exception) {
						// when error occurred!
		 				return Response::make('Error: Can not edit User');		
		 			}
	 			} else {
					try {
		 				// check whether the username already existed in administration table
		 				if(!$this->checkSame($_POST['username'])||(int)($this->checkSame($_POST['username'])==(int)($_POST['user_id']))) {
							// edit a user from administration table
		 					DB::table('administration')->where('user_id',(int)($_POST['user_id']))->update(array(
		 						'username'=>$_POST['username'],
		 						'password'=>Hash::make($_POST['password']),
		 						'group'=>$_POST['group']
		 						));
		 					 // get actor id from session variable
		 					$actorid = Session::get('WebAuth.userid');	
							// write admin log
							AdminLog::insert(array(
								'actor_id'=>reset($actorid),
								'action'=>'Edit User        | User ID: '.$_POST['user_id'].', User Name: '.$_POST['username'].', User Group: '.$_POST['group'],
								'ip'=>$_SERVER['REMOTE_ADDR']
							));
		 					return Response::make('Success');
		 				} else {
		 					return Response::make('Username existed! Please change the username and try again!');
		 				}
		 			} catch (Exception $exception) {
						// when error occurred!
		 				return Response::make('Error: Can not edit User');		
		 			}
	 			}
 			}
 		}
 	}

 	// check whether the username already existed in administration table
 	public function checkSame($username) {
 		$users = DB::table('administration')->where('active','1')->get();
 		foreach ($users as $user) {
 			if ($user->username==$username) {
 				return $user->user_id;
 			}
 		}
 		return 0;
 	}
 }