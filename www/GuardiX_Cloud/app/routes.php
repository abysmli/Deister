<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : routes.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 3.1
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     Here is where register all of the routes for an application.
 |     It's a breeze. Simply tell Laravel the URIs it should respond to and give 
 | it the Closure to execute when that URI is requested.
 |
 |============================================================================
 */

// URL: /login for adminstration Login
// use UserController Class loginAction methode to handle login action
 Route::any('/login', array(
 	"uses" => "UserController@loginAction"
 ));


// use adminauth module for administration authentication
// set a Route Group which use adminauth for authentication
// that means all routes, which are in this group,
// will use administration table to authenticate
 Route::group(array('before' => 'webauth'), function()
 {
	// get "GET" request, and uses blade template file to generate the homepage 
 	Route::get('/', array(function()
 	{
		// use mainpage.blade template to generate the homepage and set page equal 0, set title equal "Main Page"
 		return View::make('mainpage')->with('page',0)->with('title','Main Page');
 	}));

	// logout action 
 	Route::any('/logout', array(
 		'before'=>'pamauth',
 		'uses' => 'UserController@logoutAction'
 		));

 	// check whether the user belong to admins group
 	Route::group(array('before' => 'admingroup'), function()
 	{

 		/*------------------------- Administration GUI Mandant-------------------------*/
		// get "GET" request which with url "/admin"
		// and use blade template to generate the page
 		Route::get('/admin', array(function()
 		{
			// Mandant is the instance from database model
			// get mandant list from SQL database which mandant_active equal 1
			// use SQL syntax : select * from `mandant` where `mandant_active` = '1' limit 30 offset 0
			// at the first time get only 30 mandants from database 
			// in order to reduce the stress of Server
 			$mandants=Mandant::where('mandant_active','1')->where('user_id','1')->skip(0)->take(30)->get();

			// use adminstration_gui.blade template file to generate the administration page
			// transfer mandants list, which got from SQL database, to HTML page
			// set title = "Administration" and set active = "1"
 			return View::make('administration/administration_gui')->with('page',1)->with('title','Administration')->with('mandants',$mandants)->with('active','1');
 		}));

		// use MandantController class getMandantPanel Methode to handle post request.
		// @param 'uses'=>'MandantController@getMandantPanel'
		// 'uses' means use controller
		// 'MandantController' means use 'MandantController' Controller Class
		// '@getMandantPanel' means use 'getMandantPanel' Methode of 'MandantController' Class
		// return a mandant panel
 		Route::post('/get_mandantPanel', array('uses'=>'MandantController@getMandantPanel'));

		// add a mandant in database
 		Route::post('/add_mandant', array('uses'=>'MandantController@addMandant'));

		// deactive a mandant from database by mandant id
 		Route::post('/del_mandant_id', array('uses'=>'MandantController@delMandantbyID'));

		// active a mandant by mandant id
 		Route::post('/activ_mandant_id', array('uses'=>'MandantController@activMandantbyID'));

		// edit a mandant
 		Route::post('/edit_mandant', array('uses'=>'MandantController@editMandant'));

		// get mandant list according conditions
 		Route::post('/get_mandantList', array('uses'=>'MandantController@getMandantList'));

 		/*------------------------- Administration GUI Client-------------------------*/

		// return a client panel
 		Route::post('/get_clientPanel', array('uses'=>'ClientController@getClientPanel'));

		// add a client
 		Route::post('/add_client', array('uses'=>'ClientController@addClient'));

		// deactive a client by client id
 		Route::post('/del_client_id', array('uses'=>'ClientController@delClientbyID'));

		// active a client by client id
 		Route::post('/activ_client_id', array('uses'=>'ClientController@activClientbyID'));

		// edit a client 
 		Route::post('/edit_client', array('uses'=>'ClientController@editClient'));

		// get client list according conditions
 		Route::post('/get_clientList', array('uses'=>'ClientController@getClientList'));

 		/*------------------------- Administrations Setting-------------------------*/

 		// get user list when user get into user control GUI for the first time
 		Route::get('/setting', array('uses'=>'UserController@getUsers'));

 		// get user list according conditions
 		Route::post('/setting', array('uses'=>'UserController@getUsers'));

 		// add user into administration table
 		Route::post('/add_user', array('uses'=>'UserController@addUser'));

 		// delete a user from administration table
 		Route::post('/del_user', array('uses'=>'UserController@delUser'));

 		// edit a user from administration table
 		Route::post('/edit_user', array('uses'=>'UserController@editUser'));

 		/*------------------------- Admin Log GUI -------------------------*/

		// get admin log list when user get into admin log GUI for the first time
		Route::get('/adminlog', array('uses'=>'AdminLogController@initAdminLog'));

		// get admin log list according conditions
		Route::post('/adminlog_search', array('uses'=>'AdminLogController@getAdminlog'));

		// get admin log csv file
		Route::get('/get_adminlog_csv', array('uses'=>'AdminLogController@getCSVFile'));

		// delete all data of admin_log table
		Route::post('/delele_adminlog', array('uses'=>'AdminLogController@deleteAll'));

 	});
	/*------------------------- Event Log GUI -------------------------*/

	// get event list when user get into event log GUI for the first time
	Route::get('/event', array('uses'=>'EventController@initEvent'));

	// get event list according conditions
	Route::post('/event_search', array('uses'=>'EventController@getEvent'));

	// get event log csv file
	Route::get('/get_event_csv', array('uses'=>'EventController@getCSVFile'));

	// delete all data of device_event_log table and client_event_log table
	Route::post('/delele_event', array('uses'=>'EventController@deleteAll'));

	/*------------------------- Error Log GUI -------------------------*/
	// get error log list when user get into error log GUI for the first time
	Route::get('/errorlog', array('uses'=>'ErrorLogController@initErrorlog'));

	// get error log list according conditions
	Route::post('/errorlog_search', array('uses'=>'ErrorLogController@getErrorlog'));

	// get error log csv file
	Route::get('/get_errorlog_csv', array('uses'=>'ErrorLogController@getCSVFile'));

	// delete all data of error_log table
	Route::post('/delele_errorlog', array('uses'=>'ErrorLogController@deleteAll'));
});

/*------------------------- Mandant JAVAFX GUI-------------------------*/

// POST URL: /mandant_api_login for mandants Login
Route::post('/mandant_api_login', array('uses'=>'MandantUserController@loginAction'));

// POST URL: /mandant_api_login for mandants Login
Route::post('/mandant_api_logout', array('uses'=>'MandantUserController@logoutAction'));

// use auth module for mandants authentication
// set a Route Group which use auth module for authentication
// that means all routes, which are in this group,
// will use auth module to authenticate
Route::group(array('before' => 'auth'), function()
{
	// get user list by mandant id
	Route::post('/mandant_api_get_user', array('uses'=>'MandantGUIController@getUserList'));

	// get client list by mandant id
	Route::post('/mandant_api_get_clientList', array('uses'=>'MandantGUIController@getClientList'));

	// get mandant informations by mandant id
	Route::post('/mandant_api_get_mandantInformation', array('uses'=>'MandantGUIController@getMandantInformation'));

	// get client device list by mandant id
	Route::post('/mandant_api_get_client_permission', array('uses'=>'MandantGUIController@getClientPermission'));

	// add a client device relationship into client_permission table in database
	Route::post('/mandant_api_add_client_permission', array('uses'=>'MandantGUIController@addClientPermission'));

	// edit the client device relationship
	Route::post('/mandant_api_edit_client_permission', array('uses'=>'MandantGUIController@editClientPermission'));

	// delete a client device relationship from client_permission table in database
	Route::post('/mandant_api_del_client_permission', array('uses'=>'MandantGUIController@delClientPermission'));

	// activate a client
	Route::post('/mandant_api_actclient', array('uses'=>'MandantGUIController@actClient'));

	// deactivate a client
	Route::post('/mandant_api_deactclient', array('uses'=>'MandantGUIController@deactClient'));

	// change the password of a client
	Route::post('/mandant_api_change_client', array('uses'=>'MandantGUIController@changeClient'));

	// add a mandant user
	Route::post('/mandant_api_add_user', array('uses'=>'MandantGUIController@addMandantUser'));

	// edit a mandant user
	Route::post('/mandant_api_edit_user', array('uses'=>'MandantGUIController@editMandantUser'));

	// deactive a mandant user
	Route::post('/mandant_api_del_user', array('uses'=>'MandantGUIController@delMandantUser'));

	// get mandant log
	Route::post('/mandant_api_get_mandant_log', array('uses'=>'MandantGUIController@getMandantLog'));
});