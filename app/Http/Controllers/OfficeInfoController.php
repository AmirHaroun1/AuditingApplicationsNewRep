<?php

namespace App\Http\Controllers;

use App\SystemSettings;
use Illuminate\Http\Request;

class OfficeInfoController extends Controller
{
    //
    public function GetOfficeInfo(){

        $OfficeInfo = SystemSettings::where('type','Like','بيانات المكتب')->first();

        return view('SuperAdmin.OfficeInfo.index',compact('OfficeInfo'));
    }
    public function StoreOfficeInfo(Request $request){
        if($request->has('logo')){
            $logoPath = $request['logo']->store('OfficeLogo');
            SystemSettings::create( array_merge($request->except('logo'),['type'=>'بيانات المكتب','logo'=>$logoPath]) );
        }else{
            SystemSettings::create( array_merge($request->all(),['type'=>'بيانات المكتب']) );
        }
        return response()->json('',200);
    }
    public function UpdateOfficeInfo(Request $request){
        $OfficeInfo = SystemSettings::where('type','Like','بيانات المكتب')->firstOrFail();
        if($request->has('logo')){

            unlink('/storage/OfficeLogo/'.$OfficeInfo->logo);

            $logoPath = $request['logo']->store('OfficeLogo');

            $OfficeInfo->update($request->except('logo'),['logo'=>$logoPath]);
        }else{
            $OfficeInfo->update($request->all());
        }
        return response()->json('',200);
    }
}
