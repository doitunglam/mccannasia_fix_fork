<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Goeasyapp\Core\Http\Repositories\ResuftManagementRepository;

class ApiResuftController extends Controller
{
    private $useRepository;
    public function __construct(ResuftManagementRepository $UserRepository)
    {
        $this->useRepository = $UserRepository;
    }

    public function list(Request $request)
    {
        $items = $this->useRepository->getResuftToday();
        return response()->json([
                'status' => 'success',
                'items' => $items,
            ]);
    }
    public function handleAction(Request $request) {
        $id=$request->id;
        $this->useRepository->handleActionResuft($request, $id);
        return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
            ]);
    }
    public function handleAcceptAll(Request $request)
    {
        $this->useRepository->handleAcceptAll($request);
        return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
            ]);
        }

}
