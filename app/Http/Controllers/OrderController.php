<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Order as OrderResources;
use App\Http\Requests\OrderRequest;
use Carbon\Carbon;
use DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    
    public function getPaginate(Request $request)
    {
        $order = Order::paginate(15);

        if($order->isEmpty()){
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Data Not Found',
                'responseData' =>  ''
            ], 200);
        } else {
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Success',
                'responseData' =>  $order
            ], 200);
        }
    }

    public function getDetail(Request $request)
    {
        $order = Order::get();

        if($order->isEmpty()){
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Data Not Found',
                'responseData' =>  ''
            ], 200);
        } else {
            return response()->json([
                'responseCode' => true,
                'responseMessage' => 'Success',
                'responseData' =>  $order
            ], 200);
        }
    }

    public function insert(OrderRequest $request)
    {
        $data = $request->all();

        $user_login = Auth::guard()->user()->id;

        $data['created_by'] = $user_login;
        $data['created_at'] = Carbon::now()->toDateTimeString();

        $order = Order::create([
            'id_customer' => $data['id_customer'],
            'order_code' => $this->generateOrderCode(),
            'order_name' => $data['order_name'],
            'order_date' => Carbon::now()->toDateTimeString(),
            'status' => $data['status'],
            'description' => $data['description'],
            'is_active' => 1,
            'created_by' => $data['created_by'],
            'created_at' => $data['created_at'],
        ]);

        if ($order) {
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
        $order = Order::find($request->id);;
        $order->order_name = $request->input('first_name');
        $order->status = $request->input('last_name');
        $order->gender = $request->input('gender');
        $order->description = $request->input('birth_date');
        $order->is_active = $request->input('birth_place');

        if ($order->update()) {
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
        $order = Order::find($request->id);

        if ($order->delete()) {
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

    private function generateOrderCode()
    {
        $new_code = '';
        $prefix = 'ORD';

        $get_latest_code = DB::table('orders')
            ->select('order_code')
            ->orderBy('order_code', 'desc')
            ->first();

        if ($get_latest_code) {
            $latest_code = $get_latest_code->order_code;
            $latest_sequence = explode("_", $latest_code)[1];
            $new_sequence = $latest_sequence + 1;
            $formatted_sequence = str_pad($new_sequence, 4, '0', STR_PAD_LEFT);
            $new_code = $prefix . '_' . $formatted_sequence;
        } else {
            $new_code = $prefix . '_' . '0001';
        }

        return $new_code;
    }
}
