<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nguoidung;
use App\Logdangnhap;
use Session;

class dangnhapController extends Controller
{
	function getIpAddress()
	{
		$IP_ADDRESS = "";
		if (!empty($_SERVER['HTTP_CLIENT_IP']))     {
			$IP_ADDRESS = $_SERVER['HTTP_CLIENT_IP'];
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$IP_ADDRESS = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else  {
			$IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
		}
		return $IP_ADDRESS;
	}

	public function postLogin(Request $request)
	{
		$user = Nguoidung::where("maso", $request->get("MA_CAN_BO"))->where("matkhau", md5($request->get("MAT_KHAU")))->where("tinhtrang", "1")->first();
		if($user){

			Session::put("USER_ID", $user->maso);
			Session::put("USER_NAME", $user->ten);
			Session::put("USER_IMG", $user->anhdaidien);
			$LOG = new Logdangnhap();
			$LOG->manguoidung = $user->maso;
			$LOG->browser     = $_SERVER ['HTTP_USER_AGENT'];
			$LOG->diachiip 	  =	$this->getIpAddress();
			$LOG->save();

			return response(["error"=>false, "message"=>true], 200);

		}else{
			return response(["error"=>false, "message"=>false], 200);
		}
	}

	public function postLogout(){
    	//&& Session::has("admin_q")
		if(Session::has("USER_ID") ){
			Session::forget("USER_ID");
			Session::forget("USER_NAME");
			Session::forget("USER_IMG");
			return redirect()->back();
		}else{
			return response(["error"=>false, "message"=>false], 200);
		}
    }
	
}
