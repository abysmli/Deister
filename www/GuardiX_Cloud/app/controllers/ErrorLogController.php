<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : ErrorLogController.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     ErrorLogController Class is used to get error logs from error_log table.
 | It has also the functions like sorting and searching error logs and even 
 | delete all datas of error_log table.
 |
 |============================================================================
 */

class ErrorLogController extends BaseController {
	// get error log lists
	public function getErrorLog() {
		// reformat the date form of "datebegin" variable and "dateend" variable 
		$datebegin = date_format(date_create($_POST['datebegin']),'Y-m-d H:i:s');
		$dateend = date_format(date_create($_POST['dateend']),'Y-m-d H:i:s');
		try {
			// get all error logs according to conditions
			$ErrorLogs=DB::table('error_log')->select('*', DB::raw('date_format(date, \'%d.%m.%Y %H:%i:%s\') as date'))->where($_POST['field'],$_POST['field_operator'],$_POST['value'])->where($_POST['date_type'],'>',$datebegin)->where($_POST['date_type'],'<',$dateend)->orderBy($_POST['orderby'],$_POST['inc'])->get();
		} catch(Exception $exception) {
			// when error occurred! return error messages
			return Response::make($exception->getMessage());
		}
		// generate the HTML by "errorlog_gui_content.blade.php" blade template
		// and then return HTML codes to foreend
		return View::make('errorlog/errorlog_gui_content')->with('errors',$ErrorLogs);
	}

	// get error logs from error_log table for displaying in foreend at the first time 
	public function initErrorLog() {
		$dateend = date_format(date_create(),'Y-m-d H:i:s');
		$datebegin = date_create();
		date_sub($datebegin, date_interval_create_from_date_string('10 days'));
		$datebegin = date_format($datebegin, 'Y-m-d H:i:s');
		// get all error logs list from error_log table 
		$ErrorLogs = DB::table('error_log')->select('*',DB::raw('date_format(date, \'%d.%m.%Y %H:%i:%s\') as date'))->where('date','>',$datebegin)->where('date','<',$dateend)->get();
		// generate the HTML by "errorlog_gui.blade.php" blade template
		// and then return HTML codes to foreend
		return View::make('errorlog/errorlog_gui')->with('errors',$ErrorLogs)->with('page',3)->with('title','Error Logs');
	}

	// generate a csv file from the data of error_log table
	public function getCSVFile() {
		$ErrorLogs = DB::table('error_log')->get();
		// use system temp folder
		$fp = fopen(sys_get_temp_dir().'/errorlog.csv','w');
		// create table header for csv file 
		fputcsv($fp, array('Log Number','Actor','Actor ID','IP Address','Error Code','Action','Date'));
		foreach ($ErrorLogs as $ErrorLog) {
			// create csv file
			fputcsv($fp, get_object_vars($ErrorLog));
		}
		fclose($fp);
		// response a download resource for user to get this csv file
		return Response::download(sys_get_temp_dir().'/errorlog.csv');
	}

	// delete all data of error_log table
	public function deleteAll() {
		try {
			// delete all data of error_log table
			DB::table('error_log')->delete();
		} catch(Exception $exception) {
			// when error occurred! return error messages
			return Response::make($exception->getMessage());
		}
		// return "Delete Successfully!"
		return Response::make('Delete Successfully!');
	}
}
