<?php

namespace Goeasyapp\Core\Http\Hooks;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Campain;
use App\Models\Language;

class CampainHook
{
    protected $component = "campain";
    protected $useModel;
    public function __construct(Campain $model)
    {
        $this->useModel = $model;

    }
    public function validate($request)
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $request->validate([
            'name' => 'required|unique:campains|max:255',
            'description' => 'required',
            'image' => 'required',
            'short_content' => 'required',
            'link_' => 'required',
            'date_public' => 'required',
            'price' => 'required',
            'task' => 'required',
            'mission_id' => 'required',
        ], [
                'name.required' => __trans($language, 'name', 'Name')." ".__trans($language, 'required', 'yêu cầu nhập'),
                'name.unique' => __trans($language, 'name', 'Name')." ".__trans($language, 'unique', 'phải là duy nhất'),
                'name.max' => __trans($language, 'name', 'Name')." ".__trans($language, 'max_225', 'tối đa 255 ký tự'),
                'description.required' => __trans($language, 'description', 'Description')." ".__trans($language, 'required', 'yêu cầu nhập'),
                'image.required' => __trans($language, 'image', 'Image')." ".__trans($language, 'required', 'yêu cầu nhập'),
                'short_content.required' => __trans($language, 'short_content', 'Short Content')." ".__trans($language, 'required', 'yêu cầu nhập'),
                'link_.required' => __trans($language, 'link', 'Link')." ".__trans($language, 'required', 'yêu cầu nhập'),
                'date_public.required' => __trans($language, 'date_public', 'Date Public')." ".__trans($language, 'required', 'yêu cầu nhập'),
                'price.required' => __trans($language, 'price', 'Price')." ".__trans($language, 'required', 'yêu cầu nhập'),
                'task.required' => __trans($language, 'task', 'Công việc')." ".__trans($language, 'required', 'yêu cầu nhập'),
                'mission_id.required' => __trans($language, 'mission', 'Nhiệm vụ')." ".__trans($language, 'required', 'yêu cầu nhập'),
            ]);

    }
}
