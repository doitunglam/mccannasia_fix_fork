<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Goeasyapp\Core\Http\Repositories\CampainRepository;

class ApiRechargeController extends Controller
{
    private $useRepository;
    public function __construct( CampainRepository $UserRepository)
    {
        $this->useRepository = $UserRepository;
    }
    public function list(Request $request)
    {
        $items = $this->useRepository->getAdminPaymentRecharge_Withdraw($request, 1);
        return response()->json([
                'status' => 'success',
                'items' => $items,
            ]);
    }


}
