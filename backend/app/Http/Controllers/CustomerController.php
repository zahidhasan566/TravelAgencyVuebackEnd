<?php

namespace App\Http\Controllers;

use App\Models\CustomerDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;

class CustomerController extends Controller
{

    public function index() {
        $customer = CustomerDetail::select(
            'customer_details.name',
            'customer_details.id',
            'customer_details.age',
            'customer_details.select_sms',
            'customer_details.transport',
            'customer_details.gender',
            'customer_details.priority',
            'customer_details.comments',
            'users.email',
            'users.id as user_id'
        )
        ->leftjoin('users','users.id','customer_details.fk_user_id')
        ->get();


        return response()->json(['customers'=>$customer]);

    }
    public function insert(Request $request) {

        DB::transaction(function () use ($request) {

            $user = new User();
            $user->name= $request->Name;
            $user->email= $request->Email;
            $user->password= Hash::make($request->password);
            $user->save();

            $user->assignRole('Customer');

            $customer = new CustomerDetail();
            $customer->fk_user_id=$user->id;
            $customer->name=$request->Name;
            $customer->age=$request->age;
            $customer->select_sms=$request->SendSMS;
            $customer->transport=$request->Transport;
            $customer->gender=$request->Gender;
            $customer->priority=$request->Priority;
            $customer->comments=$request->Message;
            $customer->save();

            return back();

        });
       //return ($request) ;
    }
    public function update(Request $request) {
        //return $request->Id;
        //$customer_update=  CustomerDetail::findOrFail($request->Id);
        $customer_update= CustomerDetail::select(
            'customer_details.name',
            'customer_details.id',
            'customer_details.age',
            'customer_details.select_sms',
            'customer_details.transport',
            'customer_details.gender',
            'customer_details.priority',
            'customer_details.comments',
            'users.email'
        )
            ->leftjoin('users','users.id','customer_details.fk_user_id')
            ->where('customer_details.id',$request->Id,)
            ->first();
        return response()->json(['customers_update'=>$customer_update]);

    }
    public function update_confirm(Request $request) {
        $customer_update_confirm=  CustomerDetail::findOrFail($request->Id);
        $customer_update_confirm->name=$request->Name;
        $customer_update_confirm->age=$request->age;
        $customer_update_confirm->select_sms=$request->SendSMS;
        $customer_update_confirm->transport=$request->Transport;
        $customer_update_confirm->gender=$request->Gender;
        $customer_update_confirm->priority=$request->Priority;
        $customer_update_confirm->comments=$request->Message;
        $customer_update_confirm->save();
        $user_mail= User::select('users.email')->where('users.id',$customer_update_confirm->fk_user_id)->first();
        $user_mail->email=$request->Email;
        $user_mail->save();
        return response()->json(['success']);
    }
    public function delete(Request $request) {
        $customer=  CustomerDetail::findOrFail($request->Id);
        $customer->delete();
        return response()->json(['success']);
    }
}
