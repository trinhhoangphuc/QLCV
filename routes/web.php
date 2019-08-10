<?php

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
   if(Session::has("USER_ID"))
		return redirect(route("TRANG_CA_NHAN"));
	else
		return view('login');	
})->name("login");


// đăng nhập admin
Route::post('login', "dangnhapController@postLogin")->name("postlogin");

Route::get('logout', "dangnhapController@postLogout")->name("postLogout");
//kết thúc đăng nhập

Route::group(["middleware"=>"CheckLogin"], function(){

	/*Quanr lý thông tin cá nhân*/
	Route::group(['prefix'=>'thong-tin'], function (){
		Route::get('thong-tin-ca-nhan', 'thongtinController@index')->name("TRANG_CA_NHAN"); //danh sách đơn vị
		Route::get('nhat-ky-dang-nhap', 'thongtinController@log')->name("LOG_DANG_NHAP"); //danh sách nhật ký đăng nhập
		Route::post('cap-nhat', 'thongtinController@edit_thong_tin')->name("SUA_THONG_TIN"); // cập nhật thong tin
		Route::post('cap-nhat-mat-khau', 'thongtinController@edit_mat_khau')->name("SUA_MAT_KHAU"); // cập nhật mật khẩu
	});

	/*Quản lý danh sách đơn vị*/
	Route::group(['prefix'=>'don-vi'], function (){
		Route::get('danh-sach', 'donviController@index')->name("DS_DON_VI"); //danh sách đơn vị
		Route::get('data-danh-sach', 'donviController@data')->name("DATA_DS_DON_VI");// ajax danh sách
		Route::get('du-lieu-don-vi/{id}', 'donviController@don_vi_detail')->name("DU_LIEU_DON_VI"); //danh sách đơn vị
		Route::post('them', 'donviController@add_don_vi')->name("THEM_DON_VI"); // Thêm đơn vị
		Route::post('sua/{id}', 'donviController@edit_don_vi')->name("SUA_DON_VI"); // cập nhật đơn vị
		Route::post('xoa', 'donviController@delete_don_vi')->name("XOA_DON_VI"); // xóa đơn vị
	});

	/*Quản lý danh sách đơn vị ban hành*/
	Route::group(['prefix'=>'don-vi-ban-hanh'], function (){
		Route::get('danh-sach', 'donvibanhanhController@index')->name("DS_DON_VI_BAN_HANH"); //danh sách đơn vị
		Route::get('data-danh-sach', 'donvibanhanhController@data')->name("DATA_DS_DON_VI_BAN_HANH"); // ajax danh sách
		Route::get('du-lieu-don-vi/{id}', 'donvibanhanhController@don_vi_detail')->name("DU_LIEU_DON_VI_BAN-HANH"); //danh sách đơn vị
		Route::post('them', 'donvibanhanhController@add_don_vi')->name("THEM_DON_VI_BAN-HANH"); // Thêm đơn vị
		Route::post('sua/{id}', 'donvibanhanhController@edit_don_vi')->name("SUA_DON_VI_BAN-HANH"); // cập nhật đơn vị
		Route::post('xoa', 'donvibanhanhController@delete_don_vi')->name("XOA_DON_VI_BAN-HANH"); // xóa đơn vị
	});

	/*Quản lý danh sách nhóm*/
	Route::group(['prefix'=>'nhom-quyen'], function (){
		Route::get('danh-sach', 'nhomController@index')->name("DS_NHOM"); //danh sách đơn vị
		Route::get('data-danh-sach', 'nhomController@data')->name("DATA_DS_NHOM"); // ajax danh sách
		Route::get('du-lieu-nhom/{id}', 'nhomController@nhom_detail')->name("DU_LIEU_NHOM"); //danh sách đơn vị
		Route::get('quyen-nhom/{id}', 'nhomController@nhom_role')->name("QUYEN_NHOM"); //danh sách quyền
		Route::post('them', 'nhomController@add_nhom')->name("THEM_NHOM"); // Thêm đơn vị
		Route::post('sua/{id}', 'nhomController@edit_nhom')->name("SUA_NHOM"); // cập nhật đơn vị
		Route::post('xoa', 'nhomController@delete_nhom')->name("XOA_NHOM"); // xóa đơn vị
		Route::post('cap-quyen/{id}', 'nhomController@add_role')->name("CAP_QUYEN"); // Cấp quyền
	});

	/*Quản lý danh sách Cán bộ*/
	Route::group(['prefix'=>'can-bo'], function (){
		Route::get('danh-sach', 'canboController@index')->name("DS_CAN_BO"); //danh sách đơn vị
		Route::get('data-danh-sach', 'canboController@data')->name("DATA_DS_CAN_BO"); // ajax danh sách
		Route::get('du-lieu/{id}', 'canboController@can_bo_detail')->name("DU_LIEU_CAN_BO"); //danh sách đơn vị
		Route::post('them', 'canboController@add_can_bo')->name("THEM_CAN_BO"); // Thêm đơn vị
		Route::post('sua/{id}', 'canboController@edit_can_bo')->name("SUA_CAN_BO"); // cập nhật đơn vị
		Route::post('xoa', 'canboController@delete_can_bo')->name("XOA_CAN_BO"); // xóa đơn vị
	});

	/*Quản lý danh sách loại công văn*/
	Route::group(['prefix'=>'loai-cong-van'], function (){
		Route::get('danh-sach', 'loaicongvanController@index')->name("DS_LOAI_CONG_VAN"); //danh sách đơn vị
		Route::get('data-danh-sach', 'loaicongvanController@data')->name("DATA_DS_LOAI_CONG_VAN"); // ajax danh sách
		Route::get('du-lieu/{id}', 'loaicongvanController@loai_detail')->name("DU_LIEU_LOAI_CONG_VAN"); //danh sách đơn vị
		Route::post('them', 'loaicongvanController@add_loai')->name("THEM_LOAI_CONG_VAN"); // Thêm đơn vị
		Route::post('sua/{id}', 'loaicongvanController@edit_loai')->name("SUA_LOAI_CONG_VAN"); // cập nhật đơn vị
		Route::post('xoa', 'loaicongvanController@delete_loai')->name("XOA_LOAI_CONG_VAN"); // xóa đơn vị
	});

	/*Quản lý danh sách Công văn*/
	Route::group(['prefix'=>'cong-van'], function (){
		Route::get('danh-sach', 'congvanController@index')->name("DS_CONG_VAN"); //danh sách đơn vị
		Route::get('data-danh-sach', 'congvanController@data')->name("DATA_DS_CONG_VAN"); // ajax danh sách
		Route::get('du-lieu/{id}', 'congvanController@can_bo_detail')->name("DU_LIEU_CONG_VAN"); //danh sách đơn vị
		Route::post('them', 'congvanController@add_can_bo')->name("THEM_CONG_VAN"); // Thêm đơn vị
		Route::post('sua/{id}', 'congvanController@edit_can_bo')->name("SUA_CONG_VAN"); // cập nhật đơn vị
		Route::post('xoa', 'congvanController@delete_can_bo')->name("XOA_CONG_VAN"); // xóa đơn vị
	});

});
