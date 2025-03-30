<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$route['default_controller'] = 'Auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Routes Admin 
$route['Admin'] = 'Dashboard/view_admin';

$route['Admin-Pengguna'] = 'Pengguna';
$route['Admin-TambahPengguna'] = 'Pengguna/tambah_pengguna';
$route['Admin-EditPengguna/(:num)'] = 'Pengguna/edit_pengguna/$1';
$route['Admin-HapusPengguna/(:num)'] = 'Pengguna/hapus_pengguna/$1';

$route['Admin-InputLaporan'] = 'InputLaporan/view_admin';
$route['Admin-TambahLaporan'] = 'InputLaporan/tambah_laporan_admin';
$route['Admin-EditLaporan/(:num)'] = 'InputLaporan/edit_laporan_admin/$1';
$route['Admin-HapusLaporan/(:num)'] = 'InputLaporan/hapus_batch/$1';

$route['Admin-Komoditas'] = 'Komoditas';
$route['Admin-TambahKomoditas'] = 'Komoditas/tambah_komoditas';
$route['Admin-EditKomoditas/(:num)'] = 'Komoditas/edit_komoditas/$1';
$route['Admin-HapusKomoditas/(:num)'] = 'Komoditas/hapus_komoditas/$1';

$route['Admin-Kecamatan'] = 'Kecamatan';
$route['Admin-TambahKecamatan'] = 'Kecamatan/tambah_kecamatan';
$route['Admin-EditKecamatan/(:num)'] = 'Kecamatan/edit_kecamatan/$1';
$route['Admin-HapusKecamatan/(:num)'] = 'Kecamatan/hapus_kecamatan/$1';

$route['Admin-Desa'] = 'Desa';
$route['Admin-TambahDesa'] = 'Desa/tambah_desa';
$route['Admin-EditDesa/(:num)'] = 'Desa/edit_desa/$1';
$route['Admin-HapusDesa/(:num)'] = 'Desa/hapus_desa/$1';

$route['Admin-Tanam'] = 'Tanam/view_admin';

$route['Admin-Panen'] = 'Panen/view_admin';

$route['Admin-Produksi'] = 'Produksi/view_admin';

$route['Admin-LaporanTanam'] = 'LaporanTanam/view_admin';

$route['Admin-LaporanPanen'] = 'LaporanPanen/view_admin';

$route['Admin-LaporanProduksi'] = 'LaporanProduksi/view_admin';

$route['Admin-Lahan'] = 'Lahan';
$route['Admin-TambahLahan'] = 'Lahan/tambah_lahan';
$route['Admin-EditLahan/(:num)'] = 'Lahan/edit_lahan/$1';
$route['Admin-HapusLahan/(:num)'] = 'Lahan/hapus_lahan/$1';

$route['Admin-Map'] = 'Lahan/map_admin';

// Routes Petugas Kantor
$route['PetugasKantor'] = 'Dashboard/view_petugaskantor';

$route['PetugasKantor-LaporanTanam'] = 'LaporanTanam/view_petugaskantor';

$route['PetugasKantor-LaporanPanen'] = 'LaporanPanen/view_petugaskantor';

$route['PetugasKantor-LaporanProduksi'] = 'LaporanProduksi/view_petugaskantor';

$route['PetugasKantor-Map'] = 'Lahan/map_petugaskantor';


// Routes Penyuluh
$route['Penyuluh'] = 'Dashboard/view_penyuluh';

$route['Penyuluh-InputLaporan'] = 'InputLaporan/view_penyuluh';
$route['Penyuluh-TambahLaporan'] = 'InputLaporan/tambah_laporan_penyuluh';
$route['Penyuluh-EditLaporan/(:num)'] = 'InputLaporan/edit_laporan_penyuluh/$1';
$route['Penyuluh-HapusLaporan/(:num)'] = 'InputLaporan/hapus_batch/$1';

$route['Penyuluh-Tanam'] = 'Tanam/view_penyuluh';

$route['Penyuluh-Panen'] = 'Panen/view_penyuluh';

$route['Penyuluh-Produksi'] = 'Produksi/view_penyuluh';

$route['Penyuluh-Map'] = 'Lahan/map_penyuluh';