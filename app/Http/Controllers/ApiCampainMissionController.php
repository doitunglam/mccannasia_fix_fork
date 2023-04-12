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


}
