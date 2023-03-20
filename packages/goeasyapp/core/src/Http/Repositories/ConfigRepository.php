<?php

namespace Goeasyapp\Core\Http\Repositories;

use App\Models\Config;
use App\Models\Language;

class ConfigRepository
{
    protected $useModel;
    protected $configs;
    public function __construct(Config $model)
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $this->useModel = $model;
        $this->configs = [
            "aciton" => "config",
            'title' => __trans($language, 'All.config', 'Cấu hình'),
        ];
    }
    public function getModel()
    {
        return $this->useModel;
    }
    public function deleteItem($id)
    {
        $this->useModel->find($id)->delete();
    }
    public function changeStatus($id)
    {
        $this->useModel = $this->useModel->find($id);
        if ($this->useModel->status != 1) {
            $this->useModel->status = 1;
        } else {
            $this->useModel->status = 0;
        }
        $this->useModel->save();
    }
    public function getModelById($id)
    {
        return $this->useModel->find($id);
    }
    public function getModelEn()
    {
        return $this->useModel->where('code', 'en')->first();
    }
    public function getConfig()
    {
        return $this->configs;
    }
    public function getPaginateWithRelation($limit = 20, $request = [])
    {
        if (count($request) == 0) {
            return $this->useModel->orderBy('updated_at', 'DESC')->paginate($limit);
        }
    }
    public function updateModel($request)
    {
        if ($request->id != 0) {
            $this->useModel = $this->useModel->find($request->id);
        }
       $this->useModel->name = json_encode($request->name);
        $this->useModel->image = $request->image;
        $this->useModel->value = $request->value;
        $this->useModel->save();
    }

}
