<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['user/export'] = 'user/export';
$route['user/import']['post'] = 'user/import';
$route['user/get_finalaccount_data'] = 'user/get_finalaccount_data';
$route['user/finalaccount_update'] = 'user/finalaccount_update';
$route['user/finalaccount/delete'] = 'user/finalaccount_delete';
$route['user/asbuiltdrawing'] = 'user/asbuiltdrawing';
$route['user/bast1'] = 'user/getBAST';
$route['user/editbast1'] = 'user/editbast1';
$route['user/update_bast_data'] = 'user/update_bast_data';
$route['user/edit_bast/(:any)'] = 'user/editBAST1/$1';
$route['user/editBAST1/(:num)'] = 'user/editBAST1/$1';
$route['user/updateBAST1/(:num)'] = 'user/updateBAST1/$1';
$route['user/some_error_page'] = 'user/some_error_page';
$route['user/data_bast'] = 'user/data_bast';
$route['user/get_bast_detail/(:any)'] = 'user/get_bast_detail/$1';
$route['user/bast2'] = 'user/getBAST2';
$route['user/update_bast2_data'] = 'user/update_bast2_data';
$route['user/finalaccount_pengadaan'] = 'user/finalaccount_pengadaan';
$route['user/closing'] = 'user/closing';
$route['user/get_closing_data'] = 'user/get_closing_data';
$route['user/closing_update'] = 'user/closing_update';
$route['user/closing/delete'] = 'user/closing_delete';
$route['user/export_bast'] = 'user/export_bast';
$route['user/report'] = 'user/report';
$route['user/report'] = 'user/laporan';
$route['user/export'] = 'user/export';
$route['user/insert_data'] = 'user/insert_data';
$route['user/export'] = 'user/exportFilteredDataToExcel';
$route['user/export_report'] = 'user/export_report';
$route['user/add_insert_data'] = 'user/add_insert_data';
$route['user/backup_database'] = 'user/backup_database';
$route['user/partial'] = 'user/partial';
$route['partial/add'] = 'partial/add';
$route['user/export_partial'] = 'user/export_partial';
$route['user/export_parkir'] = 'parkir/export_parkir';
$route['user/import_parkir'] = 'parkir/import_parkir';
$route['user/parkir'] = 'parkir/index';
$route['user/barangmasuk'] = 'Gudang/index';
$route['user/barangkeluar'] = 'Gudang_keluar/index';
$route['user/barangkeluar/update'] = 'Gudang_keluar/update_keluar'; // Untuk proses edit barang keluar
// $route['user/barangkeluar'] = 'Gudang_keluar/update_keluar';
$route['user/non_active'] = 'parkir/non_active';
$route['parkir/move_to_non_active'] = 'parkir/move_to_non_active';
$route['Gudang_keluar/generate_pdf/(:num)'] = 'Gudang_keluar/generate_pdf/$1';


// MIlenial

$route['proyek/milenial/kontrak'] = 'proyek/milenial_kontrak';
$route['proyek/tambah_kontrak'] = 'proyek/tambah_kontrak';
$route['proyek/update_kontrak'] = 'proyek/update_kontrak';
$route['proyek/delete_kontrak/(:num)'] = 'proyek/delete_kontrak/$1';
$route['proyek/get_kontrak_data/(:num)'] = 'proyek/get_kontrak_data/$1';


$autoload['packages'] = array(APPPATH . 'third_party/phpoffice/phpspreadsheet');
