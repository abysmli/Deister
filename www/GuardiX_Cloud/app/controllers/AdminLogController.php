<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : AdminLogController.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     AdminLogController Class is used to get admin logs from admin_log table.
 | It has also the functions like sorting and searching admin logs and even 
 | delete all datas of admin_log table.
 |
 |============================================================================
 */

class AdminLogController extends BaseController {
	// get admin log lists
	public function getAdminLog() {
		// reformat the date form of "datebegin" variable and "dateend" variable 
		$datebegin = date_format(date_create($_POST['datebegin']),'Y-m-d H:i:s');
		$dateend = date_format(date_create($_POST['dateend']),'Y-m-d H:i:s');
		try {
			// get all admin logs according to conditions
			$AdminLogs=DB::table('admin_log')->join('administration','user_id','=','actor_id')->select('admin_log.*','administration.username',DB::raw('date_format(admin_log.date, \'%d.%m.%Y %H:%i:%s\') as date'))->where($_POST['field'],$_POST['field_operator'],$_POST['value'])->where($_POST['date_type'],'>',$datebegin)->where($_POST['date_type'],'<',$dateend)->orderBy($_POST['orderby'],$_POST['inc'])->/*skip($_POST['skip'])->take(20)->*/get();
		} catch(Exception $exception) {
			// when admin occurred! return admin messages
			return Response::make($exception->getMessage());
		}
		// generate the HTML by "adminlog_gui_content.blade.php" blade template
		// and then return HTML codes to foreend
		return View::make('adminlog/adminlog_gui_content')->with('adminlogs',$AdminLogs);
	}

	// get admin logs from admin_log table for displaying in foreend at the first time 
	public function initAdminLog() {
		$dateend = date_format(date_create(),'Y-m-d H:i:s');
		$datebegin = date_create();
		date_sub($datebegin, date_interval_create_from_date_string('10 days'));
		$datebegin = date_format($datebegin, 'Y-m-d H:i:s');
		// get all admin logs list from admin_log table 
		$AdminLogs=DB::table('admin_log')->join('administration','user_id','=','actor_id')->select('admin_log.*', 'administration.username',DB::raw('date_format(admin_log.date, \'%d.%m.%Y %H:%i:%s\') as date'))->where('date','>',$datebegin)->where('date','<',$dateend)->orderBy('date','DESC')/*->take(20)*/->get();
		// generate the HTML by "adminlog_gui.blade.php" blade template
		// and then return HTML codes to foreend
		return View::make('adminlog/adminlog_gui')->with('adminlogs',$AdminLogs)->with('page',4)->with('title','Admin Logs');
	}

	// generate a csv file from the data of admin_log table
	public function getCSVFile() {
		$AdminLogs = DB::table('admin_log')->join('administration','user_id','=','actor_id')->select('admin_log.*','administration.username')->get();
		// use system temp folder
		$fp = fopen(sys_get_temp_dir().'/adminlog.csv','w');
		// create table header for csv file 
		fputcsv($fp, array('Log Number','User ID','Action','IP Address','Date','User'));
		foreach ($AdminLogs as $AdminLog) {
			// create csv file
			fputcsv($fp, get_object_vars($AdminLog));
		}
		fclose($fp);
		// response a download resource for user to get this csv file
		return Response::download(sys_get_temp_dir().'/adminlog.csv');
	}

	// delete all data of admin_log table
	public function deleteAll() {
		try {
			// delete all data of admin_log table
			DB::table('admin_log')->delete();
		} catch(Exception $exception) {
			// when admin occurred! return admin messages
			return Response::make($exception->getMessage());
		}
		// return "Delete Successfully!"
		return Response::make('Delete Successfully!');
	}
}
