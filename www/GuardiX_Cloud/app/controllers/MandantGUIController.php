<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : MandantGUIController.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 3.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     MandantGUIController Class is used to control the client_permission table of
 | database. Get client_permission list from database, add a new record into table,
 | edit a record of table or delete a record of table, add a new mandant user, 
 | edit a mandant user, deactive a mandant user, active a client, deactive a 
 | client, active a device or deactive a device, all of these things can be 
 | completed by using this class.
 |
 |============================================================================
 */

 class MandantGUIController extends BaseController {
	// get client list by mandant id from database
 	public function getClientList() {
		// get client list by mandant id from database
 		$clients = DB::table('client')->where('mandant_id',Session::get('mandantid'))->get();
		// return these data in form of json to foreend
		return $this->custom_response('200 OK',$this->convertClientListforJson($clients),'Get Client list successed');
 		//return Response::json($clients);
 	}

 	// get user list by mandant id from database
 	public function getUserList() {
		// get user list by mandant id from database
 		$users = DB::table('mandant')->where('mandant_id',Session::get('mandantid'))->get();
		// return these data in form of json to foreend
		return $this->custom_response('200 OK',$this->convertUserListforJson($users),'Get User list successed');
 		//return Response::json($users);
 	}

	// get mandant informations by mandant id from database
 	public function getMandantInformation() {
		// get mandant informations by mandant id from database
 		$mandant = DB::table('mandant')->where('mandant_id',Session::get('mandantid'))->first();
		// return these data in form of json to foreend
		return $this->custom_response('200 OK',$this->convertMandantInformationforJson($mandant),'Get Mandant information successed');
 		//return Response::json($mandant);
 	}

	// get client_permission list by mandant id from database
 	public function getClientPermission() {
 		try {
			// create a new table which use client_permission, client and device tables.
			// and then get records from it by mandant id
 			$client_permission = DB::table('client_permission')->join('client as c_s','c_s.client_id','=','client_permission.client_id_s')->join('client as c_r','c_r.client_id','=','client_permission.client_id_r')->where('c_s.mandant_id',Session::get('mandantid'))->where('c_r.mandant_id',Session::get('mandantid'))->select('client_id_s','client_id_r','permission')->get();
			// return these data in form of json to foreend
			return $this->custom_response('200 OK',$this->convertClientPermissionforJson($client_permission),'Get client permissions successed');
 			//return Response::json($client_permission);
 		} catch(Exception $exception) {
			// when error occurred, return exception messages
 			return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 		}
 	} 

	// add a new record into client_permission table
 	public function addClientPermission() {
 		try {
 			$checkInfo = $this->checkValid('addClientPermission');
 			if($checkInfo !='Success'){
 				return $this->custom_response('403 Forbidden','Error',$checkInfo);
 			} else {
 				// use SQL INSERT Syntax to insert a record
 				DB::table('client_permission')->insert(array(
 					'client_id_s'=>$_POST['client_id_s'],
 					'client_id_r'=>$_POST['client_id_r'],
 					'permission'=>$_POST['permission']
 					));	
 				// write mandant action log
 				$this->writeMandantLog('Add a Client Permission | Send Client ID: '.$_POST['client_id_s'].' Receive Client ID: '.$_POST['client_id_r'].' Permission: '.$_POST['permission']);
	 			// write mandant action log
 			}		
 		} catch(Exception $exception) {
			// when error occurred, return exception messages
 			return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 		}
		// insert into database successful, return sting "Success" to foreend
 		return $this->custom_response('200 OK','Success','Add client permission successed');
 	}

	// edit a record from client_permission table
 	public function editClientPermission() {
 		try {
 			$checkInfo = $this->checkValid('editClientPermission');
 			if($checkInfo !='Success'){
 				return $this->custom_response('403 Forbidden','Error',$checkInfo);
 			} else {
				// update a record by using the data which get from foreend post requests
 				DB::table('client_permission')->where('client_id_s',$_POST['client_id_s'])->where('client_id_r',$_POST['client_id_r'])->where('permission',$_POST['permission'])->update(array(
 					'client_id_s'=>$_POST['new_client_id_s'],
 					'client_id_r'=>$_POST['new_client_id_r'],
 					'permission'=>$_POST['new_permission']
 					));
	 			// write mandant action log
				$this->writeMandantLog('Edit a Client Permission | Send Client ID: '.$_POST['client_id_s'].' Receive Client ID: '.$_POST['client_id_r'].' Permission: '.$_POST['permission'].' New Send Client ID: '.$_POST['new_client_id_s'].' NeW Receive Client ID: '.$_POST['new_client_id_r'].' New_Permission: '.$_POST['new_permission']); 
 			}
 		}
 		catch (Exception $exception)
 		{
			// when error occurred, return exception messages
 			return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 		}
		// edit successful, return sting "Success" to foreend
 		return $this->custom_response('200 OK','Success','Edit Client permission successed');
 	}

	// delete a record from client_permission table
 	public function delClientPermission() {
 		try {
 			$checkInfo = $this->checkValid('delClientPermission');
 			if($checkInfo !='Success'){
 				return $this->custom_response('403 Forbidden','Error',$checkInfo);
 			} else {
				// find this record by using the informations which get from foreend post requests
 				DB::table('client_permission')->where('client_id_s',$_POST['client_id_s'])->where('client_id_r',$_POST['client_id_r'])->where('permission',$_POST['permission'])->delete();
	 			// write mandant action log
				$this->writeMandantLog('Delete a Client Permission | Send Client ID: '.$_POST['client_id_s'].' Receive Client ID: '.$_POST['client_id_r'].' Permission: '.$_POST['permission']); 
			}
 		}
 		catch (Exception $exception) {
			// when error occurred, return exception messages
 			return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 		}
		// delete successful, return sting "Success" to foreend
 		return $this->custom_response('200 OK','Success','Delete Client permission successed');
 	}

	// add a user for mandant
 	public function addMandantUser() {
 		// chech whether the user is admin of mandant
 		if(Session::get('userid')=='1'){
			// get User information from foreend
 			$mandantid=Session::get('mandantid');
 			$username=$_POST['username'];
 			$password=$_POST['password'];
			// check whether the same username existed in table
 			if (count(Mandant::where('username',$username)->get())) {
				// return Username existed
 				return $this->custom_response('403 Forbidden','Error',"Username already existed, Please try again.");
 			} else {
				// get other mandant informations from table
 				$mandant=Mandant::where('mandant_id',$mandantid)->where('user_id','1')->first();
				// get the last user id
 				$userid=Mandant::where('mandant_id',$mandantid)->orderby('user_id','DESC')->first()->user_id+1;
 				$user = array(
 					'mandant_id'=>$mandant->mandant_id,
 					'user_id'=>$userid,
 					'username'=>$username,
 					'password'=>Hash::make($password),
 					'mandant_firmname'=>$mandant->mandant_firmname,
 					'mandant_address'=>$mandant->mandant_address,
 					'mandant_contact'=>$mandant->mandant_contact,
 					'mandant_active'=>$mandant->mandant_active,
 					'date_insert'=>date('Y-m-d H:i:s')
 					);
 				try {
					// insert the new user record into database
 					Mandant::insert($user);
		 			// write mandant action log
					$this->writeMandantLog('Add a Mandant User | User ID: '.$userid.' Username: '.$username);
 				} catch (Exception $exception) {
					// when error occurred, return exception messages
 					return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 				}
				// return Success
				return $this->custom_response('200 OK','Success','Add Mandant User successed');
 			}	
 		} else {
 			return $this->custom_response('403 Forbidden','Error','Permission Denied! You are not admins');
 		}	
 	}

 	// edit a user of mandant
 	public function editMandantUser() {
 		// chech whether the user is admin of mandant
 		if(Session::get('userid')=='1') {
			// get User information from foreend
 			$mandantid=Session::get('mandantid');
 			$userid=$_POST['user_id'];
 			$username=$_POST['username'];
 			$password=$_POST['password'];
 			// check whether the same username existed in table
 			if (count(Mandant::where('username',$username)->get())) {
 				$checkUser = Mandant::where('username',$username)->first();
 				if (!($checkUser->user_id==$userid)||!($checkUser->mandant_id==$mandantid))
 				{
 					// return Username existed
 					return $this->custom_response('403 Forbidden','Error',"Username already existed, Please try again.");
 				}
 			}
			// get other mandant informations from table
 			$mandant=Mandant::where('mandant_id',$mandantid)->where('user_id','1')->first();
 			$user = array(
 				'username'=>$username,
 				'password'=>Hash::make($password)
 				);
 			try {
				// update the user record of database
 				Mandant::where('mandant_id',$mandantid)->where('user_id',$userid)->update($user);
 				$this->writeMandantLog('Edit a Mandant User | User ID: '.$userid.' Username: '.$username);
 			} catch (Exception $exception) {
				// when error occurred, return exception messages
 				return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 			}
			// return Success
 			return $this->custom_response('200 OK','Success','Edit Mandant User successed');
 		} else {
 			return $this->custom_response('403 Forbidden','Error','Permission Denied! You are not admins');
 		}	
 	}

 	// deactivate a user for mandant
 	public function delMandantUser() {
 		// chech whether the user is admin of mandant
 		if(Session::get('userid')=='1') {
 			try {
 				// deactive a user by set the mandant_active to 0
 				Mandant::where('mandant_id',Session::get('mandantid'))->where('user_id',$_POST['user_id'])->update(array('mandant_active'=>'0'));
 				$this->writeMandantLog('Delete a Mandant User | User ID: '.$userid);
 			} catch (Exception $exception) {
				// when error occurred, return exception messages
 				return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 			}	
 			// return Success
 			return $this->custom_response('200 OK','Success','Delete Mandant User successed');
 		} else {
 			return $this->custom_response('403 Forbidden','Error','Permission Denied! You are not admins');
 		}
 	}

	// activate a client 
 	public function actClient() {
 		try {
 			$checkInfo = $this->checkValid('activateClient');
 			if($checkInfo !='Success'){
 				return $this->custom_response('403 Forbidden','Error',$checkInfo);
 			} else {
				// activate client by client_id
 				Client::where('client_id',$_POST['id'])->update(array('client_active'=>'1'));
 				$this->writeMandantLog('Activate a Client | Client ID: '.$_POST['id']);
 			}
 		}
 		catch (Exception $exception) {
			// when error occurred, return exception messages
 			return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 		}
		// activate successful, return sting "Success" to foreend
 		return $this->custom_response('200 OK','Success','activate Client successed');
 	}

	// deactivate a client
 	public function deactClient() {
 		try {
 			$checkInfo = $this->checkValid('deactivateClient');
 			if($checkInfo !='Success'){
 				return $this->custom_response('403 Forbidden','Error',$checkInfo);
 			} else {
				// activate client by client_id
 				Client::where('client_id',$_POST['id'])->update(array('client_active'=>'0'));
 				$this->writeMandantLog('Deactivate a Client | Client ID: '.$_POST['id']);
 			}
 		}
 		catch (Exception $exception) {
			// when error occurred, return exception messages
 			return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 		}
		// deactivate successful, return sting "Success" to foreend
 		return $this->custom_response('200 OK','Success','deactivate Client successed');
 	}

	// change client mac
 	public function changeClient() {
 		try {
 			$checkInfo = $this->checkValid('changeClient');
 			if($checkInfo !='Success'){
 				return $this->custom_response('403 Forbidden','Error',$checkInfo);
 			} else {
				// activate client by client_id
 				Client::where('client_id',$_POST['id'])->update(array('client_login'=>$_POST['client_login'],'client_password'=>$_POST['client_password']));
 				$this->writeMandantLog('Change a Client | Client ID: '.$_POST['id'].' Client Login: '.$_POST['client_login']);
 			}
 		}
 		catch (Exception $exception) {
			// when error occurred, return exception messages
 			return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 		}
		// deactivate successful, return sting "Success" to foreend
 		return $this->custom_response('200 OK','Success','change Client Successed');		
 	}

 	// get mandant logs
 	public function getMandantLog() {
 		try {
 			// get mandant logs from database
 			$MandantLog = DB::table('mandant_log')->where('mandant_id',Session::get('mandantid'))->get();
 		}
 		catch (Exception $exception) {
			// when error occurred, return exception messages
 			return $this->custom_response('500 Internal Server Error','Error',$exception->getMessage());
 		}
 		// return these data in form of json to foreend
		return $this->custom_response('200 OK',$MandantLog,'Get Mandant Log successed');
 	}


 	// check whether user the permission has
 	private function checkValid($method) {
 		if ($method == "addClientPermission" || $method == 'delClientPermission') {
 			if($_POST['client_id_s'] == $_POST['client_id_r']) {
 				return 'Clients ID can not be the same!';
 			}
 			$client_s = DB::table('client')->where('client_id',$_POST['client_id_s'])->first();
 			$client_r = DB::table('client')->where('client_id',$_POST['client_id_r'])->first();
 			if ($client_s->mandant_id!=Session::get('mandantid')||$client_r->mandant_id!=Session::get('mandantid'))
 			{
 				return 'One of the clients is not belong to your mandant!';
 			}
 		} else if ( $method == 'editClientPermission') {
 			if($_POST['client_id_s'] == $_POST['client_id_r'] || $_POST['new_client_id_s'] == $_POST['new_client_id_r']) {
 				return 'Clients ID can not be the same!';
 			}
 			$client_s = DB::table('client')->where('client_id',$_POST['client_id_s'])->first();
 			$client_r = DB::table('client')->where('client_id',$_POST['client_id_r'])->first();
 			$new_client_s = DB::table('client')->where('client_id',$_POST['new_client_id_s'])->first();
 			$new_client_r = DB::table('client')->where('client_id',$_POST['new_client_id_r'])->first();
 			if ($client_s->mandant_id!=Session::get('mandantid')||$client_r->mandant_id!=Session::get('mandantid')||$new_client_s->mandant_id!=Session::get('mandantid')||$new_client_r->mandant_id!=Session::get('mandantid'))
 			{
 				return 'One of the clients is not belong to your mandant!';
 			} 			
 		} else if ( $method == 'activateClient' || $method == 'deactivateClient' || $method == 'changeClient') {
 			$client = DB::table('client')->where('client_id',$_POST['id'])->first();
 			if ($client->mandant_id!=Session::get('mandantid')) {
 				return 'Client ID ('.$_POST['id'].') is not belong to your mandant!';
 			}
 		}
 		return'Success';
 	}

	// write mandant action log
 	private function writeMandantLog($Log) {
		// write mandant action log
		DB::table('mandant_log')->insert(array(
			'mandant_id'=>Session::get('mandantid'),
			'user_id'=>Session::get('userid'),
			'action'=>$Log, 
			'ip'=>$_SERVER['REMOTE_ADDR']
		));
 	}

 	// custom response for error handling
 	private function custom_response($status, $result, $message) {
		$response = Response::json(array('status'=>$status,'result'=>$result,'message'=>$message));
		$response->header('Status', $status);
		return $response;
 	}

 	// convert string value to int value for transfering json
 	private function convertMandantInformationforJson($mandant) {
		$mandant->mandant_id=intval($mandant->mandant_id);
		$mandant->user_id=intval($mandant->user_id);
		$mandant->mandant_active=intval($mandant->mandant_active);	
		return $mandant;
	}
	
 	// convert string value to int value for transfering json
 	private function convertUserListforJson($mandants) {
 		foreach($mandants as $mandant) {
			$mandant->mandant_id=intval($mandant->mandant_id);
			$mandant->user_id=intval($mandant->user_id);
			$mandant->mandant_active=intval($mandant->mandant_active);	
		}
		return $mandants;
	}

	// convert string value to int value for transfering json
 	private function convertClientListforJson($clients) {
		foreach($clients as $client) {
			$client->client_id=intval($client->client_id);
			$client->mandant_id=intval($client->mandant_id);
			$client->client_active=intval($client->client_active);
		}
		return $clients;
	}
	
	// convert string value to int value for transfering json
 	private function convertClientPermissionforJson($client_permissions) {
 		foreach($client_permissions as $client_permission) {
			$client_permission->client_id_s=intval($client_permission->client_id_s);
			$client_permission->client_id_r=intval($client_permission->client_id_r);
		}
		return $client_permissions;
	}
}
