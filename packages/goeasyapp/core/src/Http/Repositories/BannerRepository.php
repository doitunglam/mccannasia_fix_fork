<?php

namespace Goeasyapp\Core\Http\Repositories;

use App\Models\Banner;
use App\Models\Language;

class BannerRepository
{
    protected $useModel;
    protected $configs;
    public function __construct(Banner $model)
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $this->useModel = $model;
        $this->configs = [
            "aciton" => "banner",
            'title' => __trans($language, 'All.banner', 'Banner'),
        ];
    }
    public function getModel()
    {
        return $this->useModel;
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
    public function deleteItem($id)
    {
        $this->useModel->find($id)->delete();
    }
    public function getPaginateWithRelation($request = [], $limit = 20)
    {
	    return $this->useModel->where('is_popup', $request['is_popup'])->orderBy('updated_at', 'DESC')->paginate($limit);
    }
    public function updateModel($request)
    {
        if ($request->id != 0) {
            $this->useModel = $this->useModel->find($request->id);
        }
        $this->useModel->link_ = $request->name;
        $this->useModel->image = $request->image;
	    $this->useModel->is_popup = ($request->is_popup == 1) ? 1 : 0;
        $this->useModel->save();
    }

}