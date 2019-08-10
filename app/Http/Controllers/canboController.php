<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nguoidung, App\Donvi, App\Nhom;
use Validator;
use Session;
use Illuminate\Support\MessageBag;
use Illuminate\Database\QueryException;
use DataTables;
use Illuminate\PHPImageWorkshop\ImageWorkshop;
class canboController extends Controller
{
    public function index()
    {
    	$TIEU_DE = "Danh sách cán bộ";
        $DON_VI = Donvi::all();
        $NHOM = Nhom::all();
    	return view('CANBO.DS_CAN_BO', compact('TIEU_DE', 'DON_VI', 'NHOM'));
    }

    public function data()
    {
        $DS_CAN_BO = Nguoidung::select("nguoidung.*", "donvi.tendonvi", "nhom.tennhom")
                    ->join("donvi", "donvi.madonvi", "nguoidung.madonvi")
                    ->join("nhom", "nhom.manhom", "nguoidung.manhom")
                    ->orderBy("nguoidung.thoigianthem", "desc")->get();
        return DataTables::of($DS_CAN_BO)
            ->editColumn('thoigianthem', function ($DS_CAN_BO){
                return date('d-m-Y H:i:s', strtotime($DS_CAN_BO->thoigianthem) );
            })
            ->editColumn('ten', function ($DS_CAN_BO){
                return $DS_CAN_BO->ho ." ". $DS_CAN_BO->ten;
            })
            ->addColumn('action', function($DS_CAN_BO){
                if($DS_CAN_BO->maso != Session::get('USER_ID')){
                    return '<button id="btn-edit" value="'.$DS_CAN_BO->id.'" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Sửa</button>'.
                        '<button value="'.$DS_CAN_BO->id.'" id="btn-delete" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</button>';
                }
            })->addColumn('STT', function($DS_CAN_BO){})->make(true);
    }

    public function add_can_bo(Request $request)
    {
        try{
        	$rule = [
        		"MA_CAN_BO" 	=> "unique:nguoidung,maso",
                "EMAIL"  => "unique:nguoidung,email",
                "SO_DIEN_THOAI" => "unique:nguoidung,sodienthoai",
            ];
            $message = [
            	"MA_CAN_BO.unique"    => "Mã cán bộ đã được sử dụng!",
                "EMAIL.unique" => "Email cán bộ đã được sử dụng!",
                "SO_DIEN_THOAI.unique"   => "Số điện thoại đã được sử dụng!",   
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

                    $anhdaidien  = $destFileName;

                    $src->save($dirImg, $destFileName, $createFolders, $backgroundColor, $imageQuality);
                }
                $CAN_BO                 =   new Nguoidung();
                $CAN_BO->maso           =   $request->get("MA_CAN_BO");
                $CAN_BO->matkhau        =   md5($request->get("MA_CAN_BO"));
                $CAN_BO->ho             =   $request->get("HO");
                $CAN_BO->ten            =   $request->get("TEN");
                $CAN_BO->sodienthoai    =   $request->get("SO_DIEN_THOAI");
                $CAN_BO->email          =   $request->get("EMAIL");
                $CAN_BO->diachi         =   $request->get("DIA_CHI");
                $CAN_BO->ngaysinh       =   $request->get("NGAY_SINH");
                $CAN_BO->gioitinh       =   $request->get("GIOI_TINH");
                $CAN_BO->madonvi        =   $request->get("DON_VI");
                $CAN_BO->manhom         =   $request->get("NHOM");

                if(isset($anhdaidien)) $CAN_BO->anhdaidien  =  $destFileName;
                else $CAN_BO->anhdaidien = ($request->get("GIOI_TINH")==1) ? "avatar.png" : "avatarnu.png";
                

      			if($CAN_BO->save()){
      				return response(['error'=>false, 'message'=>true]);
      			}
      			else
      				return response(['error'=>false, 'message'=>false]);
        	}

        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }

    function CheckData(Request $req, $CAN_BO)
    {
        return $CAN_BO->maso        !=  $req->get("MA_CAN_BO")       ||
               $CAN_BO->ho          !=  $req->get("HO")             ||
               $CAN_BO->ten         !=  $req->get("TEN")            ||
               $CAN_BO->email       !=  $req->get("EMAIL")          ||
               $CAN_BO->diachi      !=  $req->get("DIA_CHI")        ||
               $CAN_BO->sodienthoai !=  $req->get("SO_DIEN_THOAI")  ||
               strtotime($CAN_BO->ngaysinh) != strtotime($req->get("NGAY_SINH")) ||
               $CAN_BO->gioitinh    !=  $req->get("GIOI_TINH")      ||
               $CAN_BO->madonvi     !=  $req->get("DON_VI")         || 
               $CAN_BO->manhom      !=  $req->get("NHOM")           ||
               $req->hasFile("ANH_DAI_DIEN");
    }

    public function edit_can_bo(Request $req, $id)
    {
        try{
            $rule  = array();
            $message = array();
        	$CAN_BO = Nguoidung::where('id', $id)->first();
        	if($CAN_BO){
    			if($this->CheckData($req, $CAN_BO)){

                    if($CAN_BO->maso != $req->get('MA_CAN_BO')){
                        $rule = array_add($rule, 'MA_CAN_BO', 'unique:nguoidung,maso');
                    }
                    if($CAN_BO->sodienthoai != $req->get("SO_DIEN_THOAI")){
                        $rule = array_add($rule, 'SO_DIEN_THOAI', 'unique:nguoidung,sodienthoai');
                    }
                    if($CAN_BO->email != $req->get("EMAIL")){
                        $rule = array_add($rule, 'EMAIL', 'unique:nguoidung,email');
                    }
                    $message = [
                        "MA_CAN_BO.unique"   => "Mã cán bộ đã được sử dụng!",
                        "SO_DIEN_THOAI.unique"   => "Số điện thoại đã được sử dụng!",
                        "EMAIL.unique"   => "Email đã được sử dụng!",  
                    ];

    	    		$validator = Validator::make($req->all(), $rule, $message);
    	    		if($validator->fails()){
    	    			return response()->json(['error'=>true, 'message'=>$validator->errors()]);
    	    		}else{
                        if($req->hasFile("ANH_DAI_DIEN")){
                            $file = $req->file('ANH_DAI_DIEN');

                            $dirImg  = __DIR__.'\..\..\..\public\images\avatar\\';

                            $src= ImageWorkshop::initFromPath($file->getRealPath());
                            $src->resizeInPixel(215, 215, false);

                            $createFolders = true;
                            $backgroundColor = null; 
                            $imageQuality = 80; 

                            $destFileName = time()."_".$file->getClientOriginalName();

                            $anhdaidien  = $destFileName;

                            $src->save($dirImg, $destFileName, $createFolders, $backgroundColor, $imageQuality);
                        }
                        $CAN_BO->maso           =   $req->get("MA_CAN_BO");
                        $CAN_BO->ho             =   $req->get("HO");
                        $CAN_BO->ten            =   $req->get("TEN");
                        $CAN_BO->sodienthoai    =   $req->get("SO_DIEN_THOAI");
                        $CAN_BO->email          =   $req->get("EMAIL");
                        $CAN_BO->diachi         =   $req->get("DIA_CHI");
                        $CAN_BO->ngaysinh       =   $req->get("NGAY_SINH");
                        $CAN_BO->gioitinh       =   $req->get("GIOI_TINH");
                        $CAN_BO->madonvi        =   $req->get("DON_VI");
                        $CAN_BO->manhom         =   $req->get("NHOM");
                        if(isset($anhdaidien)) $CAN_BO->anhdaidien  =  $destFileName;
                        else{
                            if($CAN_BO->anhdaidien == "avatar.png" || $CAN_BO->anhdaidien == "avatarnu.png")
                                $CAN_BO->anhdaidien = ($req->get("GIOI_TINH") == 1) ? "avatar.png" : "avatarnu.png";
                        }
    	    			$CAN_BO->save();
                        return response(['error'=>false, 'message'=>true]);
    	    		}
        		}
        	}
        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }

    public function can_bo_detail($id)
    {
    	$CAN_BO = Nguoidung::where('id', $id)->first();
    	if($CAN_BO)
    		return response(['error'=>false, 'message'=>$CAN_BO]);
    	else
    		return response(['error'=>true, 'message'=>false]);
    }

    public function delete_can_bo(Request $req)
    {
        try{
        	$CAN_BO = Nguoidung::where('id', $req->get("MA_CAN_BO_DELETE"))->first();
        	if($CAN_BO){
                if(file_exists(public_path('images/avatar/'.$CAN_BO->anhdaidien)))
                    unlink(public_path('images/avatar/'.$CAN_BO->anhdaidien));
        		$CAN_BO->delete();
        	   return response(['error'=>false, 'message'=>true]);
        	}
        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }
}
