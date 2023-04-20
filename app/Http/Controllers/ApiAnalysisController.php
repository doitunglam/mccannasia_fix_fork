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
        $totalRechargeAmountToday = 0;
        $totalWithdrawAmountToday = 0;
        $totalUserRegisterToday = null;
        $topUserMostRefer = null;
        $topWithdrawPending = null;
        $topRechargePending = null;
        if($request->from || $request->to) {
            $totalRechargeAmountToday = $this->useRepository->getTotalRechargeAmountByDateRange($request);
            $totalWithdrawAmountToday = $this->useRepository->getTotalWithdrawAmountByDateRange($request);
            $totalUserRegisterToday = $this->useRepository->getTotalUserRegisterByDateRange($request);
            $topUserMostRefer = $this->useRepository->getTop5UserMostReferralCodeByDateRange($request);
            $topWithdrawPending = $this->useRepository->getTopWithdrawPendingByDateRange($request);
            $topRechargePending = $this->useRepository->getTopRechargePendingByDateRange($request);
        } else {
            $totalRechargeAmountToday = $this->useRepository->getTotalRechargeAmountToday();
            $totalWithdrawAmountToday = $this->useRepository->getTotalWithdrawAmountToday();
            $totalUserRegisterToday = $this->useRepository->getTotalUserRegisterToday();
            $topUserMostRefer = $this->useRepository->getTop5UserMostReferralCode();
            $topWithdrawPending = $this->useRepository->getTopWithdrawPendingToday();
            $topRechargePending = $this->useRepository->getTopRechargePendingToday();
        }
        return response()->json([
                'status' => 'success',
                'data' => [
                    'totalRechargeAmountToday' => $totalRechargeAmountToday,
                    'totalWithdrawAmountToday' => $totalWithdrawAmountToday,
                    'totalUserRegisterToday' => $totalUserRegisterToday,
                    'topByReferralCode' => $topUserMostRefer['topByReferralCode'],
                    'topByRechargeAmount' => $topUserMostRefer['topByRechargeAmount'],
                    'topByWithdrawAmount' => $topUserMostRefer['topByWithdrawAmount'],
                    'topWithdrawPending' => $topWithdrawPending,
                    'topRechargePending' => $topRechargePending,
                ]
            ]);
    }


}
