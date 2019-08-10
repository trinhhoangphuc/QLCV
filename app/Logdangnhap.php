<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logdangnhap extends Model{
	public $timestamps = false;

	protected $table 		= 'logdangnhap';
	protected $fillable 	= ["manguoidung", "diachiip", "browser", "ngaydangnhap"];
	protected $guarded 		= ["id"];

	protected $primaryKey 	= "id";
	public 	  $incrementing = true;
	
	protected $dates 		= ["ngaydangnhap"];
	protected $dateFormat	= "Y-m-d H:i:s";
}