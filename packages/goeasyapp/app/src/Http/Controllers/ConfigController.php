<?php

namespace Goeasyapp\App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Goeasyapp\Core\Http\Hooks\ConfigHook;
use Goeasyapp\Core\Http\Repositories\ConfigRepository;
use App\Models\Language;

class ConfigController extends Controller
{
    private $useHook;
    private $useRepository;
    private $configs;
    private $model;
    public function __construct(ConfigHook $LoginValidateHook, ConfigRepository $UserRepository)
    {
        $this->middleware('auth');
        $this->useHook = $LoginValidateHook;
        $this->useRepository = $UserRepository;

    }
    public function status($id)
    {
        $this->useRepository->changeStatus($id);
        return redirect()->back()->with('success', 'Update item success!');
    }
    public function deleteItem($id)
    {
        $this->useRepository->deleteItem($id);
        return redirect()->intended('admin/campain')->with('success', 'Update item success!');
    }
    public function list()
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $td = [
            ['title' => __trans($language, 'All.id', 'ID'), 'value' => 'id'],

            ['title' => __trans($language, 'All.account', 'Tài khoản'), 'value' => 'value'],
            ['title' => __trans($language, 'All.image', 'Ảnh'), 'value' => 'image', 'type' => 'image'],
        ];
        $items = $this->useRepository->getPaginateWithRelation();
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.list', [
            'title' => "Cấu hình",
            'delete' => $this->useRepository->getConfig()['aciton'] . '.delete',
            'update' => $this->useRepository->getConfig()['aciton'] . '.update',
            'status' => $this->useRepository->getConfig()['aciton'] . '.status',
            'td' => $td,
            'items' => $items
        ]);

    }
    public function create()
    {
        $item = $this->useRepository->getModel();
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.create', [
            'item' => $item,
            'title' => 'Tạo mới',
            'route' => $this->useRepository->getConfig()['aciton'] . '.store',
	        'banks' => Bank::BANKS
        ]);
    }
    public function update($id)
    {

        $item = $this->useRepository->getModelById($id);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.edit', [
            'item' => $item,
            'title' => 'Sửa',
            'route' => $this->useRepository->getConfig()['aciton'] . '.store',
            'banks' => Bank::BANKS
        ]);
    }
    public function store(Request $request)
    {


        $this->useRepository->updateModel($request);
        return redirect()->back()
            ->with('success', 'Update item success!');
    }
}
