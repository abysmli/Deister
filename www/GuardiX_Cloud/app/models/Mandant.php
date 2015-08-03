<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : Mandant.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     Mandant database model. Mandant instance equal DB::table('mandant') without
 | Timestamp function.
 |
 |============================================================================
 */

class Mandant extends Eloquent {
	protected $table = 'mandant';
	public $timestamps = false;
}