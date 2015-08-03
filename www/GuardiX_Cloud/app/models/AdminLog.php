<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : AdminLog.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     AdminLog database model. AdminLog instance equal DB::table('admin_log') 
 | without Timestamp function.
 |
 |============================================================================
 */

class AdminLog extends Eloquent {
	protected $table = 'admin_log';
	public $timestamps = false;
}