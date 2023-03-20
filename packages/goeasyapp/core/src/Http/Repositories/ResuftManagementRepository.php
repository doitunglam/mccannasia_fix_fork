<?php

namespace Goeasyapp\Core\Http\Repositories;

use App\Models\Resuft;
use App\Models\Language;
use App\Models\User;
use Auth;

class ResuftManagementRepository
{
    protected $useModel;
    protected $configs;
    public function __construct(Resuft $model)
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $this->useModel = $model;
        $this->configs = [
            "aciton" => "Resuft",
            'title' => __trans($language, 'All.campain', 'Campain'),
        ];
    }
    public function getConfig()
    {
        return $this->configs;
    }
    public function getResuftToday() {
        $today = date('Y-m-d');
        return $this->useModel
        ->where('resufts.created_at', 'like', '%' . $today . '%')
        ->leftJoin('campains', 'campains.id', '=', 'resufts.campain')
        ->select('resufts.*', 'campains.name as campain_name')
        ->get();
    }
    public function handleActionResuft($request, $id) {
        $resuft = $this->useModel->find($id);
        $status = $request->status;
        if ($resuft) {
            $resuft->status = $status;
            if($status == 1) {
                $user = User::find($resuft->user);
                $amount = $user->amount;
                if ($request->status == 1)
                {
                    $amount = $user->amount + $resuft->price;
                }
                $user->amount = $amount;
                $user->save();
            }
            $resuft->save();
        }
    }
    public function getResuftId($id) {
        return $this->useModel->find($id);
    }
}
