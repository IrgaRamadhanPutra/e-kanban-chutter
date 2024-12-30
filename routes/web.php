<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route::get('home', function () {
//     return view('welcome');
// });
// Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index');
    Route::get('/index_chuter2_Abnormality', 'HomeController@index_chuter2_Abnormality')->name('index_chuter2_Abnormality');
    Route::get('/index_chuter2_All', 'HomeController@index_chuter2_All')->name('index_chuter2_All');
    Route::get('/index_chuter1_Abnormality', 'HomeController@index_chuter1_Abnormality')->name('index_chuter1_Abnormality');
    Route::get('/index_chuter1_All', 'HomeController@index_chuter1_All')->name('index_chuter1_All');

    // ScaninChutter
    Route::get('/indexinchutter', 'ScanInChutterController@index')->name('scaninchutter');
    // string 7
    Route::get('/validasi_access_account', 'ScanInChutterController@validasi_access_account')->name('validasi_access_account');
    Route::get('/validasi_access_account2', 'ScanInChutterController@validasi_access_account2')->name('validasi_access_account2');
    Route::get('/validasi_itemcode', 'ScanInChutterController@validasi_itemcode')->name('validasi_itemcode');
    Route::get('/validasi_fgout1', 'ScanInChutterController@validasi_fgout1')->name('validasi_fgout1');
    Route::get('/validasi_fgin1', 'ScanInChutterController@validasi_fgin1')->name('validasi_fgin1');
    Route::get('/validasi_inchuter', 'ScanInChutterController@validasi_inchuter')->name('validasi_inchuter');
    Route::get('/validasi_chuteraddress', 'ScanInChutterController@validasi_chuteraddress')->name('validasi_chuteraddress');
    Route::get('/validasi_max_chuter', 'ScanInChutterController@validasi_max_chuter')->name('validasi_max_chuter');
    Route::get('/validasi_overflow', 'ScanInChutterController@validasi_overflow')->name('validasi_overflow');
    Route::get('/validasi_date', 'ScanInChutterController@validasi_date')->name('validasi_date');
    // string 8 hold dluu
    Route::get('/validasi_fgout2', 'ScanInChutterController@validasi_fgout2')->name('validasi_fgout2');
    Route::get('/validasi_fgin2', 'ScanInChutterController@validasi_fgin2')->name('validasi_fgin2');
    Route::get('/validasi_fgin3', 'ScanInChutterController@validasi_fgin3')->name('validasi_fgin3');
    Route::get('/validasi_date1', 'ScanInChutterController@validasi_date1')->name('validasi_date1');
    Route::get('/get_chutterinput2', 'ScanInChutterController@get_chutterinput2')->name('get_chutterinput2');
    //  add chuter addres
    Route::post('/add_chutteraddress', 'ScanInChutterController@add_chutteraddress')->name('add_chutteraddress');

    // ScanoutChutter
    Route::get('/indexoutchutter', 'ScanOutChutterController@index')->name('scanoutchutter');
    Route::get('/validasi_access_account3', 'ScanOutChutterController@validasi_access_account3')->name('validasi_access_account3');
    Route::get('/validasi_access_account4', 'ScanOutChutterController@validasi_access_account4')->name('validasi_access_account4');
    Route::get('/validasi_itemcode_fgout', 'ScanOutChutterController@validasi_itemcode_fgout')->name('validasi_itemcode_fgout');
    Route::get('/validasi_itemcode_fgout', 'ScanOutChutterController@validasi_itemcode_fgout')->name('validasi_itemcode_fgout');
    Route::get('/validasi_chuterr_address', 'ScanOutChutterController@validasi_chuterr_address')->name('validasi_chuterr_address');
    Route::get('/validasi_fifo_lokal', 'ScanOutChutterController@validasi_fifo_lokal')->name('validasi_fifo_lokal');
    Route::get('/validasi_itemcode_fgout1', 'ScanOutChutterController@validasi_itemcode_fgout1')->name('validasi_itemcode_fgout1');
    Route::get('/validasi_chuterr_address1', 'ScanOutChutterController@validasi_chuterr_address1')->name('validasi_chuterr_address1');
    Route::get('/validasi_fifo_lokal1', 'ScanOutChutterController@validasi_fifo_lokal1')->name('validasi_fifo_lokal1');
    Route::get('/validasi_itemcode_fgout2', 'ScanOutChutterController@validasi_itemcode_fgout2')->name('validasi_itemcode_fgout2');
    Route::get('/validasi_chuterr_address2', 'ScanOutChutterController@validasi_chuterr_address2')->name('validasi_chuterr_address2');
    Route::get('/validasi_fifo_lokal2', 'ScanOutChutterController@validasi_fifo_lokal2')->name('validasi_fifo_lokal2');

    // for string 8 adm
    Route::get('/validasi_itemcode_fgoutadm', 'ScanOutChutterController@validasi_itemcode_fgoutadm')->name('validasi_itemcode_fgoutadm');
    Route::get('/validasi_chuterr_addressadm', 'ScanOutChutterController@validasi_chuterr_addressadm')->name('validasi_chuterr_addressadm');
    Route::get('/validasi_fifo_lokaladm', 'ScanOutChutterController@validasi_fifo_lokaladm')->name('validasi_fifo_lokaladm');

    Route::get('/validasi_itemcode_fgout4', 'ScanOutChutterController@validasi_itemcode_fgout4')->name('validasi_itemcode_fgout4');
    Route::get('/validasi_chuterr_address3', 'ScanOutChutterController@validasi_chuterr_address3')->name('validasi_chuterr_address3');
    Route::get('/validasi_fifo_lokal3', 'ScanOutChutterController@validasi_fifo_lokal3')->name('validasi_fifo_lokal3');
    //  // for string 8 adm
    Route::get('/validasi_itemcode_fgoutadm1', 'ScanOutChutterController@validasi_itemcode_fgoutadm1')->name('validasi_itemcode_fgoutadm1');
    Route::get('/validasi_chuterr_addressadm1', 'ScanOutChutterController@validasi_chuterr_addressadm1')->name('validasi_chuterr_addressadm1');
    Route::get('/validasi_fifo_lokaladm1', 'ScanOutChutterController@validasi_fifo_lokaladm1')->name('validasi_fifo_lokaladm1');
    Route::get('/getChutter', 'ScanOutChutterController@getChutter')->name('getChutter');
    Route::post('/add_ekanbanChuterout', 'ScanOutChutterController@add_ekanbanChuterout')->name('add_ekanbanChuterout');

    // Scan in Overflow
    Route::get('/indexinoverflow', 'ScanInOverflowController@index')->name('scaninoveflow');
    Route::get('/validasi_itemcode_fgin', 'ScanInOverflowController@validasi_itemcode_fgin')->name('validasi_itemcode_fgin');
    Route::post('/add_overflow', 'ScanInOverflowController@add_overflow')->name('add_overflow');

    // scan out overflow
    Route::get('/indexoutoverflow', 'ScanOutOverflowController@index')->name('scanoutoverflow');
    Route::get('/validasi_data_overflow', 'ScanOutOverflowController@validasi_data_overflow')->name('validasi_data_overflow');
    Route::get('/validasi_data_out_overflow', 'ScanOutOverflowController@validasi_data_out_overflow')->name('validasi_data_out_overflow');
    Route::get('/validasi_fifo_out_overflow', 'ScanOutOverflowController@validasi_fifo_out_overflow')->name('validasi_fifo_out_overflow');
    Route::post('/add_out_overflow', 'ScanOutOverflowController@add_out_overflow')->name('add_out_overflow');
});
// Tampilkan form login kustom
Route::get('/login', 'CustomLoginController@showLoginForm');

// Proses login kustom
Route::post('/login', 'CustomLoginController@login')->name('login');

// Logout kustom
Route::post('/logout', 'CustomLoginController@logout')->name('logout');
