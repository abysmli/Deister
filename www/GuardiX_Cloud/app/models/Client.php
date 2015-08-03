<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : Client.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     Client database model. Client instance equal DB::table('client') without
 | Timestamp function.
 |
 |============================================================================
 */

class Client extends Eloquent {
	protected $table = 'client';
	public $timestamps = false;
}