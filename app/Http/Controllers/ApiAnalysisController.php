<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Goeasyapp\Core\Http\Repositories\CampainRepository;

class ApiAnalysisController extends Controller
{
    private $useRepository;
    public function __construct( CampainRepository $UserRepository)
    {
        $this->useRepository = $UserRepository;
    }
    public function list(Request $request)
    {
        $totalRechargeAmountToday = $this->useRepository->getTotalRechargeAmountToday();
        $totalWithdrawAmountToday = $this->useRepository->getTotalWithdrawAmountToday();
        $totalUserRegisterToday = $this->useRepository->getTotalUserRegisterToday();
        $topUserMostRefer = $this->useRepository->getTop5UserMostReferralCode();
        return response()->json([
                'status' => 'success',
                'data' => [
                    'totalRechargeAmountToday' => $totalRechargeAmountToday,
                    'totalWithdrawAmountToday' => $totalWithdrawAmountToday,
                    'totalUserRegisterToday' => $totalUserRegisterToday,
                    'topByReferralCode' => $topUserMostRefer['topByReferralCode'],
                    'topByRechargeAmount' => $topUserMostRefer['topByRechargeAmount'],
                    'topByWithdrawAmount' => $topUserMostRefer['topByWithdrawAmount'],
                ]
            ]);
    }


}
