<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nguoidung;
use App\Logdangnhap;
use Session;
use Validator;
use Illuminate\Support\MessageBag;
use Illuminate\PHPImageWorkshop\ImageWorkshop;

class thongtinController extends Controller
{
    public function index()
    {	
    	$TIEU_DE = "Thông Tin Cá Nhân";
    	if(Session::has('USER_ID')){
    		$CAN_BO = Nguoidung::select("nguoidung.*", "donvi.tendonvi", "nhom.tennhom")
    				->join("donvi", "donvi.madonvi", "nguoidung.madonvi")
    				->join("nhom", "nhom.manhom", "nguoidung.manhom")
    				->where("nguoidung.maso", Session::get('USER_ID'))
    				->first();
    		
    		if($CAN_BO)
    			return view("THONGTIN.THONG_TIN_CA_NHAN", compact("TIEU_DE", "CAN_BO"));
    		else return view("ERROR.ERROR_404");
    	}
    }

    public function log()
    {
        $TIEU_DE = "Nhật Ký Đăng Nhập";
        if(Session::has('USER_ID')){
            $LOG_DN = Logdangnhap::select("logdangnhap.*")
                    ->join("nguoidung", "nguoidung.maso", "logdangnhap.manguoidung")
                    ->where("logdangnhap.manguoidung", Session::get('USER_ID'))
                    ->get();
            
            if($LOG_DN)
                return view("THONGTIN.LOG_DANG_NHAP", compact("TIEU_DE", "LOG_DN"));
            else return view("ERROR.ERROR_404");
        }else return redirect(route('login'));
    }

    function CheckData(Request $req)
    {
        $CAN_BO = Nguoidung::where("maso", Session::get("USER_ID"))->first();
        return $CAN_BO->ho          !=  $req->get("HO")             ||
               $CAN_BO->ten         !=  $req->get("TEN")            ||
               $CAN_BO->email       !=  $req->get("EMAIL")          ||
               $CAN_BO->diachi      !=  $req->get("DIA_CHI")        ||
               $CAN_BO->sodienthoai !=  $req->get("SO_DIEN_THOAI")  ||
               strtotime($CAN_BO->ngaysinh) != strtotime($req->get("NGAY_SINH")) ||
               $CAN_BO->gioitinh    !=  $req->get("GIOI_TINH")      ||
               $req->hasFile("ANH_DAI_DIEN");
    }

    public function edit_thong_tin(Request $request)
    {
        if(Session::has("USER_ID")){
            if($this->CheckData($request)){

                $rule = $message =array();
                $CAN_BO = Nguoidung::where("maso", Session::get("USER_ID"))->first();  
                if($CAN_BO->sodienthoai != $request->get("SO_DIEN_THOAI")){
                    $rule = array_add($rule, 'SO_DIEN_THOAI', 'unique:nguoidung,sodienthoai');
                }
                if($CAN_BO->email != $request->get("EMAIL")){
                    $rule = array_add($rule, 'EMAIL', 'unique:nguoidung,email');
                }
                $message = [
                    "SO_DIEN_THOAI.unique"   => "Số điện thoại đã được sử dụng!",
                    "EMAIL.unique"   => "Email đã được sử dụng!",  
                ];


                $validator = Validator::make($request->all(), $rule, $message);
                if($validator->fails()){
                    return response()->json(['error'=>true, 'message'=>$validator->errors()]);
                }else{
                    if($request->hasFile("ANH_DAI_DIEN")){
                        $file = $request->file('ANH_DAI_DIEN');

                        $dirImg  = __DIR__.'\..\..\..\public\images\avatar\\';

                        $src= ImageWorkshop::initFromPath($file->getRealPath());
                        $src->resizeInPixel(215, 215, false);

                        $createFolders = true;
                        $backgroundColor = null; 
                        $imageQuality = 80; 

                        $destFileName = time()."_".$file->getClientOriginalName();

                        if(file_exists(public_path('images/avatar/'.$CAN_BO->anhdaidien)))
                            unlink(public_path('images/avatar/'.$CAN_BO->anhdaidien));

                        $CAN_BO->anhdaidien  = $destFileName;

                        $src->save($dirImg, $destFileName, $createFolders, $backgroundColor, $imageQuality);
                    }

                    $CAN_BO->ho             =   $request->get("HO");
                    $CAN_BO->ten            =   $request->get("TEN");
                    $CAN_BO->sodienthoai    =   $request->get("SO_DIEN_THOAI");
                    $CAN_BO->email          =   $request->get("EMAIL");
                    $CAN_BO->diachi         =   $request->get("DIA_CHI");
                    $CAN_BO->ngaysinh       =   $request->get("NGAY_SINH");
                    $CAN_BO->gioitinh       =   $request->get("GIOI_TINH");

                    if($CAN_BO->save()){
                        Session::put("USER_NAME", $CAN_BO->ten);
                        Session::put("USER_IMG", $CAN_BO->anhdaidien);
                        $request->session()->flash('status', 'Cập nhật thông tin thành công!');
                        return response(["error"=>false, "message"=>true], 200);
                    }
                    else return response(["error"=>false, "message"=>false], 200);
                }
            }
            return response(["error"=>false, "check"=>true], 200);
        }  
    }

    public function edit_mat_khau(Request $request)
    {
        if(Session::has("USER_ID")){
            $CAN_BO = Nguoidung::where('maso', Session::get("USER_ID"))->where("matkhau", md5($request->get("MAT_KHAU_CU")))->first();
            if($CAN_BO){
                $CAN_BO->matkhau = md5($request->get("MAT_KHAU_MOI"));
                if($CAN_BO->save()){
                    $request->session()->flash('status', 'Cập nhật mật khẩu thành công!');
                    return response(["error"=>false, "message"=>true], 200);
                }else{
                    return response(["error"=>false, "message"=>false], 200);
                }
            }else return response(["error"=>true, "message"=>false], 200);
        }else return redirect(route('login'));  
    }
}
