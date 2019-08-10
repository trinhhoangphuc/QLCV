<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donvi;
use Validator;
use Session;
use Illuminate\Support\MessageBag;
use Illuminate\Database\QueryException;
use DataTables;

class donviController extends Controller
{
    public function index()
    {
    	$TIEU_DE = "Danh sách đơn vị";
    	return view('DONVI.DS_DON_VI', compact('TIEU_DE'));
    }

    public function data()
    {
        $DS_DON_VI = Donvi::orderBy('thoigianthem', 'DESC')->get();
        return DataTables::of($DS_DON_VI)
            ->editColumn('thoigianthem', function ($DS_DON_VI){
                return date('d-m-Y H:i:s', strtotime($DS_DON_VI->thoigianthem) );
            })
            ->addColumn('action', function($DS_DON_VI){
                return '<button id="btn-edit" value="'.$DS_DON_VI->madonvi.'" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Sửa</button>'.
                    '<button value="'.$DS_DON_VI->madonvi.'" id="btn-delete" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</button>';
            })
            ->addColumn('STT', function($DS_DON_VI){})->make(true);
    }

    public function add_don_vi(Request $req)
    {
        try{
        	$rule = [
        		"MA_DON_VI" 	=> "unique:donvi,madonvi",
                "EMAIL_DON_VI"  => "unique:donvi,email",
                "TEN_DON_VI" => "unique:donvi,tendonvi",
            ];
            $message = [
            	"MA_DON_VI.unique"    => "Mã đơn vị đã được sử dụng!",
                "EMAIL_DON_VI.unique" => "Email đơn vị đã được sử dụng!",
                "TEN_DON_VI.unique"   => "Tên đơn vị đã được sử dụng!",   
            ];
            $validator = Validator::make($req->all(), $rule, $message);
            if($validator->fails()){
                return response()->json(['error'=>true, 'message'=>$validator->errors()]);
            }else{
      			$DON_VI = new Donvi();
      			$DON_VI->madonvi = $req->get('MA_DON_VI');
      			$DON_VI->email = $req->get('EMAIL_DON_VI');
      			$DON_VI->tendonvi = $req->get('TEN_DON_VI');
      			$DON_VI->save();
                $req->session()->flash('status', 'Thêm đơn vị thành công!');
                return response(['error'=>false, 'message'=>true]);
        	}

        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }

    public function edit_don_vi(Request $req, $id)
    {
        try{
        	$MA_DON_VI = $req->get('MA_DON_VI');
        	$TEN_DON_VI = $req->get('TEN_DON_VI');
        	$EMAIL_DON_VI = $req->get('EMAIL_DON_VI');
            $rule  = array();
            $message = array();

        	$DON_VI = Donvi::where('madonvi', $id)->first();
        	if($DON_VI){
    			if($DON_VI->tendonvi != $TEN_DON_VI || $DON_VI->email != $EMAIL_DON_VI || $MA_DON_VI != $DON_VI->madonvi){

                    if($MA_DON_VI != $DON_VI->madonvi){
                        $rule = array_add($rule, 'MA_DON_VI', 'unique:donvi,madonvi');
                        $DON_VI->madonvi = $MA_DON_VI;
                    }

    	    		if($DON_VI->tendonvi != $TEN_DON_VI){
                        $rule = array_add($rule, 'TEN_DON_VI', 'unique:donvi,tendonvi');
    	    			$DON_VI->tendonvi = $TEN_DON_VI;
    	    		}

                    if($DON_VI->email != $EMAIL_DON_VI){
                        $rule = array_add($rule, 'EMAIL_DON_VI', 'unique:donvi,email');
    	    			$DON_VI->email = $EMAIL_DON_VI;
    	    		}

                    $message = [
                        "MA_DON_VI.unique"    => "Mã đơn vị đã được sử dụng!",
                        "EMAIL_DON_VI.unique" => "Email đơn vị đã được sử dụng!",
                        "TEN_DON_VI.unique"   => "Tên đơn vị đã được sử dụng!",   
                    ];

    	    		$validator = Validator::make($req->all(), $rule, $message);
    	    		if($validator->fails()){
    	    			return response()->json(['error'=>true, 'message'=>$validator->errors()]);
    	    		}else{
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
    	$DON_VI = Donvi::where('madonvi', $id)->first();
    	if($DON_VI) return response(['error'=>false, 'message'=>$DON_VI]);
    	else return response(['error'=>true, 'message'=>false]);
    }

    public function delete_don_vi(Request $req)
    {
        try{
           $DON_VI = Donvi::where('madonvi', $req->get("MA_DON_VI"))->first();
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
