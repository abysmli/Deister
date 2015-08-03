<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : EventController.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 3.2
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     EventController Class is used to get event logs from event_log 
 | and event_log table. It has also the functions like sorting and 
 | searching event logs and even delete all datas of both tables.
 |
 |============================================================================
 */

 class EventController extends BaseController {
	// get event list
 	public function getEvent() {
		// reformat the date form of "datebegin" variable and "dateend" variable 
		$datebegin = date_format(date_create($_POST['datebegin']),'Y-m-d H:i:s');
		$dateend = date_format(date_create($_POST['dateend']),'Y-m-d H:i:s');
		// reformat the ip form from ip address string to ip integer
		try {
			// get event logs from event_log table according to conditions
 			$EventLogs = DB::table('event_log')->join('client','client.client_id','=','event_log.client_id')->join('mandant','client.mandant_id','=','mandant.mandant_id')->select('log_nr', 'message_id','mandant.mandant_firmname','useragent','client.client_id','client_ip','action',DB::raw('date_format(insert_date, \'%d.%m.%Y %H:%i:%s\') as insert_date'))->where('mandant.user_id','1')->where($_POST['field'],$_POST['field_operator'],$_POST['value'])->where($_POST['date_type'],'>',$datebegin)->where($_POST['date_type'],'<',$dateend)->orderBy($_POST['orderby'],$_POST['inc'])->get();
		} catch(Exception $exception) {
			// when event occurred! return event messages
			return Response::make($exception->getMessage());
		}
		// generate the HTML by "eventlog_gui_content.blade.php" blade template
		// and then return HTML codes to foreend
 		return View::make('eventlog/eventlog_gui_content')->with('events',$EventLogs);
 	}

	// get event logs from event_log and event_log tables for displaying in foreend for the first time
 	public function initEvent() {
 		$dateend = date_format(date_create(),'Y-m-d H:i:s');
		$datebegin = date_create();
		date_sub($datebegin, date_interval_create_from_date_string('10 days'));
		$datebegin = date_format($datebegin, 'Y-m-d H:i:s');
		// get event logs from event_log table
 		$EventLogs = DB::table('event_log')->join('client','client.client_id','=','event_log.client_id')->join('mandant','client.mandant_id','=','mandant.mandant_id')->select('log_nr', 'message_id','mandant.mandant_firmname','useragent','client.client_id','client_ip','action',DB::raw('date_format(insert_date, \'%d.%m.%Y %H:%i:%s\') as insert_date'))->where('mandant.user_id','1')->where('insert_date','>',$datebegin)->where('insert_date','<',$dateend)->orderby('log_nr','ASC')->get();
 		return View::make('eventlog/eventlog_gui')->with('page',2)->with('title','Event Logs')->with('events',$EventLogs);
 	}

	// generate a csv file from the data of event log tables
 	public function getCSVFile() {
		// get event logs from event_log table
 		$EventLogs = DB::table('event_log')->join('client','client.client_id','=','event_log.client_id')->join('mandant','client.mandant_id','=','mandant.mandant_id')->select('log_nr', 'message_id','mandant.mandant_firmname','useragent','client.client_id','client_ip','action','insert_date')->where('mandant.user_id','1')->orderby('log_nr','ASC')->get();

		// use system temp folder
 		$fp = fopen(sys_get_temp_dir().'/eventlog.csv','w');
		// create table header for csv file 
 		fputcsv($fp, array('Log Number', 'Message ID', 'Mandant Firma Name','User Agent','Client ID','Client IP','Action', 'Date'));
 		foreach ($EventLogs as $EventLog) {
			// create csv file
 			fputcsv($fp, get_object_vars($EventLog));
 		}
 		fclose($fp);
		// response a download resource for user to get this csv file
 		return Response::download(sys_get_temp_dir().'/eventlog.csv');
 	}

	// delete all data of event_log table and event_log table
 	public function deleteAll() {
 		try {
			// delete all data of event_log table
 			DB::table('event_log')->delete();
 		} catch(Exception $exception) {
			// when error occurred! return error messages
 			return Response::make($exception->getMessage());
 		}
		// return "Delete Successfully!"
 		return Response::make('Delete Successfully!');
 	}

 }
