<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiCampainController extends Controller
{
    private $model;
    private $useRepository;
    public function __construct(CampainRepository $UserRepository)
    {
        $this->useRepository = $UserRepository;
    }


    public function list(Request $request)
    {
        $items = $this->useRepository->getPaginateWithRelation();
        return response()->json([
                'status' => 'success',
                'items' => $items,
            ]);

    }


}
