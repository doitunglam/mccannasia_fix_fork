<?php

namespace Goeasyapp\Core\Http\Hooks;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Resuft;
use App\Models\Language;

class ResuftManagementHook
{
    protected $component = "ResuftManagement";
    protected $useModel;
    public function __construct(Resuft $model)
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
        ], [
                'name.required' => __trans($language, 'required', 'Required'),
                'name.unique' => __trans($language, 'unique', 'Unique'),
                'name.max' => __trans($language, 'max_225', 'Max 225 character'),
            ]);

    }
}
