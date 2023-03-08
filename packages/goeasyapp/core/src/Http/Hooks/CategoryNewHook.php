<?php

namespace Goeasyapp\Core\Http\Hooks;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CategoryNew;
use App\Models\Language;

class CategoryNewHook
{
    protected $component = "category-new";
    protected $useModel;
    public function __construct(CategoryNew $model)
    {
        $this->useModel = $model;

    }
    public function validate($request)
    {

        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $request->validate([
            'link_' => 'required|unique:banners|max:255',
        ], [
                'name.required' => __trans($language, 'required', 'Required'),
                'name.unique' => __trans($language, 'unique', 'Unique'),
                'name.max' => __trans($language, 'max_225', 'Max 225 character'),
            ]);

    }
}