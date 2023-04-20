<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApiImageController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('image');
        // ramdom uniq name
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('upload/images/files'), $filename);
        return response()->json([
            'status' => 'success',
            'image_path' => $filename,
        ]);
    }

}
