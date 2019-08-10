<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donvibanhanh;
use Validator;
use Session;
use Illuminate\Support\MessageBag;
use DataTables;
use Illuminate\Database\QueryException;

class donvibanhanhController extends Controller
{
    public function index()
    {
    	$TIEU_DE = "Danh sách đơn vị";
    	
    	return view('DONVIBANHANH.DS_DON_VI_BAN_HANH', compact('DS_DON_VI_BAN_HANH', 'TIEU_DE'));
    }

    public function data()
    {
        $DS_DON_VI_BAN_HANH = Donvibanhanh::orderBy('thoigianthem', 'DESC')->get();
        return DataTables::of($DS_DON_VI_BAN_HANH)
            ->editColumn('thoigianthem', function ($DS_DON_VI_BAN_HANH){
                return date('d-m-Y H:i:s', strtotime($DS_DON_VI_BAN_HANH->thoigianthem) );
            })
            ->editColumn('benngoai', function ($DS_DON_VI_BAN_HANH){
                $LOAI_DON_VI = ($DS_DON_VI_BAN_HANH->benngoai == 1) ? "Ngoài" : "Trong";
                return $LOAI_DON_VI;
            })
            ->addColumn('STT', function($DS_DON_VI_BAN_HANH){})
            ->addColumn('action', function($DS_DON_VI_BAN_HANH){
                return '<button id="btn-edit" value="'.$DS_DON_VI_BAN_HANH->madonvi.'" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Sửa</button>'.
                    '<button value="'.$DS_DON_VI_BAN_HANH->madonvi.'" id="btn-delete" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</button>';
            })->make(true);
    }

    public function add_don_vi(Request $request)
    {
        try{
        	$rule = [
        		"MA_DON_VI" 	=> "unique:donvibanhanh,madonvi",
                "EMAIL_DON_VI"  => "unique:donvibanhanh,email",
                "TEN_DON_VI" => "unique:donvibanhanh,tendonvi",
                "SO_DIEN_THOAI" => "unique:donvibanhanh,sodienthoai",
            ];
            $message = [
            	"MA_DON_VI.unique"    => "Mã đơn vị đã được sử dụng!",
                "EMAIL_DON_VI.unique" => "Email đơn vị đã được sử dụng!",
                "TEN_DON_VI.unique"   => "Tên đơn vị đã được sử dụng!",
                "SO_DIEN_THOAI.unique"   => "Tên đơn vị đã được sử dụng!",    
            ];
            $validator = Validator::make($request->all(), $rule, $message);
            if($validator->fails()){
                return response()->json(['error'=>true, 'message'=>$validator->errors()]);
            }else{
      			$DON_VI = new Donvibanhanh();
      			$DON_VI->madonvi = $request->get('MA_DON_VI');
      			$DON_VI->email = $request->get('EMAIL_DON_VI');
      			$DON_VI->tendonvi = $request->get('TEN_DON_VI');
                $DON_VI->sodienthoai = $request->get('SO_DIEN_THOAI');
                $DON_VI->benngoai = $request->get('LOAI_DON_VI');
                $DON_VI->diachi = $request->get('DIA_CHI');
      			$DON_VI->save();
      			return response(['error'=>false, 'message'=>true]);
        	}
        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }

    public function edit_don_vi(Request $request, $id)
    {
        try{
        	$MA_DON_VI     = $request->get('MA_DON_VI');
        	$TEN_DON_VI    = $request->get('TEN_DON_VI');
        	$EMAIL_DON_VI  = $request->get('EMAIL_DON_VI');
            $DIA_CHI       = $request->get('DIA_CHI');
            $SO_DIEN_THOAI = $request->get('SO_DIEN_THOAI');
            $LOAI_DON_VI   = $request->get('LOAI_DON_VI');

            $rule  = array();
            $message = array();

        	$DON_VI = Donvibanhanh::where('madonvi', $id)->first();
        	if($DON_VI){
    			if($DON_VI->tendonvi != $TEN_DON_VI || $DON_VI->email != $EMAIL_DON_VI || $MA_DON_VI != $DON_VI->madonvi || $SO_DIEN_THOAI != $DON_VI->sodienthoai){

                    if($MA_DON_VI != $DON_VI->madonvi){
                        $rule = array_add($rule, 'MA_DON_VI', 'unique:donvibanhanh,madonvi');
                        $DON_VI->madonvi = $MA_DON_VI;
                    }

    	    		if($DON_VI->tendonvi != $TEN_DON_VI){
                        $rule = array_add($rule, 'TEN_DON_VI', 'unique:donvibanhanh,tendonvi');
    	    			$DON_VI->tendonvi = $TEN_DON_VI;
    	    		}

                    if($DON_VI->email != $EMAIL_DON_VI){
                        $rule = array_add($rule, 'EMAIL_DON_VI', 'unique:donvibanhanh,email');
    	    			$DON_VI->email = $EMAIL_DON_VI;
    	    		}

                    if($DON_VI->sodienthoai != $SO_DIEN_THOAI){
                        $rule = array_add($rule, 'SO_DIEN_THOAI', 'unique:donvibanhanh,sodienthoai');
                        $DON_VI->sodienthoai = $SO_DIEN_THOAI;
                    }

                    $message = [
                        "MA_DON_VI.unique"    => "Mã đơn vị đã được sử dụng!",
                        "EMAIL_DON_VI.unique" => "Email đơn vị đã được sử dụng!",
                        "TEN_DON_VI.unique"   => "Tên đơn vị đã được sử dụng!",
                        "SO_DIEN_THOAI.unique"   => "số diện thoại đã được sử dụng!",   
                    ];

    	    		$validator = Validator::make($request->all(), $rule, $message);
    	    		if($validator->fails()){
    	    			return response()->json(['error'=>true, 'message'=>$validator->errors()]);
    	    		}else{
                        $DON_VI->diacHi = $DIA_CHI;
                        $DON_VI->benngoai = $LOAI_DON_VI;
    	    			$DON_VI->save();
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

    public function don_vi_detail($id)
    {
    	$DON_VI = Donvibanhanh::where('madonvi', $id)->first();
    	if($DON_VI)
    		return response(['error'=>false, 'message'=>$DON_VI]);
    	else
    		return response(['error'=>true, 'message'=>false]);
    }

    public function delete_don_vi(Request $request)
    {
        try{
            $DON_VI = Donvibanhanh::where('madonvi', $request->get("MA_DON_VI"))->first();
            if($DON_VI){
                $DON_VI->delete();
                return response(['error'=>false, 'message'=>true]);
            }
        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }
}
