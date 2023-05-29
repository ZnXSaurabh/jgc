<?php

use App\Http\Controllers\Api\Admin\JobsApiController;
use App\Http\Controllers\Api\Admin\KFUPMApiController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\ComplianceController;

Route::group(['prefix' => 'v1', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Api\V1\Admin'], function () {
    // Route::apiResource('permissions', 'PermissionsApiController');

    // Route::apiResource('roles', 'RolesApiController');

    // Route::apiResource('users', 'UsersApiController');

    Route::apiResource('countries', 'CountriesApiController');

    // Route::apiResource('jobs', 'JobsApiController');

    Route::apiResource('proposals', 'ProposalsApiController');
});

Route::post('/postjob', [JobsApiController::class, 'store']);

// Route::post('/getJobType', 'Api\Admin\JobsApiController@getJobType');
Route::post('/getJobType', [JobsApiController::class,'getJobType']);

// Route::post('/getDesignation', 'Api\Admin\JobsApiController@getDesignation');
Route::post('/getDesignation', [JobsApiController::class,'getDesignation']);

// Route::post('/getDepartment', 'Api\Admin\JobsApiController@getDepartment');
Route::post('/getDepartment', [JobsApiController::class,'getDepartment']);

// Route::post('/getLocation', 'Api\Admin\JobsApiController@getLocation');
Route::post('/getLocation', [JobsApiController::class,'getLocation']);

// Route::post('/getCandidates', 'Api\Admin\JobsApiController@getCandidates');
Route::post('/getCandidates', [JobsApiController::class,'getCandidates']);

// Route::post('/getJobs', 'Api\Admin\JobsApiController@getJobs');
Route::post('/getJobs', [JobsApiController::class,'getJobs']);

// Route::post('/getAppliedCandidates', 'Api\Admin\JobsApiController@getAppliedCandidates');
Route::post('/getAppliedCandidates', [JobsApiController::class,'getAppliedCandidates']);

// Route::post('/getShortlistCandidates', 'Api\Admin\JobsApiController@getShortlistCandidates');
Route::post('/getShortlistCandidates', [JobsApiController::class,'getShortlistCandidates']);

// Api Created by shubham to get all kfupm user data
Route::post('/getKfupmUsers', [KFUPMApiController::class,'getAllKfupmUser']);
// Route::post('/getKfupmUsers', 'Api\Admin\KFUPMApiController@getAllKfupmUser');

Route::post('/apilogin', [AuthController::class,'login']);
// Route::post('/apilogin', 'Api\Admin\AuthController@login');

Route::middleware('auth:api')->group( function () {
    Route::resource('products', 'App\Http\Controllers\Api\ProductController');
});

// Api for compliance

Route::post('/compliance', [ComplianceController::class,'apply']);
Route::get('/getCompliance/{token}', [ComplianceController::class,'getCompliance']);
Route::post('/registerCompliance/{token}', [ComplianceController::class,'registerCompliance']);




