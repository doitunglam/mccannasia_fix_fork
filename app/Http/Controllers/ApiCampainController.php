<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CampainMission;
use Goeasyapp\Core\Http\Repositories\CampainRepository;
use Goeasyapp\Core\Http\Hooks\CampainHook;

class ApiCampainController extends Controller
{
    private $model;
    private $useHook;
    private $useRepository;
    public function __construct(CampainHook $LoginValidateHook, CampainRepository $UserRepository)
    {
        $this->useRepository = $UserRepository;
        $this->useHook = $LoginValidateHook;
    }


    public function list(Request $request)
    {
        $items = $this->useRepository->getPaginateWithRelation();
        return response()->json([
                'status' => 'success',
                'items' => $items,
            ]);

    }
    public function getInfoCreate(Request $request)
    {
		$categories = json_decode(file_get_contents(public_path().'/campain_category.json') ?? "[]", 1);
	    $missions = CampainMission::query()->pluck('name', 'id');
        return response()->json([
                'status' => 'success',
                'data' => [
                    'categories' => $categories,
                    'missions' => $missions,
                ]
            ]);
    }
    public function store(Request $request)
    {
        if ($request->id == 0)
            $this->useHook->validate($request);
        $this->useRepository->updateModel($request);
        return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
            ]);
    }
    public function getModelById(Request $request) {
        $item = $this->useRepository->getModelById($request->id);
        if(!$item)
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy dữ liệu',
            ]);
        return response()->json([
                'status' => 'success',
                'item' => $item,
            ]);
    }
    public function deleteItemById(Request $request) {
        $this->useRepository->deleteItem($request->id);
        return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công',
            ]);
    }
}
