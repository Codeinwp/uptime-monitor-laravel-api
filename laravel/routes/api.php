<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

Route::get('/monitor', function() {
	// If the Content-Type and Accept headers are set to 'application/json',
	// this will return a JSON structure. This will be cleaned up later.

	$exitCode = Artisan::call( "monitor:status", [ '--api' => true ] );
	return Artisan::output();
});

Route::get('/monitor/create', function () {
	abort(404);
});
Route::get('/monitor/remove', function () {
	abort(404);
});

Route::post('/monitor/create', function() {
	// If the Content-Type and Accept headers are set to 'application/json',
	// this will return a JSON structure. This will be cleaned up later.

	$url = ( isset( $_POST['url'] ) ) ? $_POST['url'] : '';
	$email = ( isset( $_POST['email'] ) ) ? $_POST['email'] : '';

	$decoded_url = urldecode ( $url );

	$exitCode = Artisan::call( "monitor:create", [ 'url' => $decoded_url, '--api' => true, '--email' => $email ] );
	return Artisan::output();
});

Route::get('/monitor/confirm', function() {
	// If the Content-Type and Accept headers are set to 'application/json',
	// this will return a JSON structure. This will be cleaned up later.

	$token = ( isset( $_GET['token'] ) ) ? $_GET['token'] : '';
	if( $token === '' ) abort(404);
	$exitCode = Artisan::call( "monitor:confirm-token", [ '--api' => true, '--token' => $token ] );
	return view('confirm', ['message' => Artisan::output()]);
});

Route::post('/monitor/remove', function() {
	// If the Content-Type and Accept headers are set to 'application/json',
	// this will return a JSON structure. This will be cleaned up later.

	$url = ( isset( $_POST['url'] ) ) ? $_POST['url'] : '';

	$decoded_url = urldecode ( $url ); 
	$exitCode = Artisan::call( "monitor:delete", [ 'url' => $decoded_url, '--api' => true ] );
	return Artisan::output();
});