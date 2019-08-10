<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nhom, App\Quyennhomnguoidung;
use Validator;
use Session;
use Illuminate\Support\MessageBag;
use Illuminate\Database\QueryException;
use DataTables;
class nhomController extends Controller
{
    public function index()
    {
    	$TIEU_DE = "Danh sách nhóm quyền";
    	return view('NHOM.DS_NHOM', compact('DS_NHOM', 'TIEU_DE'));
    }

    public function data()
    {
        $DS_NHOM = Nhom::orderBy('thoigianthem', 'DESC')->get();
        return DataTables::of($DS_NHOM)
            ->editColumn('thoigianthem', function ($DS_NHOM){
                return date('d-m-Y H:i:s', strtotime($DS_NHOM->thoigianthem) );
            })
            ->addColumn('action', function($DS_NHOM){
                return '<button id="btn-role" value="'.$DS_NHOM->manhom.'" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-id-card-o"></i> Cấp quyền</button>'.
                    '<button id="btn-edit" value="'.$DS_NHOM->manhom.'" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Sửa</button>'.
                    '<button value="'.$DS_NHOM->manhom.'" id="btn-delete" type="button" class="btn btn-default btn-flat btn-xs"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</button>';
            })->addColumn('STT', function($DS_NHOM){})->make(true);
    }

    public function nhom_detail($id)
    {
    	$NHOM = Nhom::where('manhom', $id)->first();
    	if($NHOM)
    		return response(['error'=>false, 'message'=>$NHOM]);
    	else
    		return response(['error'=>true, 'message'=>false]);
    }

    public function add_nhom(Request $request)
    {
        try{
        	$rule = [
        		"MA_NHOM" 	=> "unique:nhom,manhom",
                "TEN_NHOM" => "unique:nhom,tennhom",
            ];
            $message = [
            	"MA_NHOM.unique"    => "Mã nhóm đã được sử dụng!",
                "TEN_NHOM.unique"   => "Tên nhóm đã được sử dụng!",   
            ];
            $validator = Validator::make($request->all(), $rule, $message);
            if($validator->fails()){
                return response()->json(['error'=>true, 'message'=>$validator->errors()]);
            }else{
      			$NHOM = new Nhom();
      			$NHOM->manhom = $request->get('MA_NHOM');
      			$NHOM->tennhom = $request->get('TEN_NHOM');
      			$NHOM->save();
      			return response(['error'=>false, 'message'=>true]);
        	}
        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }

    public function edit_nhom(Request $request, $id)
    {
        try{
        	$MA_NHOM = $request->get('MA_NHOM');
        	$TEN_NHOM = $request->get('TEN_NHOM');
            $rule  = array();
            $message = array();

        	$NHOM = Nhom::where('manhom', $id)->first();
        	if($NHOM){
    			if($NHOM->tennhom != $TEN_NHOM || $MA_NHOM != $NHOM->manhom){

                    if($MA_NHOM != $NHOM->manhom){
                        $rule = array_add($rule, 'MA_NHOM', 'unique:nhom,manhom');
                        $NHOM->manhom = $MA_NHOM;
                    }

    	    		if($NHOM->tennhom != $TEN_NHOM){
                        $rule = array_add($rule, 'TEN_NHOM', 'unique:nhom,tennhom');
    	    			$NHOM->tennhom = $TEN_NHOM;
    	    		}

                    $message = [
                        "MA_NHOM.unique"    => "Mã nhóm quyền đã được sử dụng!",
                        "TEN_NHOM.unique"   => "Tên nhóm quyền đã được sử dụng!",   
                    ];

    	    		$validator = Validator::make($request->all(), $rule, $message);
    	    		if($validator->fails()){
    	    			return response()->json(['error'=>true, 'message'=>$validator->errors()]);
    	    		}else{
    	    			$NHOM->save();
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

    public function delete_nhom(Request $request)
    {
        try{
        	$NHOM = Nhom::where('manhom', $request->get("MA_NHOM"))->first();
        	if($NHOM){
        		$NHOM->delete();
        		return response(['error'=>false, 'message'=>true]);
        	}
        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }

    public function nhom_role($id)
    {
        $QUYEN = Quyennhomnguoidung::where('manhom', $id)->get();
        if($QUYEN)
            return response(['error'=>false, 'message'=>$QUYEN]);
        else
            return response(['error'=>true, 'message'=>false]);
    }

    public function add_role(Request $request, $id)
    {
        try{
            $QUYEN = Quyennhomnguoidung::where('manhom', $id);
            if($QUYEN)
                $QUYEN->delete();


            foreach ($request->get("role") as $key) {
                $QUYEN = new Quyennhomnguoidung ();
                $QUYEN->manhom = $id;
                $QUYEN->quyen  = $key;
                $QUYEN->save();
            }
            $request->session()->flash('status', 'Cấp quyền thành công!');
            return response(['error'=>false, 'message'=>true]);
        }catch(QueryException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }catch(PDOException $ex){
            return response(["error"=>true, "message"=>$ex->getMessage()], 200);
        }
    }
        
}
