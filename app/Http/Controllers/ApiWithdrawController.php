<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Goeasyapp\Core\Http\Repositories\CampainRepository;

class ApiWithDrawController extends Controller
{
    private $useRepository;
    public function __construct( CampainRepository $UserRepository)
    {
        $this->useRepository = $UserRepository;
    }
    public function list(Request $request)
    {
        $items = $this->useRepository->getAdminPaymentRecharge_Withdraw($request, null);
        return response()->json([
                'status' => 'success',
                'items' => $items,
            ]);
    }


}
