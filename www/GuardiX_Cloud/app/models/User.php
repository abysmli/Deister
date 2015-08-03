<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : User.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     User database model. User instance equal DB::table('mandant') without
 | Timestamp function. This model used for authentication of administration 
 |
 |============================================================================
 */
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mandant';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
}