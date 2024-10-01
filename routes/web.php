<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CustomAuthMiddleware;
use App\Http\Middleware\WebAuthMiddleware;
use App\Http\Middleware\DonorMiddleware;

//Backend

//Login and Authentication
Route::get('/loginbackend', 'App\Http\Controllers\BackendController@login')->name('backend.login');
Route::post('/signinbackend', 'App\Http\Controllers\BackendController@signin')->name('backend.signin');

//Middleware for Backend Section
Route::middleware([CustomAuthMiddleware::class])->group(function () {

    //Dashboard
    Route::get('/dashboard', 'App\Http\Controllers\BackendController@dashboard')->name('backend.dashboard');

    //For Admin
    Route::get('/admin', 'App\Http\Controllers\AdminController@index')->name('backend.admin');
    Route::get('/edit/admin/{id}', 'App\Http\Controllers\AdminController@edit')->name('admin.edit');
    Route::post('/update/admin/{id}', 'App\Http\Controllers\AdminController@update')->name('admin.update');
    Route::get('/delete/admin/{id}', 'App\Http\Controllers\AdminController@delete')->name('admin.delete');
    Route::post('/logoutbackend', 'App\Http\Controllers\BackendController@logout')->name('backend.logout');

    //For WebUsers
    Route::get('/webuser', 'App\Http\Controllers\WebuserController@index')->name('backend.webuser');
    Route::post('/webusernew','App\Http\Controllers\WebuserController@store')->name('webuser.store');
    Route::get('/edit/webuser/{id}', 'App\Http\Controllers\WebuserController@edit')->name('webuser.edit');
    Route::post('/update/webuser/{id}', 'App\Http\Controllers\WebuserController@update')->name('webuser.update');
    Route::get('/delete/webuser/{id}', 'App\Http\Controllers\WebuserController@delete')->name('webuser.delete');
    Route::post('/updatewebuserdetails','App\Http\Controllers\WebuserController@updatewebuserdetails')->name('webuser.updatewebuserdetails');
    Route::post('/resetpasswordbackend','App\Http\Controllers\WebuserController@resetpasswordbackend')->name('webuser.resetpasswordbackend'); //reset for webusers

    //For Bloodcamps
    Route::get('/bloodcamps', 'App\Http\Controllers\BloodcampsController@index')->name('backend.bloodcamps');
    Route::post('/bloodcampsnew','App\Http\Controllers\BloodcampsController@store')->name('bloodcamps.store');
    Route::get('/edit/bloodcamps/{id}', 'App\Http\Controllers\BloodcampsController@edit')->name('bloodcamps.edit');
    Route::post('/update/bloodcamps/{id}', 'App\Http\Controllers\BloodcampsController@update')->name('bloodcamps.update');
    Route::get('/delete/bloodcamps/{id}', 'App\Http\Controllers\BloodcampsController@delete')->name('bloodcamps.delete');
    Route::post('/bloodcamps/updateparticipants', 'App\Http\Controllers\BloodcampsController@updateparticipants')->name('bloodcamp.updateparticipants');
    Route::post('/downloadparticipantspdf','App\Http\Controllers\BloodcampsController@pdfbdcamps')->name('frontend.downloadparticipantspdf'); //downloadPdf

    //For Roles
    Route::get('/roles', 'App\Http\Controllers\RolesController@index')->name('backend.roles');
    Route::post('/roles','App\Http\Controllers\RolesController@store')->name('roles.store');
    Route::get('/edit/roles/{id}', 'App\Http\Controllers\RolesController@edit')->name('roles.edit');
    Route::post('/update/roles/{id}', 'App\Http\Controllers\RolesController@update')->name('roles.update');
    Route::get('/delete/roles/{id}', 'App\Http\Controllers\RolesController@delete')->name('roles.delete');

    //For Permissions
    Route::get('/permissions', 'App\Http\Controllers\PermissionsController@index')->name('backend.permissions');
    Route::post('/permissions','App\Http\Controllers\PermissionsController@store')->name('permissions.store');
    Route::get('/edit/permissions/{id}', 'App\Http\Controllers\PermissionsController@edit')->name('permissions.edit');
    Route::post('/update/permissions/{id}', 'App\Http\Controllers\PermissionsController@update')->name('permissions.update');
    Route::get('/delete/permissions/{id}', 'App\Http\Controllers\PermissionsController@delete')->name('permissions.delete');

    //For Blood Request
    Route::get('/bloodreq', 'App\Http\Controllers\BloodreqController@index')->name('backend.bloodreq');
    Route::post('/bloodreqnew','App\Http\Controllers\BloodreqController@store')->name('bloodreq.store');
    Route::get('/edit/bloodreq/{id}', 'App\Http\Controllers\BloodreqController@edit')->name('bloodreq.edit');
    Route::post('/update/bloodreq/{id}', 'App\Http\Controllers\BloodreqController@update')->name('bloodreq.update');
    Route::get('/delete/bloodreq/{id}', 'App\Http\Controllers\BloodreqController@delete')->name('bloodreq.delete');
    Route::post('/update-status', 'App\Http\Controllers\BloodreqController@updateStatus')->name('update.status'); //Ajax to update status
    Route::post('/update-carousel', 'App\Http\Controllers\BloodreqController@updateCarousel')->name('update.carousel'); //Ajax to update carousel
    Route::post('/bloodreq/{bloodreqId}/update_donors', 'App\Http\Controllers\BloodreqController@updateDonors')->name('update_donors');
    Route::post('/downloadpdf','App\Http\Controllers\BloodreqController@downloadPdf')->name('frontend.downloadpdf'); //downloadPdf

});

//Frontend Section for all webusers
Route::get('/', 'App\Http\Controllers\FrontendController@index')->name('frontend.index');
Route::get('/about', 'App\Http\Controllers\FrontendController@about')->name('frontend.about');
Route::get('/activereq', 'App\Http\Controllers\FrontendController@activereq')->name('frontend.activereq');
Route::get('/bdcamps', 'App\Http\Controllers\FrontendController@bdcamps')->name('frontend.bdcamps');
Route::get('/search','App\Http\Controllers\FrontendController@search')->name('frontend.search'); //search for requests

//To see the posts of the active requests & bdcamps
Route::get('/bloodreq/{slug}','App\Http\Controllers\FrontendController@activereqslug')->name('frontend.reqslug');
Route::get('/bdcamps/{slug}','App\Http\Controllers\FrontendController@bdcampslug')->name('frontend.bdcampslug');
Route::get('/redirectback', 'App\Http\Controllers\FrontendController@redirectback')->name('redirectback'); //redirect back to home

//For Webuser Authentication Frontend Side
Route::get('/webuserlogin','App\Http\Controllers\WebuserController@login')->name('frontend.webuserlogin'); //login page
Route::post('/webusersignin','App\Http\Controllers\WebuserController@signin')->name('frontend.webusersignin'); //auth webuser
Route::post('/webusersignup','App\Http\Controllers\WebuserController@signup')->name('frontend.webusersignup'); //signup
Route::post('/webuserphonesignin','App\Http\Controllers\WebuserController@phonesignin')->name('frontend.webphonesignin'); //signin using phone

//SMS Authentication
Route::post('/sendsms','App\Http\Controllers\WebuserController@sendsms')->name('frontend.phone'); //send sms for sign-up
Route::post('/sendotp', 'App\Http\Controllers\WebuserController@sendotp')->name('frontend.sendotp'); //send otp for login

//Forgot password
Route::post('/forgotpass','App\Http\Controllers\FrontendController@forgotpass')->name('frontend.forgotpass'); //forgot password for login users
Route::get('/resetpassforgot','App\Http\Controllers\FrontendController@resetpassforgot')->name('frontend.resetpassforgot'); //reset pass for forgotten user page load in email
Route::post('/resetpassforgotstore','App\Http\Controllers\FrontendController@resetpassforgotstore')->name('frontend.resetpassforgotstore'); //submit reset pass for forgottenuser

//Middleware to give permission for requests to only authenticated users
Route::middleware([WebAuthMiddleware::class])->group(function () {

    //Logout from the site for all webusers
    Route::post('/webuserlogout','App\Http\Controllers\WebuserController@logout')->name('frontend.webuserlogout'); //logout

    //As every authenticated user must have one profile ( hasOne or one-to-one relationship )
    Route::get('/userprofile','App\Http\Controllers\ProfileController@profile')->name('frontend.webuserprofile'); //profile page
    Route::post('/updateprofiledetails', 'App\Http\Controllers\ProfileController@updateprofiledetails')->name('webuser.updatedetails'); //Edit profile details

    //Authenticated user can add blood requests
    Route::post('/addblood','App\Http\Controllers\BloodreqController@addblood')->name('frontend.addblood'); //Add blood reqs

    //To become a donor, one must fill details and change roles from authenticated user to donor
    Route::post('/adddetails','App\Http\Controllers\ProfileController@profileinsert')->name('frontend.adddetails'); //add donor details
    Route::post('/webuserresetpassword','App\Http\Controllers\ProfileController@resetpassword')->name('frontend.resetpassword'); //reset for auth and donor webuser
    Route::post('/seerequestspdf', 'App\Http\Controllers\ProfileController@seerequestspdf')->name('frontend.seerequestspdf'); //To download pdf of all the requests made by the donor/auth_user

    //Nesting Middleware to give permission for requests to only authenticated users with role as Donor
    Route::middleware([DonorMiddleware::class])->group(function () {
        //Donor can participate in blood camps
        Route::post('/participate', 'App\Http\Controllers\FrontendController@participate')->name('frontend.participate'); //participate as a donor in bdcamps
        //Donors details can be edited and saved
        Route::post('/updatedonordetails', 'App\Http\Controllers\ProfileController@updatedonordetails')->name('webuser.updatedonordetails'); //Edit Donor details
        //Check all the requests a donor has volunteered for
        Route::post('/seedonorspdf', 'App\Http\Controllers\ProfileController@seedonorspdf')->name('frontend.seedonorspdf'); //To download pdf of all the donors of the requests made
        //As a donor can give his/her details to a blood req
        Route::post('/senddonordetails','App\Http\Controllers\BloodreqController@senddonordetails')->name('frontend.senddonordetails'); //sending help to the patient
    });

});
