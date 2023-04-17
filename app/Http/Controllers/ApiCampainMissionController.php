<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Models\CampainMission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiCampainMissionController extends Controller
{

    public function list(Request $request)
    {
        $items = CampainMission::query()->paginate(20);
        return response()->json([
                'status' => 'success',
                'items' => $items,
            ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
			'name'          => 'required|max:255',
			'binding_fee'   => 'required',
			'daily_profit'  => 'required',
			'contract_term' => 'required',
			'content'       => 'required',
		]);
        if($request->id) {
            $item = CampainMission::query()->find($request->id);
            $item->update($request->all());
        } else {
            $item = new CampainMission($request->all());
            $item->save();
        }
        return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
            ]);
    }
    public function getModelById(Request $request) {
        $item = CampainMission::query()->find($request->id);
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
    public function deleteItemById(Request $request) {
        $item = CampainMission::query()->find($request->id);
        if(!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy dữ liệu',
            ]);
        }
        $item->delete();
        return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công',
            ]);
    }

}
