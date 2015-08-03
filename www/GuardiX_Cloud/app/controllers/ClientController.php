<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : ClientController.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     ClientController Class is used to control the client table of database.
 | Get client list from database, add a client record, edit a client record,
 | deactive a client or reactive a client, all of these things can be completed 
 | by using this class.  
 |
 |============================================================================
 */

class ClientController extends BaseController {
	// get client panel and display it in foreend
	public function getClientPanel() {
		// SQL Syntax: SELECT * FROM client WHERE `client_active` = "1" OFFSET 0 LIMIT 30
		$clients=Client::where('client_active',$_POST['activ'])->skip(0)->take(30)->get();
		// use the blade template "client.blade.php" to generate HTML page
		return View::make('client/client')->with('clients',$clients)->with('active', $_POST['activ']);
	}

	// get client list from database and generate a HTML code snippet with client list
	public function getClientList() {
		// when uses ajax request
		if (Request::ajax()) {
			// get client list from database according to conditions
			$clients=Client::where('client_active',$_POST['activ'])->where($_POST['field'],$_POST['operator'],$_POST['value'])->skip((int)$_POST['skip'])->take((int)$_POST['take'])->get();
			// use the blade template "client_lists.blade.php" to generate HTML page
			return View::make('client/client_lists')->with('clients',$clients)->with('active',$_POST['activ']);
		}
	}

	// add a record into database
	public function addClient() {
		// when uses ajax request
		if (Request::ajax()) {
			if(Client::where('client_id',$_POST['client_id'])->count()) {
				return Response::make('Error: Client ID '.$_POST['client_id'].' already exsited!');
			}
			// create new client instance
			$client = new Client;
			$client->mandant_id = $_POST['mandant_id'];
			$client->client_id = $_POST['client_id'];
			$client->client_login = $_POST['client_login'];
			$client->client_sort = $_POST['client_sort'];
			// hash the password
			$client->client_password = Hash::make($_POST['client_password']);
			$client->client_active = '1';
			// reformat of date
			$client->date_insert = date('Y-m-d H:i:s');
			try
			{
				// add the instance into database
				$client->save();
				// get client id which be added just before
				$actorid = Session::get('WebAuth.userid');
				// write admin log
				AdminLog::insert(array(
					'actor_id'=>reset($actorid),
					'action'=>'Add Client       | For Mandant ID: '.$_POST['mandant_id'].', Client Sort: '.$_POST['client_sort'].', Client ID: '.$_POST['client_id'].', Client Login: '.$_POST['client_login'],
					'ip'=>$_SERVER['REMOTE_ADDR']
				));
			}
			catch(Exception $exception)
			{
				// when error occurred!
				return Response::make('Error: Can not find Mandant ID '.$_POST['mandant_id']);
			}
		}
		// get client list from database according to conditions
		$clients = Client::where('client_active', '1')->where('mandant_id',$_POST['operator'],$_POST['id'])->skip(0)->take(30)->get();
		// use the blade template "client_lists.blade.php" to generate HTML page
		return View::make('client/client_lists')->with('clients',$clients)->with('active','1');
	}

	// deacitve a client by edit the record of client table in database
	public function delClientbyID() {
		// when uses ajax request
		if (Request::ajax())
		{
			//get this client
			$client = Client::where('client_id',$_POST['id'])->first();
			// update a record in datase
			Client::where('client_id',$_POST['id'])->update(array('client_active'=>'-1'));
			$actorid = Session::get('WebAuth.userid');
			// write admin log
			AdminLog::insert(array(
				'actor_id'=>reset($actorid),
				'action'=>'Deactiv Client   | For Mandant ID: '.$client->mandant_id.', Client Sort: '.$client->client_sort.', Client ID: '.$_POST['id'].', Client Login: '.$client->client_login,
				'ip'=>$_SERVER['REMOTE_ADDR']
			));
		}
	}

	// acitve a client by edit the record of client table in database
	public function activClientbyID() {
		// when uses ajax request
		if (Request::ajax())
		{
			//get this client
			$client = Client::where('client_id',$_POST['id'])->first();
			// update a record in datase
			Client::where('client_id',$_POST['id'])->update(array('client_active'=>'1'));
			$actorid = Session::get('WebAuth.userid');
			// write admin log
			AdminLog::insert(array(
				'actor_id'=>reset($actorid),
				'action'=>'Active Client    | For Mandant ID: '.$client->mandant_id.', Client Sort: '.$client->client_sort.', Client ID: '.$_POST['id'].', Client Login: '.$client->client_login,
				'ip'=>$_SERVER['REMOTE_ADDR']
			));
		}
	}

	// edit a record of client table in database
	public function editClient() {
		// when uses ajax request
		if (Request::ajax())
		{
			if((Client::where('client_id',$_POST['client_id'])->count())&&($_POST['client_id']!=$_POST['id'])) {
				return Response::make('Error: Client ID '.$_POST['client_id'].' already exsited!');
			}
			if($_POST['client_password']=="") {
				// get a record by client id
				$client = Client::where('client_id',$_POST['id'])->first();
				$client->client_id = $_POST['client_id'];
				$client->mandant_id = $_POST['mandant_id'];
				$client->client_login = $_POST['client_login'];
				$client->client_sort = $_POST['client_sort'];
				$client->client_active = '1';
				try
				{
					// modify this record
					Client::where('client_id',$_POST['id'])->update(array(
						'client_id'=>$client->client_id,
						'mandant_id'=>$client->mandant_id,
						'client_login'=>$client->client_login,
						'client_sort'=>$client->client_sort,
						'client_active'=>'1'));
					$actorid = Session::get('WebAuth.userid');
					// write admin log
					AdminLog::insert(array(
						'actor_id'=>reset($actorid),
						'action'=>'Edit Client      | For Mandant ID: '.$_POST['mandant_id'].', Client Sort: '.$_POST['client_sort'].', Client ID: '.$_POST['client_id'].', Client Login: '.$client->client_login,
						'ip'=>$_SERVER['REMOTE_ADDR']
					));
				}
				catch(Exception $exception)
				{
					// when error occurred
					return Response::make('Error: Can not find Mandant ID '.$client->mandant_id);
				}				
			} else {
				// get a record by client id
				$client = Client::where('client_id',$_POST['id'])->first();
				$client->client_id = $_POST['client_id'];
				$client->mandant_id = $_POST['mandant_id'];
				$client->client_login = $_POST['client_login'];
				$client->client_sort = $_POST['client_sort'];
				$client->client_password = Hash::make($_POST['client_password']);
				$client->client_active = '1';
				try
				{
					// modify this record
					Client::where('client_id',$_POST['id'])->update(array(
						'client_id'=>$client->client_id,
						'mandant_id'=>$client->mandant_id,
						'client_login'=>$client->client_login,
						'client_sort'=>$client->client_sort,
						'client_password'=>$client->client_password,
						'client_active'=>'1'));
					$actorid = Session::get('WebAuth.userid');
					// write admin log
					AdminLog::insert(array(
						'actor_id'=>reset($actorid),
						'action'=>'Edit Client      | For Mandant ID: '.$_POST['mandant_id'].', Client Sort: '.$_POST['client_sort'].', Client ID: '.$_POST['client_id'].', Client Login: '.$client->client_login,
						'ip'=>$_SERVER['REMOTE_ADDR']
					));
				}
				catch(Exception $exception)
				{
					// when error occurred
					return Response::make('Error: Can not find Mandant ID '.$client->mandant_id);
				}	
			}
		}
		// get this record one more time in order to display it in foreend
		$clients = Client::where('client_id',$_POST['client_id'])->get();
		// use the blade template "client_lists.blade.php" to generate HTML page
		return View::make('client/client_lists')->with('clients',$clients)->with('active','1');
	}
}