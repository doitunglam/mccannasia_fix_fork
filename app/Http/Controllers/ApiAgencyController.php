<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApiAgencyController extends Controller
{
    public function list(Request $request)
    {
        $items = User::leftJoin('payments', function ($join) {
            $join->on('users.id', '=', 'payments.user')
                 ->where('payments.status', '=', 1)
                 ->where(function ($query) {
                     $query->where('payments.type', '=', 1)
                           ->orWhereNull('payments.type');
                 });
        })
        ->where('users.type', '=', 'agency')
        ->where('users.close_account', '=', null)
        ->orderBy('users.updated_at', 'DESC')
        ->select('users.*', DB::raw('SUM(CASE WHEN payments.type = 1 THEN payments.amount ELSE 0 END) as sum_recharge'), DB::raw('SUM(CASE WHEN payments.type IS NULL THEN payments.amount ELSE 0 END) as sum_withdraw'))
        ->groupBy('users.id')
        ->get();
        return response()->json([
                'status' => 'success',
                'items' => $items,
            ]);
    }
    public function store(Request $request){
        $id=$request->id;
        if (!$id) {
            $request->validate([
                'phone' => 'required',
            ]);
        }
        if (!$id) {
            $check = User::where('phone', $request->phone)->first();
            if ($check) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email exist',
                ]);
            }
            $model = new User;
        } else {
            $model = User::find($id);
        }
        $model->name = $request->name;
        $model->email = $request->email;
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->type = "agency";
        $model->gender = $request->gender;
        $model->bank_name = $request->bank_name;
        $model->bank_name_account = $request->bank_name_account;
        $model->bank_account = $request->bank_account;
        $model->referral_code = $request->referral_code;
        if (! empty($request->password))
            $model->password = bcrypt($request->password);
        $model->save();
    }
    public function getModelById(Request $request) {
        $item = User::find($request->id);
        if(!$item)
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy dữ liệu',
            ]);
        return response()->json([
                'status' => 'success',
                'item' => $item,
            ]);
    }
    public function resetPassword(Request $request)
    {
        $id=$request->id;
        $item = User::find($id);
        $item->password = bcrypt('mccannasia@123');
        $item->save();
        return response()->json([
                'status' => 'success',
                'message' => 'Đã reset mật khẩu thành công',
            ]);
    }

    public function block(Request $request) {
        $id=$request->id;
        $item = User::find($id);
        if ($item->status == 1) {
            $item->status = 0;
        } else {
            $item->status = 1;
        }
        $item->save();
        return response()->json([
                'status' => 'success',
                'message' => 'Đã cập nhật thành công',
            ]);
    }

    public function changeAmount(Request $request) {
        $id=$request->id;
        $item = User::find($id);
        $amount = $item->amount + $request->plus_amount;
        $item->amount = $amount;
        $item->save();
        return response()->json([
                'status' => 'success',
                'message' => 'Đã cập nhật thành công',
            ]);
    }

}
