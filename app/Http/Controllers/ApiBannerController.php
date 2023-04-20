<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Goeasyapp\Core\Http\Hooks\BannerHook;
use Goeasyapp\Core\Http\Repositories\BannerRepository;
use App\Models\Language;

class ApiBannerController extends Controller
{
    private $useRepository;
    private $useHook;
    public function __construct(BannerHook $LoginValidateHook, BannerRepository $UserRepository)
    {
        $this->useRepository = $UserRepository;
        $this->useHook = $LoginValidateHook;

    }
    public function list(Request $request)
    {
        $items = $this->useRepository->getPaginateWithRelation(['is_popup' => FALSE]);
        return response()->json([
            'status' => 'success',
            'items' => $items
        ]);
    }
    public function status(Request $request)
    {
        $this->useRepository->changeStatus($request->id);
        return response()->json([
            'status' => 'success',
            'message' => 'Update item success!'
        ]);
    }
    public function deleteItem(Request $request)
    {
        $this->useRepository->deleteItem($request->id);
        return response()->json([
            'status' => 'success',
            'message' => 'Update item success!'
        ]);
    }
    public function getModelById(Request $request)
    {
        $item = $this->useRepository->getModelById($request->id);
        return response()->json([
            'status' => 'success',
            'item' => $item
        ]);
    }
    public function store(Request $request)
    {
        if ($request->id == 0){
        $this->useHook->validate($request);
        }
        $this->useRepository->updateModel($request);
        return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
            ]);
    }
}
