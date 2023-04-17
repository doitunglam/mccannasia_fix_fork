<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiAgencyController extends Controller
{


    public function list(Request $request)
    {
        $items = User::orderBy('updated_at', 'DESC')->where('type', 'agency')->where('close_account', null)->get();
        return response()->json([
                'status' => 'success',
                'items' => $items,
            ]);

    }


}
