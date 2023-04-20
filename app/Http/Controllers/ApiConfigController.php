<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Goeasyapp\Core\Http\Hooks\ConfigHook;
use Goeasyapp\Core\Http\Repositories\ConfigRepository;
use App\Models\Language;

class ApiConfigController extends Controller
{
    private $useHook;
    private $useRepository;
    private $configs;
    private $model;
    public function __construct(ConfigHook $LoginValidateHook, ConfigRepository $UserRepository)
    {
        $this->useHook = $LoginValidateHook;
        $this->useRepository = $UserRepository;

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
    public function list()
    {
        $items = $this->useRepository->getPaginateWithRelation();
        return response()->json([
            'status' => 'success',
            'items' => $items
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
