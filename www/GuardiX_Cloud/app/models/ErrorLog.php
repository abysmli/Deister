<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : ErrorLog.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     ErrorLog database model. ErrorLog instance equal DB::table('error_log') 
 | without Timestamp function.
 |
 |============================================================================
 */

class ErrorLog extends Eloquent {
	protected $table = 'error_log';
	public $timestamps = false;
}