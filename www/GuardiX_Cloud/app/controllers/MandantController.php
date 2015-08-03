<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : MandantController.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 2.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     MandantController Class is used to control the mandant table of database.
 | Get mandant list from database, add a mandant record, edit a mandant record,
 | deactive a mandant or reactive a mandant, all of these things can be completed 
 | by using this class.  
 |
 |============================================================================
 */

class MandantController extends BaseController {
	// get mandant panel and display it in foreend
	public function getMandantPanel() {
		// SQL Syntax: SELECT * FROM mandant WHERE `mandant_active` = "1" OFFSET 0 LIMIT 30
		$mandants=Mandant::where('mandant_active',$_POST['activ'])->where('user_id','1')->skip(0)->take(30)->get();
		// use the blade template "mandant.blade.php" to generate HTML page
		return View::make('mandant/mandant')->with('mandants',$mandants)->with('active', '1');
	}

	// get mandant list from database and generate a HTML code snippet with mandant list
	public function getMandantList() {
		// when uses ajax request
		if (Request::ajax()) {
			// get mandant list from database according to conditions
			$mandants=Mandant::where('mandant_active',$_POST['activ'])->where('user_id','1')->where($_POST['field'],$_POST['operator'],$_POST['value'])->where('mandant_firmname','like',$_POST['like'])->skip((int)$_POST['skip'])->take((int)$_POST['take'])->get();
			// use the blade template "mandant_lists.blade.php" to generate HTML page
			return View::make('mandant/mandant_lists')->with('mandants',$mandants)->with('active',$_POST['activ']);
		}
	}

	// add a record into database
	public function addMandant() {
		// when uses ajax request
		if (Request::ajax()) {
			if (count(Mandant::where('username',$_POST['username'])->get())) {
				return Response::make("Error! User already existed!");
			}
			// create new mandant instance
			$mandant = new Mandant;
			$mandant->username =$_POST['username'];
			// hash the password
			$mandant->password =Hash::make($_POST['password']);
			$mandant->mandant_firmname = $_POST['company'];
			$mandant->mandant_address = $_POST['address'];
			$mandant->mandant_contact = $_POST['contact'];
			// reformat of date
			$mandant->date_insert = date('Y-m-d H:i:s');
			$mandant->mandant_active = '1';
			$mandant->save();
			//get mandant id which be added just before
			$mandantid = DB::table('mandant')->orderby('mandant_id','DESC')->first()->mandant_id;
			// write admin log
			$actorid = Session::get('WebAuth.userid');
			AdminLog::insert(array(
				'actor_id'=>reset($actorid),
				'action'=>'Add Mandant      | Mandant ID: '.$mandantid.', Mandant User Name: '.$_POST['username'].', Mandant Company: '.$_POST['company'].', Mandant Address: '.$_POST['address'].', Mandant Contact: '.$_POST['contact'],
				'ip'=>$_SERVER['REMOTE_ADDR']
			));
		}
		// get mandant list from database according to conditions
		$mandants = Mandant::where('mandant_active','1')->where('user_id','1')->skip(0)->take(30)->get();
		// use the blade template "mandant_lists.blade.php" to generate HTML page
		return View::make('mandant/mandant_lists')->with('mandants',$mandants)->with('active','1');
	}

	// deacitve a mandant by edit the record of mandant table in database
	public function delMandantbyID() {
		// when uses ajax request
		if (Request::ajax()) {
			// get all informations of this mandant
			$mandant = Mandant::where('mandant_id',$_POST['id'])->first();
			// update a record in datase
			Mandant::where('mandant_id',$_POST['id'])->update(array('mandant_active'=>'0'));
			// write admin log
			$actorid = Session::get('WebAuth.userid');
			AdminLog::insert(array(
				'actor_id'=>reset($actorid),
				'action'=>'Deactiv Mandant  | Mandant ID: '.$_POST['id'].', Mandant User Name: '.$mandant->username.', Mandant Company: '.$mandant->mandant_firmname.', Mandant Address: '.$mandant->mandant_address.', Mandant Contact: '.$mandant->mandant_contact,
				'ip'=>$_SERVER['REMOTE_ADDR']
			));
		}
	}

	// acitve a mandant by edit the record of mandant table in database
	public function activMandantbyID() {
		// when uses ajax request
		if (Request::ajax()) {
			// get all informations of this mandant
			$mandant = Mandant::where('mandant_id',$_POST['id'])->first();
			// update a record in datase
			Mandant::where('mandant_id',$_POST['id'])->update(array('mandant_active'=>'1'));
			$actorid = Session::get('WebAuth.userid');
			// write admin log
			AdminLog::insert(array(
				'actor_id'=>reset($actorid),
				'action'=>'Activ Mandant    | Mandant ID: '.$_POST['id'].', Mandant User Name: '.$mandant->username.', Mandant Company: '.$mandant->mandant_firmname.', Mandant Address: '.$mandant->mandant_address.', Mandant Contact: '.$mandant->mandant_contact,
				'ip'=>$_SERVER['REMOTE_ADDR']
			));
		}
	}

	// edit a record of mandant table in database
	public function editMandant() {
		// when uses ajax request
		if (Request::ajax()) {
			if (count(Mandant::where('username',$_POST['username'])->get())) {
				$checkUser = Mandant::where('username',$_POST['username'])->first();
				if(!($checkUser->user_id=='1')||!($checkUser->mandant_id==$_POST['id']))
				{
					return Response::make("Error! User already existed!");
				}			
			}
			if($_POST['password']!="") {
				// get a record by mandant id
				$mandant = new stdClass();
				$mandant->username =$_POST['username'];
				// hash the password
				$mandant->password =Hash::make($_POST['password']);
				$mandant->mandant_firmname = $_POST['company'];
				$mandant->mandant_address = $_POST['address'];
				$mandant->mandant_contact = $_POST['contact'];
				// modify this record
				Mandant::where('mandant_id',$_POST['id'])->where('user_id','1')->update(array(
					'username'=>$mandant->username,
					'password'=>$mandant->password,
					'mandant_firmname'=>$mandant->mandant_firmname,
					'mandant_address'=>$mandant->mandant_address,
					'mandant_contact'=>$mandant->mandant_contact));
				// modify this record
				Mandant::where('mandant_id',$_POST['id'])->update(array(
					'mandant_firmname'=>$mandant->mandant_firmname,
					'mandant_address'=>$mandant->mandant_address,
					'mandant_contact'=>$mandant->mandant_contact));
			} else {
				// get a record by mandant id
				$mandant = new stdClass();
				$mandant->username =$_POST['username'];
				$mandant->mandant_firmname = $_POST['company'];
				$mandant->mandant_address = $_POST['address'];
				$mandant->mandant_contact = $_POST['contact'];
				// modify this record
				Mandant::where('mandant_id',$_POST['id'])->where('user_id','1')->update(array(
					'username'=>$mandant->username,
					'mandant_firmname'=>$mandant->mandant_firmname,
					'mandant_address'=>$mandant->mandant_address,
					'mandant_contact'=>$mandant->mandant_contact));
				// modify this record
				Mandant::where('mandant_id',$_POST['id'])->update(array(
					'mandant_firmname'=>$mandant->mandant_firmname,
					'mandant_address'=>$mandant->mandant_address,
					'mandant_contact'=>$mandant->mandant_contact));				
			}
			$actorid = Session::get('WebAuth.userid');
			// write admin log
			AdminLog::insert(array(
				'actor_id'=>reset($actorid),
				'action'=>'Edit Mandant     | Mandant ID: '.$_POST['id'].', Mandant User Name: '.$_POST['username'].', Mandant Company: '.$_POST['company'].', Mandant Address: '.$_POST['address'].', Mandant Contact: '.$_POST['contact'],
				'ip'=>$_SERVER['REMOTE_ADDR']
			));
			// get this record one more time in order to display it in foreend
			$mandants = Mandant::where('mandant_id',$_POST['id'])->where('user_id','1')->get();
		}
		// use the blade template "mandant_lists.blade.php" to generate HTML page
		return View::make('mandant/mandant_lists')->with('mandants',$mandants)->with('active','1');
	}
}