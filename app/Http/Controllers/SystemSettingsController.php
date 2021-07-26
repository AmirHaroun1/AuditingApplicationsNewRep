<?php

namespace App\Http\Controllers;

use App\AccountLVL1;
use App\AccountLVL2;
use App\AccountLVL3;
use App\AccountLVL4;
use App\AccountRepository;
use App\RevisingGuid;
use App\SystemSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemSettingsController extends Controller
{
    //

    public function DropDownIndex(){

        if(\request()->expectsJson()){
            $DropDownsOptions = SystemSettings::where('type','LIKE','قائمة منسدلة')->get(['id','type','name','value']);

            return response()->json(['DropDownsOptions'=>$DropDownsOptions],200);
        }
        return view('SuperAdmin.DropDowns.index');
    }
    public function StoreDropDownOption(Request $request){

        $DropDownOption = SystemSettings::create($request->all());

        return response()->json([$DropDownOption],200);
    }
    public function DeleteDropDownOption($dropdownID,Request $request){

        SystemSettings::destroy($dropdownID);

        return response()->json([],200);
    }

    public function UpdateDropDownOption($dropdownID,Request $request){

        $systemDropDown = SystemSettings::findOrFail($dropdownID);
        $systemDropDown->update($request->all());
        return response()->json([],200);
    }
    public function AccountChartsIndex(){

        if(\request()->expectsJson()){

            $AccountCharts = AccountLVL1::WithAllChildren()->paginate(10);
            return response()->json(['AccountChartsWithChildren'=>$AccountCharts],200);
        }

         return view('SuperAdmin.AccountCharts.index');
    }
    public function RetrieveAllAccountCharts(){

        $allAccounts = AccountRepository::GetAllAccountCharts();

        return response()->json($allAccounts);
    }

    public function AccountChartsStore(Request $request){

        $account = AccountRepository::CreateAccountChart($request);

        return response()->json($account);
    }
    public function AccountChartsDelete($id,$level){

        AccountRepository::DeleteAccount($id,$level);

        return response()->json();
    }
    public function AccountChartsUpdate(Request $request){

        $account =  AccountRepository::UpdateAccountChart($request);

        return response()->json($account);
    }

    public function GetStandardTime(){
        $StandardTime = DB::table('standard_time')->selectRaw('*')->first();
        return response()->json(['StandardTime' => $StandardTime],200);
    }
    public function StoreStandardTime(Request $request){
        $StandardTime = DB::table('standard_time')->insert([
            'secretary_time' => $request->secretary_time,
            'fieldDelegate_time'=> $request->fieldDelegate_time,
            'auditor_time' => $request->auditor_time,
            'executiveDirector_time'=>$request->executiveDirector_time,
            'Managing_partner_time' => $request->Managing_partner_time,
            'reviser_time' => $request->reviser_time,
            'revisingManager_time' => $request->revisingManager_time,
            'helper_time' => $request->helper_time
        ]);
        return response()->json(['StandardTime' => $StandardTime],200);
    }
    public function UpdateStandardTime(Request $request){
        $StandardTime = DB::table('standard_time')
            ->where('id',1)
            ->update([
                'secretary_time' => $request->secretary_time,
                'fieldDelegate_time'=> $request->fieldDelegate_time,
                'auditor_time' => $request->auditor_time,
                'executiveDirector_time'=>$request->executiveDirector_time,
                'Managing_partner_time' => $request->Managing_partner_time,
                'reviser_time' => $request->reviser_time,
                'revisingManager_time' => $request->revisingManager_time,
                'helper_time' => $request->helper_time
             ]);
        return response()->json(['StandardTime' => $StandardTime],200);
    }
}
