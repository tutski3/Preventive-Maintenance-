<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ICT;
use App\Models\PCDevice;
use App\Models\OtherDevice;
use App\Models\Diagnosis;
use App\Models\Clearance;
use App\Models\User;
use App\Models\PreventiveMaintenance;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\PayUService\Exception;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware(['jwtauth']);
    }

    public function dashboard() {
        try {
            $all_pc_ict_permonth = ICT::select('ict_equipment.device_id','ict_equipment.issuance_date','device_pc.type')
                ->join('device_pc','ict_equipment.device_id', '=', 'device_pc.device_id')
                ->whereYear('ict_equipment.issuance_date', '=', date('Y'))
                ->whereMonth('ict_equipment.issuance_date', '=', date('m'))
                ->get();

            $all_others_ict_permonth = ICT::select('ict_equipment.device_id','ict_equipment.issuance_date','device_others.device_type')
                ->join('device_others','ict_equipment.device_id', '=', 'device_others.device_id')
                ->whereYear('ict_equipment.issuance_date', '=', date('Y'))
                ->whereMonth('ict_equipment.issuance_date', '=', date('m'))
                ->get();


            $all_diagnose_pc_permonth = Diagnosis::select('device_pc.type', 'diagnosis.created_at')
                ->join('device_pc','diagnosis.device_id', '=', 'device_pc.device_id')
                ->whereYear('diagnosis.created_at', '=', date('Y'))
                ->whereMonth('diagnosis.created_at', '=', date('m'))
                ->get(); 

            $all_diagnose_others_permonth = Diagnosis::select('device_others.device_type', 'diagnosis.created_at')
                ->join('device_others','diagnosis.device_id', '=', 'device_others.device_id')
                ->whereYear('diagnosis.created_at', '=', date('Y'))
                ->whereMonth('diagnosis.created_at', '=', date('m'))
                ->get(); 

            $all_pc_ict = ICT::select('ict_equipment.device_id','ict_equipment.center','device_pc.type')
                ->join('device_pc','ict_equipment.device_id', '=', 'device_pc.device_id')
                ->get();

            $all_others_ict = ICT::select('ict_equipment.device_id','ict_equipment.center','device_others.device_type')
                ->join('device_others','ict_equipment.device_id', '=', 'device_others.device_id')
                ->get();
            
            return response()->json(['status'=>'1', 'all_pc_ict_permonth'=>$all_pc_ict_permonth, 'all_others_ict_permonth'=>$all_others_ict_permonth,'all_diagnose_pc_permonth'=>$all_diagnose_pc_permonth,'all_diagnose_others_permonth'=>$all_diagnose_others_permonth,'all_pc_ict'=>$all_pc_ict,'all_others_ict'=>$all_others_ict]);
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }

    public function index(Request $request) {
        try {
            if($request->type == 'pc') {
                if($request->year == 'all') {
                    if($request->center == 'all') {
                        $pc = ICT::select('ict_equipment.user', 'ict_equipment.center', 'ict_equipment.purchase_year', 'ict_equipment.remarks', 'device_pc.property_number', 'device_pc.device_id')
                                ->join('device_pc','ict_equipment.device_id', '=', 'device_pc.device_id')
                                ->orderBy('ict_equipment.purchase_year', 'DESC')
                                ->get();
                    }
                    else {
                        $pc = ICT::select('ict_equipment.user', 'ict_equipment.center', 'ict_equipment.purchase_year', 'ict_equipment.remarks', 'device_pc.property_number', 'device_pc.device_id')
                                ->join('device_pc','ict_equipment.device_id', '=', 'device_pc.device_id')
                                ->where('ict_equipment.center', $request->center)
                                ->orderBy('ict_equipment.purchase_year', 'DESC')
                                ->get();
                    }
                }
                else {
                    if($request->center == 'all') {
                        $pc = ICT::select('ict_equipment.user', 'ict_equipment.center', 'ict_equipment.purchase_year', 'ict_equipment.remarks', 'device_pc.property_number', 'device_pc.device_id')
                            ->join('device_pc','ict_equipment.device_id', '=', 'device_pc.device_id')
                            ->whereYear('ict_equipment.purchase_year', $request->year)
                            ->orderBy('ict_equipment.purchase_year', 'DESC')
                            ->get();
                    }
                    else {
                        $pc = ICT::select('ict_equipment.user', 'ict_equipment.center', 'ict_equipment.purchase_year', 'ict_equipment.remarks', 'device_pc.property_number', 'device_pc.device_id')
                            ->join('device_pc','ict_equipment.device_id', '=', 'device_pc.device_id')
                            ->whereYear('ict_equipment.purchase_year', $request->year)
                            ->where('ict_equipment.center', $request->center)
                            ->orderBy('ict_equipment.purchase_year', 'DESC')
                            ->get();
                    }
                }
                
                return response()->json(['status'=>'1','result'=>$pc]);
            }
            else if($request->type == 'others') {
                if($request->year == 'all') {
                    if($request->center == 'all') {
                        $others = ICT::select('ict_equipment.user', 'ict_equipment.center', 'ict_equipment.purchase_year', 'ict_equipment.remarks', 'device_others.property_number', 'device_others.device_id')
                            ->join('device_others','ict_equipment.device_id', '=', 'device_others.device_id')
                            ->orderBy('ict_equipment.purchase_year', 'DESC')
                            ->get();
                    }
                    else {
                        $others = ICT::select('ict_equipment.user', 'ict_equipment.center', 'ict_equipment.purchase_year', 'ict_equipment.remarks', 'device_others.property_number', 'device_others.device_id')
                            ->join('device_others','ict_equipment.device_id', '=', 'device_others.device_id')
                            ->where('ict_equipment.center', $request->center)
                            ->orderBy('ict_equipment.purchase_year', 'DESC')
                            ->get();
                    }
                }
                else {
                    if($request->center == 'all') {
                        $others = ICT::select('ict_equipment.user', 'ict_equipment.center', 'ict_equipment.purchase_year', 'ict_equipment.remarks', 'device_others.property_number', 'device_others.device_id')
                            ->join('device_others','ict_equipment.device_id', '=', 'device_others.device_id')
                            ->orderBy('ict_equipment.purchase_year', 'DESC')
                            ->whereYear('ict_equipment.purchase_year', $request->year)
                            ->get();
                    }
                    else {
                        $others = ICT::select('ict_equipment.user', 'ict_equipment.center', 'ict_equipment.purchase_year', 'ict_equipment.remarks', 'device_others.property_number', 'device_others.device_id')
                            ->join('device_others','ict_equipment.device_id', '=', 'device_others.device_id')
                            ->whereYear('ict_equipment.purchase_year', $request->year)
                            ->where('ict_equipment.center', $request->center)
                            ->orderBy('ict_equipment.purchase_year', 'DESC')
                            ->get();
                    }
                }
                return response()->json(['status'=>'1','result'=>$others]);
            }
        }
        catch(\Exception $e) {
            return response()->json(['message'=>'0']);
        }
    }

    public function addPC(Request $request) {
        try {
            $pc_req = new PCDevice;
            $pc_req->device_id = 'PC';
            $pc_req->property_number = $request->property_number;
            $pc_req->type = $request->type;
            $pc_req->procie = $request->procie;
            $pc_req->gpu = $request->gpu;
            $pc_req->ram = $request->ram;
            $pc_req->storage = $request->storage;
            $pc_req->os = $request->os;
            $pc_req->office = $request->office;
            $pc_req->ip_lan = $request->ip_lan;
            $pc_req->ip_wlan = $request->ip_wlan;
            $pc_req->mac_lan = $request->mac_lan;
            $pc_req->mac_wlan = $request->mac_wlan;
            $pc_req->save();
    
            PCDevice::where('id', $pc_req->id)->update(['device_id'=>'PC-'.$pc_req->id]);
    
            $ict_details = new ICT;
            $ict_details->user = $request->user;
            $ict_details->center = $request->center;
            $ict_details->unit = $request->unit;
            $ict_details->device_id = 'PC-'.$pc_req->id;
            $ict_details->issuance_date = $request->issuance_date;
            $ict_details->purchase_year = $request->purchase_year;
            $ict_details->remarks = $request->remarks;
            $ict_details->save();
    
            return response()->json(['dev_id'=>'PC-'.$pc_req->id, 'message'=>'Successfully Added!']);
        }
        catch(\Exception $e) {
            return response()->json(['message'=>'0']);
        } 
    }

    public function addOther(Request $request) {
        try {
            $val = $this->validate($request, [
                'property_number' => 'unique:device_others,property_number'
            ]);

            $other_req = new OtherDevice;
            $other_req->device_id = 'PC';
            $other_req->property_number = $request->property_number;
            if($request->ip != '') {
                $other_req->device_name = $request->device_name.' ('.$request->ip.')';
            }
            else {
                $other_req->device_name = $request->device_name;
            }
            $other_req->device_type = $request->device_type;
            $other_req->save();
    
            OtherDevice::where('id', $other_req->id)->update(['device_id'=>'OT-'.$other_req->id]);
    
            $ict_details = new ICT;
            $ict_details->user = $request->user;
            $ict_details->center = $request->center;
            $ict_details->unit = $request->unit;
            $ict_details->device_id = 'OT-'.$other_req->id;
            $ict_details->issuance_date = $request->issuance_date;
            $ict_details->purchase_year = $request->purchase_year;
            $ict_details->remarks = $request->remarks;
            $ict_details->save();
            
            return response()->json(['dev_id'=>'OT-'.$other_req->id, 'message'=>'Successfully Added!']);

        }
        catch(\Exception $e) {
            return response()->json(['message'=>'0']);
        }
        
        

    }

    public function view($id) {
        
        try {
            $type = substr($id,0,2);

            $main = ICT::where('device_id', $id)->get();
            $sec = null;
            if($type == 'PC') {
                $pc = PCDevice::where('device_id', $id)->get();
                $sec = $pc;
            }
            else {
                $other = OtherDevice::where('device_id', $id)->get();
                $sec = $other;
            }

            $diags = Diagnosis::select('diagnosis.control_number','diagnosis.recommendation', DB::raw('DATE_FORMAT(diagnosis.created_at, "%M %d, %Y") as date_issued'),'users.name')
                    ->join('users','diagnosis.user_id','=','users.id')
                    ->where('diagnosis.device_id', '=', $id)
                    ->get();

            return response()->json(['main'=>$main,'sec'=>$sec,'diags_history'=>$diags]);
        }
        catch(\Exception $e) {
            return response()->json(['message'=>'Not Found']);
        }

    }

    public function update(Request $request) {
        try {
            $type = substr($request->device_id,0,2);

            ICT::where('device_id', $request->device_id)
            ->update([
                'user'=>$request->user,
                'center'=>$request->center,
                'unit'=>$request->unit,
                'issuance_date'=>$request->issuance_date,
                'purchase_year'=>$request->purchase_year,
                'remarks'=>$request->remarks
            ]);

            if($type == 'PC') {
                PCDevice::where('device_id', $request->device_id)
                ->update([
                    'property_number'=>$request->property_number,
                    'type'=>$request->type,
                    'procie'=>$request->procie,
                    'gpu'=>$request->gpu,
                    'ram'=>$request->ram,
                    'storage'=>$request->storage,
                    'os'=>$request->os,
                    'office'=>$request->office,
                    'ip_lan'=>$request->ip_lan,
                    'ip_wlan'=>$request->ip_wlan,
                    'mac_lan'=>$request->mac_lan,
                    'mac_wlan'=>$request->mac_wlan
                ]);

            }
            else {
                OtherDevice::where('device_id', $request->device_id)
                ->update([
                    'property_number'=>$request->property_number,
                    'device_name'=>$request->type,
                    'device_type'=>$request->procie,
                ]);
            }

            return response()->json(['status'=>1]);
        }
        catch(\Exception $e) {
            return response()->json(['status'=>0, 'message'=>$e->getMessage()]);
        }
    }

    public function search($val) {
        try {
            $pc = PCDevice::select('device_pc.property_number','device_pc.device_id','ict_equipment.user')->join('ict_equipment','device_pc.device_id','=','ict_equipment.device_id')->where('device_pc.property_number','LIKE','%'.$val.'%')->orWhere('ict_equipment.user','LIKE','%'.$val.'%')->get();
            $other = OtherDevice::select('device_others.property_number', 'device_others.device_id','ict_equipment.user')->join('ict_equipment','device_others.device_id','=','ict_equipment.device_id')->where('device_others.property_number','LIKE','%'.$val.'%')->orWhere('ict_equipment.user','LIKE','%'.$val.'%')->get();
            
            if($pc->isEmpty() && $other->isEmpty()) {
                return response()->json(['status'=>0]);
            }
            else if($pc->isEmpty()) {
                return response()->json(['status'=>2,'result'=>$other]);
            }
            else if($other->isEmpty()) {
                return response()->json(['status'=>3,'result'=>$pc]);
            }
            else {
                return response()->json(['status'=>1,'pc'=>$pc,'other'=>$other]);
            }
            return response()->json(['pc'=>$pc,'other'=>$other]);
        }
        catch(\Exception $e) {
            return response()->json(['status'=>0]);
        }
    }

    public function createDiags(Request $request) {
        try {
            $q = Diagnosis::select('created_at')->whereYear('created_at','=',date('Y'))->get();
            
            $num = count($q);
            $zero_string = '';

            if(strlen($num) == 1) {
                $zero_string = '000';
            }
            else if(strlen($num) == 2) {
                $zero_string = '00';
            }
            else if(strlen($num) == 3) {
                $zero_string = '0';
            }

            $control_number = date('Y').'-'.$zero_string.($num+1);

            $user = auth()->user();
            
            $create_diag = new Diagnosis;
            $create_diag->control_number = $control_number;
            $create_diag->device_id = $request->device_id;
            $create_diag->diagnosis = $request->diagnosis;
            $create_diag->recommendation = $request->recommendation;
            $create_diag->user_id = $user->id;
            $create_diag->approved_by = $request->approved_by;
            $create_diag->approved_position = $request->approved_position;
            $create_diag->save();
            return response()->json(['status'=>'1','control_number'=>$control_number,'name'=>$user->name,'position'=>$user->position]);
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }

    public function indexDiags(Request $request) {
        try {
            if($request->type == 'pc') {
                $pc = Diagnosis::select('diagnosis.control_number', 'diagnosis.diagnosis', 'diagnosis.recommendation', 'diagnosis.approved_by', 'diagnosis.approved_position', DB::raw('DATE_FORMAT(diagnosis.created_at, "%M %d, %Y") as date_issued'),'ict_equipment.user','ict_equipment.center','device_pc.property_number','device_pc.type')
                ->join('device_pc','diagnosis.device_id', '=', 'device_pc.device_id')
                ->join('ict_equipment','device_pc.device_id', '=', 'ict_equipment.device_id')
                ->orderBy('diagnosis.control_number', 'DESC')
                ->get(); 
                
                return response()->json(['status'=>'1','result'=>$pc]);
            }
            else if($request->type == 'others') {
                $others = Diagnosis::select('diagnosis.control_number', 'diagnosis.diagnosis', 'diagnosis.recommendation', 'diagnosis.approved_by', 'diagnosis.approved_position', DB::raw('DATE_FORMAT(diagnosis.created_at, "%M %d, %Y") as date_issued'),'ict_equipment.user','ict_equipment.center','device_others.property_number','device_others.device_type')
                    ->join('device_others','diagnosis.device_id', '=', 'device_others.device_id')
                    ->join('ict_equipment','device_others.device_id', '=', 'ict_equipment.device_id')
                    ->orderBy('diagnosis.control_number', 'DESC')
                    ->get(); 
                
                return response()->json(['status'=>'1','result'=>$others]);
            }
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }

    public function getDiag($cn) {
        try {
            $diag = Diagnosis::where('control_number',$cn)->get();
            if($diag->isEmpty()) {
                return response()->json(['status'=>'0']);
            }
            else {
                $rec_by = User::select('name','position')->where('id', $diag[0]->user_id)->get();

                if(substr($diag[0]->device_id,0,2) == 'PC') {
                    $pc = ICT::select('ict_equipment.user', 'ict_equipment.center', 'device_pc.type', 'device_pc.property_number', 'device_pc.device_id')
                        ->join('device_pc','ict_equipment.device_id', '=', 'device_pc.device_id')
                        ->where('ict_equipment.device_id', $diag[0]->device_id)
                        ->get();
                    return response()->json(['status'=>'1','diag'=>$diag[0],'pc'=>$pc[0],'rec'=>$rec_by[0]]);
                }
                else {
                    $others = ICT::select('ict_equipment.user', 'ict_equipment.center', 'device_others.device_type', 'device_others.property_number', 'device_others.device_id')
                        ->join('device_others','ict_equipment.device_id', '=', 'device_others.device_id')
                        ->where('ict_equipment.device_id', $diag[0]->device_id)
                        ->get();
                    return response()->json(['status'=>'1','diag'=>$diag[0],'others'=>$others[0],'rec'=>$rec_by[0]]);
                }
            }
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }

    public function createClearance(Request $request) {
        try {
            $q = Clearance::select('created_at')->whereYear('created_at','=',date('Y'))->get();
            
            $num = count($q);
            $zero_string = '';

            if(strlen($num) == 1) {
                $zero_string = '000';
            }
            else if(strlen($num) == 2) {
                $zero_string = '00';
            }
            else if(strlen($num) == 3) {
                $zero_string = '0';
            }

            $control_number = date('Y').'-'.$zero_string.($num+1);

            $user = auth()->user();
            
            $create_clearance = new Clearance;
            $create_clearance->control_number = $control_number;
            $create_clearance->specs_within_standard_minimum_req = $request->specs_within_standard_minimum_req;
            $create_clearance->revised_specs = $request->revised_specs;
            $create_clearance->item_cleared_for = $request->item_cleared_for;
            $create_clearance->item_already_purchased = $request->item_already_purchased;
            $create_clearance->replacement = $request->replacement;
            $create_clearance->repair = $request->repair;
            $create_clearance->others = $request->others;
            $create_clearance->user_id = $user->id;
            $create_clearance->approved_by = $request->approved_by;
            $create_clearance->approved_position = $request->approved_position;
            $create_clearance->save();
            return response()->json(['status'=>'1','control_number'=>$control_number,'name'=>$user->name,'position'=>$user->position]);
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }

    public function indexClearance() {
        try {
            $clearance = Clearance::select('clearance.control_number', 'clearance.specs_within_standard_minimum_req', 'clearance.revised_specs', 'clearance.item_cleared_for', 'clearance.item_already_purchased', 'clearance.replacement', 'clearance.repair', 'clearance.others', 'clearance.approved_by', 'clearance.approved_position', DB::raw('DATE_FORMAT(clearance.created_at, "%M %d, %Y") as date_issued'))
            ->orderBy('clearance.control_number', 'DESC')
            ->get(); 
            
            return response()->json(['status'=>'1','result'=>$clearance]);
            
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }

    public function getClearance($cn) {
        try {
            $clearance = Clearance::where('control_number',$cn)->get();
            if($clearance->isEmpty()) {
                return response()->json(['status'=>'0']);
            }
            else {
                $rec_by = User::select('name','position')->where('id', $clearance[0]->user_id)->get();

                return response()->json(['status'=>'1','clearance'=>$clearance[0],'rec'=>$rec_by[0]]);
                
            }
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }
	
	public function indexAndroid($device_id) {
        try {
            if(substr($device_id,0,2) == 'PC') {
                $get_item = ICT::select('ict_equipment.user', 'ict_equipment.center', 'device_pc.type', 'device_pc.ip_lan', 'device_pc.mac_lan', 'device_pc.mac_wlan', 'ict_equipment.issuance_date', 'ict_equipment.purchase_year', 'device_pc.property_number', 'device_pc.device_id')
                    ->join('device_pc','ict_equipment.device_id', '=', 'device_pc.device_id')
                    ->where('ict_equipment.device_id', $device_id)
                    ->get();
            }
            else if(substr($device_id,0,2) == 'OT') {
                $get_item = ICT::select('ict_equipment.user', 'ict_equipment.center', 'ict_equipment.issuance_date', 'ict_equipment.purchase_year', 'device_others.property_number', 'device_others.device_id', 'device_others.device_name', 'device_others.device_type')
                    ->join('device_others','ict_equipment.device_id', '=', 'device_others.device_id')
                    ->where('ict_equipment.device_id', $device_id)
                    ->get();
            }

            return $get_item;
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }
	
    public function addMaintenance(Request $request) {
        try {
			$user = auth()->user();
            $prev_main = new PreventiveMaintenance;
			$prev_main->device_id = $request->device_id;
			$prev_main->user_id = $user->id;
			$prev_main->remarks = $request->remarks;
			$prev_main->save();
			
			return '1';
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }

    public function indexPreventiveMaintenance(Request $request) {
        try{
            if($request->from && $request->to) {
                $data = PreventiveMaintenance::select('ict_equipment.device_id','preventive_maintenance.remarks', DB::raw('DATE_FORMAT(preventive_maintenance.created_at, "%M %d, %Y") as date_issued'), 'users.name', 'ict_equipment.user', 'ict_equipment.center', 'device_pc.property_number')
                                            ->join('device_pc','preventive_maintenance.device_id', '=', 'device_pc.device_id')
                                            ->join('ict_equipment','device_pc.device_id', '=', 'ict_equipment.device_id')
                                            ->join('users','preventive_maintenance.user_id','=','users.id')
                                            ->whereBetween('preventive_maintenance.created_at', [$request->from, $request->to])
                                            ->get();
            }
            else {
                $data = PreventiveMaintenance::select('ict_equipment.device_id','preventive_maintenance.remarks', DB::raw('DATE_FORMAT(preventive_maintenance.created_at, "%M %d, %Y") as date_issued'), 'users.name', 'ict_equipment.user', 'ict_equipment.center', 'device_pc.property_number')
                                            ->join('device_pc','preventive_maintenance.device_id', '=', 'device_pc.device_id')
                                            ->join('ict_equipment','device_pc.device_id', '=', 'ict_equipment.device_id')
                                            ->join('users','preventive_maintenance.user_id','=','users.id')
                                            ->whereYear('preventive_maintenance.created_at', '=', date('Y'))
                                            ->whereMonth('preventive_maintenance.created_at', '=', date('m'))
                                            ->get();
            }

            return response()->json(['status'=>'1','data'=>$data]);
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }
}
