<?php

use App\Http\Controllers\generalAffair;
use App\Http\Controllers\pn_05_logistik_controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', function () {
    return view('index');
})->name('home');

// Search for register
Route::get('/search','usersController@search')->name('search');
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', 'dashboardController@index')->name('dashboard');
    Route::get('/getDatakategori', 'dashboardController@getDatakategori')->name('getDatakategori');
    Route::get('/getDatadaily', 'dashboardController@getDatadaily')->name('getDatadaily');
    Route::get('/getDatastatus', 'dashboardController@getDatastatus')->name('getDatastatus');
    Route::get('/getDataduration', 'dashboardController@getDataduration')->name('getDataduration');

    // Download file setup
    Route::get('/download/{file}', 'DownloadController@download')->name('download_file');

    // Master Barang EDP
    Route::get('/barang/list','b_01_masterBarangController@index')->name('edp_master_barang');
    // Pinjam barang



    // Untuk Form Software Request
    Route::get('/form/software/request', 'SoftwareReqController@index')->name('soft_req_index');
    Route::get('/form/software/request-create', 'SoftwareReqController@create')->name('soft_req_create');
    Route::get('/form/software/request-edit/{id}', 'SoftwareReqController@edit')->name('soft_req_edit');
    Route::get('/form/software/request-delete/{id}', 'SoftwareReqController@destroy')->name('soft_req_delete');
    Route::get('/form/software/request-print/{id}', 'SoftwareReqController@print')->name('soft_req_print');
    Route::post('/form/software/request-update', 'SoftwareReqController@update')->name('soft_req_update');
    Route::get('/form/software/request/export','SoftwareReqController@export')->name('soft_req_export');

    // Untuk Template Hardware PC
    Route::get('/form/hardware/template','TemplateController@index' )->name('template_index');
    Route::get('/form/hardware/template-create','TemplateController@create' )->name('template_create');
    Route::post('/form/hardware/template-update','TemplateController@update' )->name('template_update');
    Route::get('/form/hardware/template-data', 'TemplateController@template_data')->name('template_data');

    // Untuk Form Hardware Request
    Route::get('/form/hardware/request','HardwareReqController@index' )->name('hard_req_index');
    Route::get('/form/hardware/request-create','HardwareReqController@create' )->name('hard_req_create');
    Route::get('/form/hardware/request-edit/{id}', 'HardwareReqController@edit')->name('hard_req_edit');
    Route::get('/form/hardware/request-delete/{id}', 'HardwareReqController@destroy')->name('hard_req_delete');
    Route::post('/form/hardware/request-update','HardwareReqController@update' )->name('hard_req_update');
    Route::get('/form/hardware/request-data','HardwareReqController@showData' )->name('hard_req_data');
    Route::get('/form/hardware/request-print/{id}', 'HardwareReqController@print')->name('hard_req_print');
    Route::get('/form/hardware/request/export','HardwareReqController@export')->name('hard_req_export');

    // Untuk Form Hardware Fix
    Route::get('/form/hardware/fix', 'HardwareFixController@index')->name('hard_fix_index');
    Route::get('/form/hardware/fix-export', 'HardwareFixController@export')->name('hard_fix_report');
    Route::get('/form/hardware/fix-create', 'HardwareFixController@create')->name('hard_fix_create');
    Route::get('/form/hardware/del-all/{id}', 'HardwareFixController@destroy')->name('hard_fix_delete');
    Route::post('/form/hardware/fix-update', 'HardwareFixController@update')->name('hard_fix_update');
    Route::get('/form/hardware/fix-edit/{id}', 'HardwareFixController@edit')->name('hard_fix_edit');
    Route::get('/form/hardware/del-det/{id}', 'HardwareFixController@del_det')->name('hard_fix_del_det');
    Route::get('/form/hardware/fix-print/{id}', 'HardwareFixController@print')->name('hard_fix_print');
    Route::get('/form/hardware/fix/export','HardwareFixController@export')->name('hard_fix_export');

    // Untuk Inventaris Laptop
    Route::get('/inventaris/laptop', 'LaptopController@index')->name('laptop_index');
    Route::get('/inventaris/laptop-create', 'LaptopController@create')->name('laptop_create');
    Route::post('inventaris/laptop/update', 'LaptopController@update')->name('laptop_update');
    Route::get('/inventaris/laptop/edit/{id}', 'LaptopController@edit')->name('laptop_edit');
    Route::get('/inventaris/laptop/del/{id}', 'LaptopController@destroy')->name('laptop_del');
    Route::get('/inventaris/laptop_qr/{id}', 'LaptopController@qr_generator')->name('laptop_qr');
    Route::get('/inventaris/laptop/report/{id}', 'LaptopController@report')->name('laptop_report');

    // Untuk Inventaris PC
    Route::get('/inventaris/pc', 'PcController@index')->name('pc_index');
    Route::get('/inventaris/pc-create', 'PcController@create')->name('pc_create');
    Route::post('/inventaris/pc-update', 'PcController@update')->name('pc_update');
    Route::get('/inventaris/pc-edit/{id}', 'PcController@edit')->name('pc_edit');
    Route::get('/inventaris/pc-del/{id}', 'PcController@destroy')->name('pc_del');
    Route::get('/inventaris/pc_qr/{id}', 'PcController@qr_pc_generator')->name('pc_qr');
    Route::get('/inventaris/pc/report/{id}', 'PcController@report')->name('pc_report');
    Route::get('/inventaris/pc/export','PcController@export')->name('pc_export');


    // Inventaris Monitor
    Route::get('/inventaris/monitor','monitorController@index')->name('monitor_index');
    Route::get('/inventaris/monitor-create','monitorController@create')->name('monitor_create');
    Route::post('/inventaris/monitor-store','monitorController@store')->name('monitor_store');
    Route::get('/inventaris/monitor-{id}','monitorController@edit')->name('monitor_edit');
    Route::post('/inventaris/monitor-update','monitorController@update')->name('monitor_update');
    Route::get('/inventaris/monitor/d/{id}','monitorController@destroy')->name('monitor_destroy');
    Route::get('/inventaris/monitor/export','monitorController@export')->name('monitor_export');
    Route::post('/inventaris/monitor/import','monitorController@import')->name('monitor_import');
    // Untuk Inventaris Printer
    Route::get('/inventaris/printer', 'PrinterController@index')->name('printer_index');
    Route::get('/inventaris/printer-create', 'PrinterController@create')->name('printer_create');
    Route::get('/inventaris/printer-edit/{id}', 'PrinterController@edit')->name('printer_edit');

    Route::get('/inventaris/printer-ink/{id}', 'PrinterController@printer_ink')->name('printer_ink');
    Route::get('/inventaris/printer-report/{id}', 'PrinterController@report')->name('printer_report');
    Route::get('/inventaris/printer-del/{id}', 'PrinterController@destroy')->name('printer_del');
    Route::post('/inventaris/printer-update', 'PrinterController@update')->name('printer_update');

    // Untuk Inventaris Tinta
    Route::get('/inventaris/ink','InkController@index')->name('ink_index');
    Route::post('/inventaris/ink-update','InkController@update')->name('ink_update');
    Route::get('/inventaris/ink-create', 'InkController@create')->name('ink_create');
    Route::get('/inventaris/ink-report', 'InkController@report')->name('ink_report');
    Route::get('/inventaris/ink-request/{id}', 'InkController@ink_request')->name('ink_request');
    Route::get('/inventaris/ink-edit/{id}', 'InkController@edit')->name('ink_edit');
    Route::get('/inventaris/ink-delete/{id}', 'InkController@destroy')->name('ink_del');
    Route::get('/inventaris/ink-data', 'InkController@getData')->name('ink_getData');
    Route::get('/inventaris/ink-data/show', 'InkController@showink')->name('ink_data');

    // Halaman Request
    Route::get('/dashboard/request','RequestViewController@index')->name('request');
    Route::get('/dashboard/request_ink','RequestViewController@index_ink')->name('request_ink');
    Route::get('/dashboard/request/acc_ink/{id}', 'RequestViewController@ink_req')->name('ink_req_acc');
    Route::get('/dashboard/request/dec_ink/{id}/{ink}/{qty}', 'RequestViewController@ink_dec')->name('ink_req_dec');
    Route::get('/dashboard/request/acc_soft/{id}', 'RequestViewController@soft_req')->name('soft_req_acc');
    Route::get('/dashboard/request/acc_hard/{id}', 'RequestViewController@hard_req')->name('hard_req_acc');
    Route::get('/dashboard/request/acc_hard_fix/{id}', 'RequestViewController@hard_fix')->name('hard_fix_acc');
    // Route::get('/home','HomeController@index')->name('home');

    // Halaman User
    Route::get('/dashboard/users','usersController@index')->name('users.index');
    Route::post('/dashboard/users/update','usersController@edit')->name('users.update');
    Route::get('/dashboard/users/{id}','usersController@view')->name('users.view');
    Route::get('/dashboard/users/delete/{email}','usersController@destroy')->name('users.delete');



    // Halaman Divisi
    Route::get('/dashboard/divisi','divisiController@index')->name('divisi.index');
    Route::post('/dashboard/divisi/create','divisiController@create')->name('divisi.create');
    Route::post('/dashboard/divisi/update','divisiController@edit')->name('divisi.update');
    Route::get('/dashboard/divisi/{id}','divisiController@view')->name('divisi.view');
    Route::get('/dashboard/divisi/delete/{email}','divisiController@delete')->name('divisi.delete');
    Route::get('/dashboard/divisi','divisiController@index')->name('divisi.index');

    // Lokasi
    Route::post('/dashboard/lokasi/create','lokasiController@create')->name('lokasi.create');
    Route::post('/dashboard/lokasi/update','lokasiController@edit')->name('lokasi.update');
    Route::get('/dashboard/lokasi/{id}','lokasiController@view')->name('lokasi.view');
    Route::get('/dashboard/lokasi/delete/{id}','lokasiController@delete')->name('lokasi.delete');
    Route::get('/dashboard/lokasi','lokasiController@index')->name('lokasi.index');


    // Import and Export
    Route::get('/inventaris/pc/import','PcController@importView')->name('pc_import_view');
    Route::post('/inventaris/pc/import-acc','PcController@import')->name('pc_import');
    Route::get('/inventaris/laptop/import','LaptopController@importView')->name('laptop_import_view');
    Route::post('/inventaris/laptop/laptop-acc','LaptopController@import')->name('laptop_import');



    // Test
    Route::get('/test','testController@index');
    Route::get('/chart','testController@chart');
    Route::get('/GL','testController@GL');
    Route::get('/runphp','testController@runphp')->name('runres');
    Route::get('/ex','testController@ex')->name('ex');
    Route::get('/sini','testController@sini')->name('sini');
    Route::get('/test/{id}','testController@destroy')->name('tes-del');
    Route::post('/test/update','testController@del')->name('test-update');


    // Ticket
    Route::get('/dashboard/ticket','ticketingController@index')->name('ticket');
    Route::get('/dashboard/ticket-create','ticketingController@create')->name('ticket-create');
    Route::post('/dashboard/ticket-store','ticketingController@store')->name('ticket-store');
    Route::post('/dashboard/ticket-update','ticketingController@update')->name('ticket-update');
    Route::get('/dashboard/ticket/view-{id}','ticketingController@view')->name('ticket-view');
    Route::get('/dashboard/ticket-delete-{id}','ticketingController@delete')->name('ticket-delete');
    Route::get('/dashboard/ticket-download-{id}','ticketingController@download')->name('ticket-download');
    Route::get('/dashboard/ticket/export','ticketingController@export')->name('ticket_export');
    Route::get('/dashboard/ticket/getTitle','ticketingController@getTitle')->name('getTitle');
    // Route::get('/dashboard/ticket/getTitle','TicketingController@getTitle')->name('getTitle');
    // Route::post('/dashboard/ticket-store','ticketingController@store')->name('ticket-store');
    // Panel Produksi

    Route::get('/dashboard/produksi/panel','produksiController@indexPanel')->name('pro_index_panel');
    Route::get('/dashboard/produksi/panel/input','produksiController@insertViewPan')->name('pro_in_panel');
    Route::post('/dashboard/produksi/panel/insert','produksiController@insertPanel')->name('pro_insert');
    Route::get('/dashboard/produksi/panel/edit/{id}','produksiController@editPanel')->name('pro_edit');
    Route::post('/dashboard/produksi/panel/update','produksiController@updatePanel')->name('pro_update');
    Route::get('/dashboard/produksi/panel/del/{id}','produksiController@destroyPanel')->name('pro_delete');
    Route::get('/dashboard/produksi/panel/export','produksiController@export')->name('pro_export');
    Route::post('/dashboard/produksi/panel/import','produksiController@import')->name('pro_import');
    // Route::get('users/export/', [UsersController::class, 'export']);

    // Insert Tim
    Route::get('/dashboard/produksi/tim','produksiController@indexTim')->name('pro_index_tim');
    Route::get('/dashboard/produksi/tim/input','produksiController@insertViewTim')->name('pro_in_tim');
    Route::post('/dashboard/produksi/tim/insert','produksiController@insertTim')->name('pro_insertTim');
    Route::get('/dashboard/produksi/tim/view/{id}','produksiController@editTim')->name('pro_edit_tim');
    Route::post('/dashboard/produksi/tim/update','produksiController@updateTim')->name('pro_up_tim');
    Route::get('/dashboard/produksi/tim/del/{id}','produksiController@destroyTim')->name('pro_del_tim');

    // Untuk Procurement

    Route::get('/procurement/ppb','ProcController@index')->name('procurement_index');
    Route::get('/procurement/ppb/create','ProcController@create')->name('procurement_create');
    Route::get('/procurement/ppb/form/{id}','ProcController@form')->name('procurement_form');
    Route::get('/procurement/ppb/form_1/{id}','ProcController@form_1')->name('procurement_form_1');
    Route::post('/procurement/ppb/store','ProcController@store')->name('procurement_store');
    Route::get('/procurement/ppb/data','ProcController@getData')->name('procurement_getData');
    Route::get('/procurement/ppb/ed/{id}','ProcController@edit')->name('procurement_edit');
    Route::post('/procurement/ppb/update','ProcController@update')->name('procurement_update');
    Route::post('/procurement/ppb/changeStatus','ProcController@ppb_status')->name('ppb_status');
    Route::get('/procurement/ppb/delbarang/{id}','ProcController@delbarang')->name('procurement_delbarang');
    Route::get('/procurement/ppb/getDesc','ProcController@getDesc')->name('pbb_getDesc');
    Route::get('/procurement/ppb/pbb_getTipebarang','ProcController@pbb_getTipebarang')->name('pbb_getTipebarang');
    Route::get('/procurement/ppb/pbb_getMerek','ProcController@pbb_getMerek')->name('pbb_getMerek');
    Route::get('/procurement/ppb/downloaderror/{filename}','ProcController@downloadErrorFile')->name('pbb_downloadErrorFile');
        Route::get('/ga/downloadErrorFile/{filename}','ga_ItemWarehouseController@downloadErrorFile')->name('ga.downloadErrorFile');
    Route::middleware('procurementMiddleware')->group(function(){

        Route::get('/procurement/ppb/export','ProcController@export')->name('procurement_export');
        Route::get('/procurement/ppb/export/{id}','ProcController@exportIndv')->name('procurement_exportIndv');
        Route::get('/procurement/ppb/del/{id}','ProcController@destroy')->name('procurement_del');
    });
    // PO Lokal Track
    Route::get('/po-lokal/procurement','POTrackController@index')->name('lokal_procurement_index');
    Route::get('/po-lokal/procurement/1','POTrackController@procurement_track_01')->name('lokal_procurement_1');
    Route::post('/po-lokal/procurement/1','POTrackController@procurement_track_01_store')->name('lokal_procurement_1_store');
    Route::get('/po-lokal/procurement/2','POTrackController@procurement_track_02')->name('lokal_procurement_2');
    Route::post('/po-lokal/procurement/2','POTrackController@procurement_track_02_store')->name('lokal_procurement_2_store');
    Route::get('/po-lokal/procurement/3','POTrackController@procurement_track_03')->name('lokal_procurement_3');
    Route::post('/po-lokal/procurement/3','POTrackController@procurement_track_03_store')->name('lokal_procurement_3_store');
    Route::get('/po-lokal/procurement/4','POTrackController@procurement_track_04')->name('lokal_procurement_4');
    Route::post('/po-lokal/procurement/4','POTrackController@procurement_track_04_store')->name('lokal_procurement_4_store');
    Route::get('/po-lokal/procurement/getData','POTrackController@getData')->name('lokal_procurement_getData');

    // Untuk General Affair
    Route::get('/general/infra/create','GeneralAffair@infra_create')->name('infra_create');
    Route::get('/general/item','GeneralAffair@item')->name('itm');
    Route::get('/general/itm/create','GeneralAffair@itm_create')->name('itm_create');
    Route::post('/general/itm/store','GeneralAffair@itm_store')->name('itm_store');
    Route::post('/general/itm/import','GeneralAffair@itm_import')->name('itm_import');
    Route::get('/general/itm/export','GeneralAffair@itm_export')->name('itm_export');
    Route::get('/general/itm/del/{id}','GeneralAffair@itm_del')->name('itm_del');
    Route::get('/general/warehouse','GeneralAffair@warehouse')->name('wh');
    Route::get('/general/wh/create','GeneralAffair@wh_create')->name('wh_create');
    Route::post('/general/wh/store','GeneralAffair@wh_store')->name('wh_store');
    Route::get('/general/wh/del/{id}','GeneralAffair@wh_del')->name('wh_del');
    Route::get('/general/','generalAffair@itm_balance_index')->name('ga_balance_index');
    Route::get('/general/report','generalAffair@report')->name('ga_balance_report');
    Route::get('/general/balance/insert','generalAffair@itm_balance_insert')->name('ga_balance_insert');
    Route::post('/general/balance/store','GeneralAffair@itm_balance_store')->name('itm_balance_store');
    Route::get('/general/balance/export','GeneralAffair@itm_balance_export')->name('itm_balance_export');
    Route::get('/general/reqitem/create','GeneralAffair@reqitem_create')->name('reqitem_create');
    Route::post('/general/reqitem/store','GeneralAffair@reqitem_store')->name('reqitem_store');
    Route::get('/general/reqitem/reqloc','GeneralAffair@reqloc')->name('reqitem_reqloc');
    Route::post('/general/reqitem/update','GeneralAffair@reqitem_update')->name('reqitem_update');
    Route::get('/general/balance/report/export','GeneralAffair@ga_balance_export')->name('ga_balance_export');
    Route::get('/general/reqitem/data', 'GeneralAffair@getData')->name('reqitem_getData');


    // Maintenance
    Route::get('dashboard/maintenance-create','maintenanceController@create')->name('maintenance_create');
    Route::post('dashboard/maintenance-store','maintenanceController@store')->name('maintenance_store');

    // Data karyawan
    Route::get('dashboard/karyawan','KaryawanController@index')->name('karyawan_index');
    Route::get('dashboard/Getkaryawan','KaryawanController@get')->name('karyawan_get');
    Route::post('dashboard/karyawan','KaryawanController@store')->name('karyawan_store');
    Route::post('dashboard/updatekaryawan','KaryawanController@update')->name('karyawan_update');
    Route::get('dashboard/karyawan/del/{id}','KaryawanController@destroy')->name('karyawan_delete');
    Route::post('dashboard/karyawan-import','KaryawanController@import')->name('karyawan_import');

        // Panel p3c
    Route::middleware('p3cMiddleware')->group(function () {
        Route::get('/panel/p3c','pn_01_p3c_Controller@index')->name('pn_01_index');
        Route::get('/panel/p3c/create','pn_01_p3c_Controller@create')->name('pn_01_create');
        Route::post('/panel/p3c/store','pn_01_p3c_Controller@store')->name('pn_01_store');
        Route::get('/panel/p3c/edit-{id}','pn_01_p3c_Controller@edit')->name('pn_01_edit');
        Route::post('/panel/p3c/update','pn_01_p3c_Controller@update')->name('pn_01_update');
        Route::delete('/panel/p3c/del-{id}','pn_01_p3c_Controller@delete')->name('pn_01_delete');
        Route::get('/panel/p3c/export','pn_01_p3c_Controller@export')->name('pn_01_export');
        // Check Existing Customer
        Route::get('/panel/p3c/getCust','pn_01_p3c_Controller@getCust')->name('pn_01_getCust');
    });

    // Panel Produksi
    Route::middleware('produksiMiddleware')->group(function () {
        Route::get('/panel/produksi','pn_02_produksi_Controller@index')->name('pn_02_index');
        Route::get('/panel/produksi/create/','pn_02_produksi_Controller@create')->name('pn_02_create');
        Route::get('/panel/produksi/create/{id}','pn_02_produksi_Controller@create_data');
        Route::post('/panel/produksi/store','pn_02_produksi_Controller@store')->name('pn_02_store');
        Route::get('/panel/produksi/edit-{id}','pn_02_produksi_Controller@edit')->name('pn_02_edit');
        Route::post('/panel/produksi/update','pn_02_produksi_Controller@update')->name('pn_02_update');
        Route::delete('/panel/produksi/del-{id}','pn_02_produksi_Controller@delete')->name('pn_02_delete');
        Route::get('/panel/produksi/search','pn_02_produksi_Controller@search')->name('pn_02_search');
    });

    // Panel QC
    Route::middleware('qcMiddleware')->group(function () {
        Route::get('panel/qc','pn_03_qc_controller@index')->name('pn_03_index');
        Route::get('/panel/qc/create','pn_03_qc_controller@create')->name('pn_03_create');
        Route::get('/panel/qc/create/{id}','pn_03_qc_controller@create_data')->name('pn_03_create_data');
        Route::post('/panel/qc/store','pn_03_qc_controller@store')->name('pn_03_store');
        Route::get('panel/qc/edit-{id}','pn_03_qc_controller@edit')->name('pn_03_edit');
        Route::post('/panel/qc/store_detail','pn_03_qc_controller@store_detail')->name('pn_03_store_detail');
        Route::post('panel/qc/update','pn_03_qc_controller@update')->name('pn_03_update');
        Route::delete('panel/qc/del-{id}','pn_03_qc_controller@delete')->name('pn_03_delete');
        Route::get('/panel/qc/search','pn_03_qc_controller@search')->name('pn_03_search');
    });

    // Panel Eng
    Route::middleware('engMiddleware')->group(function () {
        Route::get('/panel/eng/','pn_04_eng_controller@index')->name('pn_04_index');
        Route::get('/panel/eng/create','pn_04_eng_controller@create')->name('pn_04_create');
        Route::get('/panel/eng/create/{id}','pn_04_eng_controller@create_data')->name('pn_04_create_data');
        Route::post('/panel/eng/store','pn_04_eng_controller@store')->name('pn_04_store');
        Route::get('/panel/eng/edit-{id}','pn_04_eng_controller@edit')->name('pn_04_edit');
        Route::get('/panel/eng/edit_data-{id}','pn_04_eng_controller@edit_data')->name('pn_04_edit_data');
        Route::post('/panel/eng/update','pn_04_eng_controller@update')->name('pn_04_update');
        Route::delete('/panel/eng/del-{id}','pn_04_eng_controller@delete')->name('pn_04_delete');
        Route::get('/s_email/{id}', 'pn_04_eng_controller@s_email')->name('s_email');

    });
    Route::middleware('logistikMiddleware')->group(function(){
        Route::get('/panel/logistik/','pn_05_logistik_controller@index')->name('pn_05_index');
        Route::post('/panel/logistik/store','pn_05_logistik_controller@store')->name('pn_05_store');
    });
});
// Panel Produksi
Route::get('/produksi','produksiController@index')->name('produksi_index');

// New Panel
Route::get('/panel','pn_00_panel_controller@index')->name('pn_00_panel');
Route::get('/panel/view','pn_00_panel_controller@index_new')->name('pn_00_panel_new');
Route::get('/panel/display','pn_00_panel_controller@display')->name('pn_00_panel_display');
Route::get('/panel/getData','pn_00_panel_controller@getData')->name('pn_00_timeline');

// New Team Panel Input
Route::get('/panel/team','pn_00_team_Controller@index')->name('pn_00_index');
Route::get('/panel/team/create','pn_00_team_Controller@create')->name('pn_00_create');
Route::post('/panel/team/store','pn_00_team_Controller@store')->name('pn_00_store');
Route::get('/panel/team/edit-{id}','pn_00_team_Controller@edit')->name('pn_00_edit');
Route::post('/panel/team/update','pn_00_team_Controller@update')->name('pn_00_update');
Route::delete('/panel/team/del-{id}','pn_00_team_Controller@delete')->name('pn_00_delete');
Route::post('/panel/team/import','pn_00_team_Controller@import')->name('pn_00_import');


//General Affair Master Item
Route::get('/ga/masteritem', 'ga_masterItemController@masterItem')->name('ga.masterItem');
Route::post('/ga/masteritem/store', 'ga_masterItemController@store')->name('ga.masterItemAdd');
Route::get('/ga/masteritem/{id}/edit', 'ga_masterItemController@edit')->name('ga.masterItemEdit');
Route::post('/ga/masteritem/update', 'ga_masterItemController@update')->name('ga.masterItemUpdate');
Route::post('/ga/masteritem/import', 'ga_masterItemController@masterItemImport')->name('ga.masterItemImport');
Route::post('/ga/masteritem/delete/{id}', 'ga_masterItemController@destroy')->name('ga.masterItemDelete');
Route::get('ga/masteritem/export','ga_masterItemController@export')->name('ga.masterItemExport');

// General Affair Master Warehouse
Route::get('/ga/masterwarehouse', 'ga_masterWarehouseController@masterItem')->name('ga.masterWarehouse');
Route::post('/ga/masterwarehouse/store', 'ga_masterWarehouseController@store')->name('ga.masterWarehouseAdd');
Route::get('/ga/masterwarehouse/{id}/edit', 'ga_masterWarehouseController@edit')->name('ga.masterWarehouseEdit');
Route::post('/ga/masterwarehouse/update', 'ga_masterWarehouseController@update')->name('ga.masterWarehouseUpdate');
Route::post('/ga/masterwarehouse/import', 'ga_masterWarehouseController@masterItemImport')->name('ga.masterWarehouseImport');
Route::post('/ga/masterwarehouse/delete/{id}', 'ga_masterWarehouseController@destroy')->name('ga.masterWarehouseDelete');
Route::get('ga/masterwarehouse/export','ga_masterWarehouseController@export')->name('ga.masterWarehouseExport');

//
// General Affair Master Warehouse
Route::get('/ga', 'ga_ItemWarehouseController@masterItem')->name('ga.ItemWarehouse');
Route::post('/ga/store', 'ga_ItemWarehouseController@store')->name('ga.ItemWarehouseAdd');
Route::get('/ga/{id}/edit', 'ga_ItemWarehouseController@edit')->name('ga.ItemWarehouseEdit');
Route::post('/ga/update', 'ga_ItemWarehouseController@update')->name('ga.ItemWarehouseUpdate');
Route::post('/ga/import', 'ga_ItemWarehouseController@masterItemImport')->name('ga.ItemWarehouseImport');
Route::post('/ga/delete/{id}', 'ga_ItemWarehouseController@destroy')->name('ga.ItemWarehouseDelete');
Route::get('/ga/export','ga_ItemWarehouseController@export')->name('ga.ItemWarehouseExport');
Route::get('/ga/downloadErrorFile/{filename}','ga_ItemWarehouseController@downloadErrorFile')->name('ga.downloadErrorFile');
require __DIR__.'/auth.php';
