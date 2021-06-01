<?php

namespace App\Http\Controllers;

use App\employee;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{
    public function show(employee $employee){
        if(Auth::id() != $employee->id){
            return abort('403','UnAuthorized Action');
        }
        return view('employee.profile',compact('employee'));
    }

    public function update(UpdateEmployeeRequest $request,employee $employee){
        $employee->UpdateUserInfo($request);
        return response()->json(['employee'=>$employee],200);
    }
}
