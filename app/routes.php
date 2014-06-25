<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Backend
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'backend_theme|auth.sentry|password-expiry'), function()
{
	/* Khusus Internal API */
	Route::group(array('prefix' => 'rest'), function()
	{
		AvelcaController::autoRoutes();
	});

	/* Route Sisanya */
	Route::group(array('before' => 'check_permission'), function()
	{
		/* Dashboard tidak perlu Prefix Admin krn bisa untuk beberapa Role */
		Route::get('dashboard', 'DashboardController@getIndex');
		
		/*Route::get('admin/report/best-seller-product', 'ReportController@getIndex');*/
		
		Route::group(array('prefix' => 'admin'), function()
		{
			AvelcaController::autoRoutes();
		});
	});
});


/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => LaravelLocalization::setLocale(), 'before' => 'frontend_theme'), function()
{
	Route::get('/', function(){
		return Redirect::to('signin');
	});

	// Route::get('/', 'HomeController@getIndex');
});
