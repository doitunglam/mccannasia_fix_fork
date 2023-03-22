<?php

namespace Goeasyapp\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Goeasyapp\Core\Http\Hooks\LanguageHook;
use Goeasyapp\Core\Http\Repositories\LanguageRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Language;

class LanguageController extends Controller
{
    private $useHook;
    private $useRepository;
    private $configs;
    private $model;
    public function __construct(LanguageHook $LoginValidateHook, LanguageRepository $UserRepository)
    {
        $this->middleware('auth');
        $this->useHook = $LoginValidateHook;
        $this->useRepository = $UserRepository;

    }
    public function deleteItem($id)
    {
        $this->useRepository->deleteItem($id);
        return redirect()->intended('admin/campain')->with('success', 'Update item success!');
    }
    public function status($id)
    {
        $this->useRepository->changeStatus($id);
        return redirect()->back()->with('success', 'Update item success!');
    }
    public function list()
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $td = [
            ['title' => __trans($language, 'All.id', 'ID'), 'value' => 'id'],
            ['title' => __trans($language, 'All.name', 'Tên'), 'value' => 'name'],
            ['title' => __trans($language, 'All.code', 'Mã'), 'value' => 'code'],
            ['title' => __trans($language, 'All.image', 'Ảnh'), 'value' => 'image', 'type' => 'image'],
        ];
        $items = $this->useRepository->getPaginateWithRelation();
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.list', [
            'title' => 'Ngôn ngữ',
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
        $en = $this->useRepository->getModelEn();
        $data_en = [];
        if ($en)
            $data_en = json($en->page_value);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.create', [
            'item' => $item,
            'en' => $en,
            'data_en' => $data_en,
            'title' => 'Tạo ngôn ngữ',
            'route' => $this->useRepository->getConfig()['aciton'] . '.store'
        ]);
    }
    public function update($id)
    {
        $en = $this->useRepository->getModelEn();
        $item = $this->useRepository->getModelById($id);
        $data = json($item->page_value);
        $data_en = json($en->page_value);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.edit', [
            'item' => $item,
            'data' => $data,
            'data_en' => $data_en,
            'en' => $en,
            'title' => 'Sửa ngôn ngữ',
            'route' => $this->useRepository->getConfig()['aciton'] . '.store'
        ]);
    }
    public function store(Request $request)
    {

        if ($request->id == 0)
            $this->useHook->validate($request);
        $this->useRepository->updateModel($request);
        return redirect()->intended('admin/' . $this->useRepository->getConfig()['aciton'])
            ->with('success', 'Update item success!');
    }
}
