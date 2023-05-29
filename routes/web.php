<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Common\KfupmController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Common\CandidateController;
use App\Http\Controllers\Common\JobController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\HRManagerController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\JobTypeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\EducationalLevelController;
use App\Http\Controllers\Admin\KfupmUserController;
use App\Http\Controllers\Admin\HrController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;


Auth::routes();

Auth::routes(['verify' => true]);



Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/', 'HomeController@index')->name('home');

// Route::post('filter-home-job', 'HomeController@filterHomeJobs')->name('filter-home-job');
Route::post('/filter-home-job', [HomeController::class, 'filterHomeJobs'])->name('filter-home-job');;


// Route::post('filter-job', 'HomeController@filterJobs')->name('filter-job');
Route::post('filter-job', [HomeController::class, 'filterJobs'])->name('filter-job');

// Route::get('browse-jobs', 'HomeController@browseJobs')->name('browse-jobs');
Route::get('browse-jobs', [HomeController::class, 'browseJobs'])->name('browse-jobs');


// kfupm register form routes made by shubham semwal

// Route::post('kfupmregister', 'KfupmController@saveData')->name('kfupmregister-save');
// Route::post('kfupmregister', [KfupmController::class, 'saveData']);

// Route::get('kfupmregister', 'KfupmController@register')->name('kfupmregister');
// Route::get('kfupmregister', [KfupmController::class, 'register']);

Route::match(['get', 'post'], 'kfupmregister', [
    'get' => [KfupmController::class, 'register'],
    'post' => [KfupmController::class, 'saveData']
])->name('kfupmregister');

// kfupm register form routes made by shubham semwal end.



// Route::post('filter_registrationdate','KfupmController@filter_registrationdate')->name('filter_registrationdate');
// Route::post('filter_registrationdate', [KfupmController::class, 'filter_registrationdate']);

// Route::post('filter_registrationdate','KfupmController@filter_registrationdate')->name('filter_registrationdate');
Route::post('filter_registrationdate',[KfupmController::class, 'filter_registrationdate'])->name('filter_registrationdate');

// Route::post('search-location', 'HomeController@searchLocation')->name('search-location');
Route::post('search-location', [HomeController::class, 'searchLocation'])->name('search-location');

// Route::post('search-location-browse','HomeController@searchLocationBrowse')->name('search-location-browse');
Route::post('search-location-browse', [HomeController::class, 'searchLocationBrowse'])->name('search-location-browse');



// Route::get('/login_link/{token}', 'Auth\LoginController@authenticate');
Route::get('/login_link/{token}', [LoginController::class, 'authenticate']);

// Route::post('/login_link', 'Auth\LoginController@sendToken')->name('login_link');
Route::post('/login_link', [LoginController::class, 'sendToken'])->name('login_link');



// Route::post('email_exist','Common\CandidateController@email_exist');
Route::post('email_exist', [CandidateController::class, 'email_exist']);

// Route::get('job_detail/{id}', 'HomeController@show')->name('job_detail');
Route::get('job_detail/{id}', [HomeController::class, 'show'])->name('job_detail');

// Route::get('applied_job/{id}', 'Common\JobController@AppliedJob')->name('applied_job');
Route::get('applied_job/{id}', [JobController::class, 'AppliedJob'])->name('applied_job');



// Route::post('/resend_email','Auth\RegisterController@resendEmail');
Route::post('/resend_email', [RegisterController::class, 'resendEmail']);

// Route::post('/resend_login_email','Auth\RegisterController@resendLoginEmail');
Route::post('/resend_login_email', [RegisterController::class, 'resendLoginEmail']);



Route::group(['prefix' => 'common', 'as' => 'common.', 'namespace' => 'App\Http\Controllers\Common', 'middleware' => ['roles:Admin,Candidate,Vendor']], function (){



    Route::resource('candidate', 'CandidateController');

    Route::get('vendors_candidates_show/{id}','CandidateController@vendors_candidates_show')->name('vendors_candidates_show');

    Route::get('candidateEdit/{id}','CandidateController@candidateEdit')->name('candidateEdit');

    Route::post('candidateUpdate/{id}','CandidateController@candidateUpdate')->name('candidateUpdate');

    Route::get('candidateDestroy/{id}','CandidateController@candidateDestroy')->name('candidateDestroy');

    Route::get('candidate-profile', 'CandidateController@showProfile')->name('candidate-profile');  

    // Route::get('edit-profile/{id}', 'CandidateController@edit')->name('edit-profile');

    Route::post('update_education', 'CandidateController@update_education')->name('update_education');

    Route::post('update_experience', 'CandidateController@update_experience')->name('update_experience');

    Route::post('update_candidate_profile', 'CandidateController@update')->name('update_candidate_profile');

    Route::get('applied_jobs_by_candidate', 'CandidateController@show_applied_job')->name('applied_jobs_by_candidate');



    Route::post('filterAppliedCandidate','JobController@filterAppliedCandidate')->name('filterAppliedCandidate');

    Route::post('filter_candidates','CandidateController@filter_candidates')->name('filter_candidates');

    Route::post('filter_by_exp','CandidateController@filter_by_exp')->name('filter_by_exp');

    Route::post('filter_by_age','CandidateController@filter_by_age')->name('filter_by_age');

   // Route::get('kfupm_user-export', 'KfupmController@export')->name('kfupm_user-export');  

    

    Route::post('filter_kfupm_users','KfupmController@filter_kfupm_users')->name('filter_kfupm_users');

    Route::post('filter_by_major','KfupmController@filter_by_major')->name('filter_by_major');

    Route::post('filter_by_degree','KfupmController@filter_by_degree')->name('filter_by_degree');

    Route::post('applied_filter_by_age','JobController@applied_filter_by_age')->name('applied_filter_by_age');

    Route::post('applied_filter_by_exp','JobController@applied_filter_by_exp')->name('applied_filter_by_exp');

    Route::post('shortlist_filter_by_age','JobController@shortlist_filter_by_age')->name('shortlist_filter_by_age');

    Route::post('shortlist_filter_by_exp','JobController@shortlist_filter_by_exp')->name('shortlist_filter_by_exp');

    Route::post('notapplied_filter_by_age','JobController@notapplied_filter_by_age')->name('notapplied_filter_by_age');

    Route::post('notapplied_filter_by_exp','JobController@notapplied_filter_by_exp')->name('notapplied_filter_by_exp');

    

    

});

//Admin,Vendor,HR common routes

Route::group(['prefix' => 'common', 'as' => 'common.', 'middleware' => ['roles:Admin,Super Admin,HR,Vendor,HR Manager']], function (){



    // Route::get('dashboard', 'Admin\AdminController@index')->name('dashboard');
    Route::get('dashboard',[AdminController::class, 'index'])->name('dashboard');



    // Route::resource('jobs', 'Common\JobController');
    Route::resource('jobs', JobController::class);

    

    // Route::get('show_expired_job','Common\JobController@show_expired_job')->name('show_expired_job');

    // Route::get('approved_jobs','Common\JobController@approved_jobs')->name('approved_jobs');

    // Route::get('unapproved_jobs','Common\JobController@unapproved_jobs')->name('unapproved_jobs');



    //short listed candidate

    // Route::get('shortlist/{id}', 'Common\JobController@ShortlistJob')->name('shortlist');

    // Route::get('unshortlist/{id}', 'Common\JobController@UnShortlistJob')->name('unshortlist');

    // Route::get('view-profile/{id}', 'Common\JobController@ViewProfile')->name('view-profile');



    // Route::get('get-vendor/{id}','Admin\VendorController@getShowVendor')->name('get-vendor');

    // Route::post('job_apply_by_vendor/{id}', 'Common\JobController@job_apply_by_vendor')->name('job_apply_by_vendor');

        Route::get('show_expired_job',[JobController::class, 'show_expired_job'])->name('show_expired_job');

        Route::get('approved_jobs',[JobController::class, 'approved_jobs'])->name('approved_jobs');
    
        Route::get('unapproved_jobs',[JobController::class, 'unapproved_jobs'])->name('unapproved_jobs');
    
    
    
        //short listed candidate
    
        Route::get('shortlist/{id}', [JobController::class, 'ShortlistJob'])->name('shortlist');
    
        Route::get('unshortlist/{id}', [JobController::class, 'UnShortlistJob'])->name('unshortlist');
    
        Route::get('view-profile/{id}', [JobController::class, 'ViewProfile'])->name('view');
    
        Route::get('get-vendor/{id}',[VendorController::class, 'getShowVendor'])->name('get');
    
        Route::post('job_apply_by_vendor/{id}', [JobController::class, 'job_apply_by_vendor'])->name('job_apply_by_vendor');

});



Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['roles:Admin,Super Admin']], function (){

    
    Route::resource('locations', 'LocationController');

    //job_type Routes made by vineet sharma

    Route::resource('job_type', 'JobTypeController');

    //department Routes made by vineet sharma

    Route::resource('department', 'DepartmentController');

    //designation Routes made by vineet sharma  

    Route::resource('designation', 'DesignationController');

    //EducationalLevel Routes made by vineet sharma

    Route::resource('educational_level', 'EducationalLevelController');

    //Kfupm Users routes made by shubham semwal

    Route::resource('kfupm_user', 'KfupmUserController');

    //Vendor Routes

    Route::resource('vendor', 'VendorController');

    //HR routes

    Route::resource('hr', 'HrController');

    //HR Manager Routes

    Route::resource('hr_manager', 'HRManagerController');

});



Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['roles:Super Admin']], function (){



    Route::resource('permissions', 'PermissionsController');

    Route::resource('roles', 'RolesController');



});

Route::group(['prefix' => 'hr_manager', 'as' => 'hr_manager.', 'namespace' => 'App\Http\Controllers\Admin','middleware' => ['roles:HR Manager']], function () {    

    // Route::get('dashboard', 'HRManagerController@index')->name('dashboard');

    Route::get('job_approve/{id}','HRManagerController@job_approve')->name('job_approve');
    // Route::get('job_approve/{id}', [HRManagerController::class, 'job_approve'])->name('job_approve');

});
