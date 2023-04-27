<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Payment;
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
    public function store(Request $request)
    {
        $this->useRepository->updateModelPayment($request);
        return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
            ]);
    }
    public function paymentAcceptAll(Request $request)
    {

            $payments = Payment::where('status', null)->where('type',null)->get();
        foreach ($payments as $payment) {
            $user = User::find($payment->user);
            $userModel = User::where('id',$payment->user);
            if($payment->type == 1){
                $amount = $user->amount + $payment->amount;
                $userModel->update(['amount' => $amount]);
            }
            $payment->update(['status' => 1]);
        }

        return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
            ]);
    }
}
