<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Loaivanban;
use Validator;
use Session;
use Illuminate\Support\MessageBag;
use Illuminate\Database\QueryException;
use DataTables;

class loaicongvanController extends Controller
{
    public function index()
    {
    	$TIEU_DE = "Danh sách loại công văn";
    	return view('LOAICONGVAN.DS_LOAI_CONG_VAN', compact('TIEU_DE'));
    }

    public function data()
    {
        $DS_LOAI_CONG_VAN = Loaivanban::orderBy('thoigianthem', 'DESC')->get();
        return DataTables::of($DS_LOAI_CONG_VAN)
            ->editColumn('thoigianthem', function ($DS_LOAI_CONG_VAN){
                return date('d-m-Y H:i:s', strtotime($DS_LOAI_CONG_VAN->thoigianthem) );
            })
            ->addColumn('action', function($DS_LOAI_CONG_VAN){
                return '<button id="btn-edit" value="'.$DS_LOAI_CONG_VAN->maloai.'" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Sửa</button>'.
                    '<button value="'.$DS_LOAI_CONG_VAN->maloai.'" id="btn-delete" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</button>';
            })
            ->addColumn('STT', function($DS_LOAI_CONG_VAN){})->make(true);
    }

    public function add_loai(Request $req)
    {
        try{
        	$rule = [
        		"MA_LOAI_CONG_VAN" 	=> "unique:loaivanban,maloai",
                "TEN_LOAI_CONG_VAN" => "unique:loaivanban,tenloai",
            ];
            $message = [
            	"MA_LOAI_CONG_VAN.unique"    => "Mã loại công văn đã được sử dụng!",
                "TEN_LOAI_CONG_VAN.unique"   => "Tên loại công văn đã được sử dụng!",   
            ];
            $validator = Validator::make($req->all(), $rule, $message);
            if($validator->fails()){
                return response()->json(['error'=>true, 'message'=>$validator->errors()]);
            }else{
      			$LOAI_CONG_VAN = new Loaivanban();
      			$LOAI_CONG_VAN->maloai = $req->get('MA_LOAI_CONG_VAN');
      			$LOAI_CONG_VAN->tenloai = $req->get('TEN_LOAI_CONG_VAN');
      			$LOAI_CONG_VAN->save();
                return response(['error'=>false, 'message'=>true]);
        	}

        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }

    public function loai_detail($id)
    {
    	$LOAI_CONG_VAN = Loaivanban::where('maloai', $id)->first();
    	if($LOAI_CONG_VAN) return response(['error'=>false, 'message'=>$LOAI_CONG_VAN]);
    	else return response(['error'=>true, 'message'=>false]);
    }

    public function edit_loai(Request $req, $id)
    {
        try{
        	$MA_LOAI_CONG_VAN = $req->get('MA_LOAI_CONG_VAN');
        	$TEN_LOAI_CONG_VAN = $req->get('TEN_LOAI_CONG_VAN');
            $rule  = array();
            $message = array();

        	$LOAI_CONG_VAN = loaivanban::where('maloai', $id)->first();
        	if($LOAI_CONG_VAN){
    			if($LOAI_CONG_VAN->tenloai != $TEN_LOAI_CONG_VAN || $MA_LOAI_CONG_VAN != $LOAI_CONG_VAN->maloai){

                    if($MA_LOAI_CONG_VAN != $LOAI_CONG_VAN->maloai){
                        $rule = array_add($rule, 'MA_LOAI_CONG_VAN', 'unique:loaivanban,maloai');
                        $LOAI_CONG_VAN->maloai = $MA_LOAI_CONG_VAN;
                    }

    	    		if($LOAI_CONG_VAN->tenloai != $TEN_LOAI_CONG_VAN){
                        $rule = array_add($rule, 'TEN_LOAI_CONG_VAN', 'unique:loaivanban,tenloai');
    	    			$LOAI_CONG_VAN->tenloai = $TEN_LOAI_CONG_VAN;
    	    		}

                    $message = [
                        "MA_LOAI_CONG_VAN.unique"    => "Mã loại công văn đã được sử dụng!",
                        "TEN_LOAI_CONG_VAN.unique"   => "Tên loại công văn đã được sử dụng!",   
                    ];

    	    		$validator = Validator::make($req->all(), $rule, $message);
    	    		if($validator->fails()){
    	    			return response()->json(['error'=>true, 'message'=>$validator->errors()]);
    	    		}else{
    	    			$LOAI_CONG_VAN->save();
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

    public function delete_loai(Request $req)
    {
        try{
           $LOAI_CONG_VAN = Loaivanban::where('maloai', $req->get("MA_LOAI_CONG_VAN"))->first();
           if($LOAI_CONG_VAN){
                $LOAI_CONG_VAN->delete();
                return response(['error'=>false, 'message'=>true]);
            }
        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }
}
