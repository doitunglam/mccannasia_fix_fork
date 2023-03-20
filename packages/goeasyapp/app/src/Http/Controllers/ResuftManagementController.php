<?php

namespace Goeasyapp\App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Goeasyapp\Core\Http\Hooks\ResuftManagementHook;
use Goeasyapp\Core\Http\Repositories\ResuftManagementRepository;
use Auth;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResuftManagementController extends Controller
{
    private $useRepository;
    private $configs;
    private $model;
    public function __construct(ResuftManagementHook $LoginValidateHook, ResuftManagementRepository $UserRepository)
    {
        $this->middleware('auth');
        $this->useHook = $LoginValidateHook;
        $this->useRepository = $UserRepository;
    }
    public function list(Request $request)
    {
        $user = Auth::user();
        $items = $this->useRepository->getResuftToday();
        return view('app::'. $this->useRepository->getConfig()['aciton'] . '.list', [
            'title' => 'List Resuft',
            'route' => 'resuft.management',
            'items' => $items,
        ]);
    }
    public function handleAction(Request $request, $id)
    {
        $this->useRepository->handleActionResuft($request, $id);
        return redirect()->back()
        ->with('success', 'Update item success!');
    }
    public function resuftRequest($id)
    {
        $item = $this->useRepository->getResuftId($id);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.payment-check', [
            'item' => $item,
            'title' => 'Payment Check of User: ',
            'route' => 'payment.request.check'
        ]);
    }
}
