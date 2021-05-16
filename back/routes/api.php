<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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


/**
 * get allGraphs
 * Summary: Get list of all memebers
 * Notes: 
 */
Route::get('graphs', 'GraphController@allGraphs');


/**
 * post createGraph
 * Summary: Create new graph
 * Notes: 
 */
Route::post('graph', 'GraphController@createGraph');

/**
 * get oneGraph
 * Summary: Get information of a specific graph by ID
 * Notes: 
 */
Route::get('graphs/{id}', 'GraphController@oneGraph');

/**
 * get oneGraph
 * Summary: Get information of a specific graph by ID
 * Notes: 
 */
Route::get('graphs/{id}/statistics', 'GraphController@oneGraphStatistics');


/**
 * put editGraph
 * Summary: Edit a specific graph by ID
 * Notes: 
 */
Route::put('graph/{id}/edit', 'GraphController@editGraph');

/**
 * delete deleteGraph
 * Summary: Delete one graph by ID
 * Notes: 
 */
Route::delete('graph/{id}', 'GraphController@deleteGraph');

/**
 * get oneNode
 * Summary: Show a specific node by id
 * Notes: 
 */
Route::get('node/{id}', 'NodeController@oneNode');


/**
 * post createNode
 * Summary: Create new node inside graph
 * Notes: 
 */
Route::post('node', 'NodeController@createNode');

/**
 * delete deleteNode
 * Summary: Delete one node by ID
 * Notes: 
 */
Route::delete('node/{id}', 'NodeController@deleteNode');
