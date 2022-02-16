<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Customer as CustomerResources;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Carbon\Carbon;
use DB;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    
    public function getPaginate(Request $request)
    {
        $customer = Customer::paginate(15);

        if($customer->isEmpty()){
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Data Not Found',
                'responseData' =>  ''
            ], 200);
        } else {
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Success',
                'responseData' =>  $customer
            ], 200);
        }
    }

    public function getDetail(Request $request)
    {
        $customer = Customer::get();

        if($customer->isEmpty()){
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Data Not Found',
                'responseData' =>  ''
            ], 200);
        } else {
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Success',
                'responseData' =>  $customer
            ], 200);
        }
    }

    public function insert(CustomerRequest $request)
    {
        $data = $request->all();

        $user_login = Auth::guard()->user()->id;

        $data['created_by'] = $user_login;
        $data['created_at'] = Carbon::now()->toDateTimeString();

        $customer = Customer::create([
            'id_user' => $data['id_user'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'birth_date' => $data['birth_date'],
            'birth_place' => $data['birth_place'],
            'address' => $data['address'],
            'created_by' => $data['created_by'],
            'created_at' => $data['created_at'],
        ]);

        if ($customer) {
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Success added',
                'responseData' =>  $data
            ], 201);
        } else {
            return response()->json([
                'responseCode' => false,
                'responseMessage' => 'failed',
                'responseData' =>  $data
            ], 405);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $customer = Customer::find($request->id);;
        $customer->first_name = $request->input('first_name');
        $customer->last_name = $request->input('last_name');
        $customer->gender = $request->input('gender');
        $customer->birth_date = $request->input('birth_date');
        $customer->birth_place = $request->input('birth_place');
        $customer->address = $request->input('address');

        if ($customer->update()) {
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Updated Success',
                'responseData' =>  $data
            ], 201);
        } else {
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'failed',
                'responseData' =>  $data
            ], 405);
        }
    }

    public function delete(Request $request)
    {
        $data = $request->all();
        $customer = Customer::find($request->id);

        if ($customer->delete()) {
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Delete Success',
                'responseData' =>  $data
            ], 201);
        } else {
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Failed',
                'responseData' =>  $data
            ], 405);
        }
    }
}
