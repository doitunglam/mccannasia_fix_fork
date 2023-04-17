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


}
