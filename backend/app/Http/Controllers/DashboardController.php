<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard( Request $request){

        $roles= Db::table('model_has_roles')->select('roles.name'
        )
            ->leftJoin('roles','roles.id','model_has_roles.role_id')
            ->where('model_has_roles.model_id',$request->id)
            ->first();
        return response()->json(['roles'=>$roles]);
    }
}
