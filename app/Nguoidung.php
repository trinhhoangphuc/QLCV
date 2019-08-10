<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;


class Nguoidung extends Model
{
	public $timestamps = false;

	protected $table 		= "nguoidung";
	protected $fillable 	=  ['maso', 'matkhau', 'ho', 'ten', 'ngaysinh', 'email', 'sodienthoai', 'diachi', 'madonvi', 'manhom', 'tinhtrang', 'thoigianthem',  "anhdaidien", "gioitinh"];
	protected $guarded  	= ["id"];

	protected $primaryKey 	= "id";

	protected $dates		= ["ngaysinh", "thoigianthem"];
	protected $dateFormat 	= 'Y-m-d H:i:s';
	
}