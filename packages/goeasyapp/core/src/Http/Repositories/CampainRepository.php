<?php

namespace Goeasyapp\Core\Http\Repositories;

use App\Models\Campain;
use App\Models\Resuft;
use App\Models\Payment;
use App\Models\User;
use App\Models\Language;
use App\Models\CampainItem;
use Auth;

class CampainRepository
{
    protected $useModel;
    protected $configs;
    public function __construct(Campain $model)
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $this->useModel = $model;
        $this->configs = [
            "aciton" => "campain",
            'title' => __trans($language, 'All.campain', 'Campain'),
        ];
    }
    public function deleteItem($id)
    {
        $this->useModel->find($id)->delete();
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
    public function getSon($items, $level)
    {
        $string = '';
        for ($i = 0; $i < $level; $i++) {
            $string = $string . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        $level = $level + 1;
        foreach ($items as $item) {
            $user = User::find($item->uid);
            echo '<p style="margin: 15px">' . $string . '/' . $user->name . '<a class="badge rounded-pill badge-soft-primary" href="' . route('campain.member', ['id' => $item->cid, 'user' => $item->uid]) . '"/>View</a></p>';
            $items_ = CampainItem::where('use_', $item->url)->where('cid', $item->cid)->get();
            if ($items_)
                $this->getSon($items_, $level);
        }

    }
    public function getCampainMy($request)
    {
        if ($request->id == '') {
            $user = Auth::user();
        } else {
            $user = User::find($request->id);
        }
        $campain = json($user->campains);
        return $this->useModel->whereIn('id', $campain)->get();
    }

    public function getCampainCategory($id)
    {
        $day = [date('d/m/Y'), ''];
        return $this->useModel->where('category', $id)->get();
    }

    public function getCampainHot()
    {
        $day = date('d/m/Y');
        return $this->useModel->where('status', 1)->get();
    }
    public function getCampainDay($request)
    {
        $day = date('d/m/Y');
        $model = $this->useModel;
        if ($request->s_name != '') {
            $model = $model->where('name', 'like', '%' . $request->s_name . '%');
        }
        return $model->where(function ($query) use ($day) {
            $query->where('date_public', $day)
                ->orWhere('date_public', null);
        })->get();
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

    public function registerCampain($id, $request)
    {
        $this->useModel = $this->useModel->find($id);
        $json = json($this->useModel->users);
        $user = Auth::user();
        $model = new CampainItem;
        $model->uid = Auth::user()->id;
        $model->cid = $id;
        $model->code = time();
        $model->url = md5(Auth::user()->id);
        $model->use_ = $request->use_;
        $model->save();
        $campain = json($user->campains);
        if (!in_array($id, $campain)) {
            $json[] = $user->id;
            $this->useModel->users = json_encode($json);
            $this->useModel->save();
            $campain[] = $id;
            $user->campains = json_encode($campain);
            $user->save();
        }
    }

    public function getPaymentId($id)
    {
        return Payment::find($id);
    }
    public function getResuftPaginatio()
    {
        return Resuft::orderBy('updated_at', 'DESC')->paginate(20);
    }

    public function getResuftUser($id)
    {
        return Resuft::where('user', Auth::user()->id)->where('campain', $id)->get();
    }
    public function getResuft($id, $user)
    {
        return Resuft::where('user', $user)->where('campain', $id)->get();
    }

    public function getMyPayment($request)
    {
        $user = [];
        if ($request->s_name != '') {
            $user = User::select('id')->where('name', 'like', '%' . $request->s_name . '%')->get()->toArray();
        }
        if (count($user) != 0) {
            return Payment::orderBy('updated_at')->whereIn('user', $user)->paginate(20);
        }
        return Payment::orderBy('updated_at')->paginate(20);
    }

    public function getAdminPaymentRecharge_Withdraw($request, $type)
    {
        $user = [];
        if ($request->s_name != '') {
            $user = User::select('id')->where('name', 'like', '%' . $request->s_name . '%')->get()->toArray();
        }
        if (count($user) != 0) {
            return Payment::where('type', $type)->orderBy('updated_at')->whereIn('user', $user)->paginate(20);
        }
        return Payment::where('type', $type)->orderBy('updated_at')->paginate(20);
    }

    public function getMyPaymentRecharge_Withdraw($request, $type)
    {
        return Payment::where('type', $type)->where('user', Auth::id())->orderBy('updated_at')->paginate(20);
    }

    public function savePayment($request)
    {
        $model = new Payment;
        $user = Auth::user();
        $amount = $user->amount;
        if ($request->type == '')
            $amount = $user->amount - $request->price;
        $user->amount = $amount;
        $user->save();
        $model->user = $user->id;
        $model->amount = $request->price;
        $model->type = $request->type;
        $model->name = $request->name;
        $model->user_name = $user->name;
        $model->save();

    }

    public function updateModelPayment($request)
    {
        $model = Payment::find($request->id);
        $user = Auth::user();
        if ($model->status == 1) {
            $user = User::find($model->user);
            $amount = $user->amount;
            if ($request->type == 1)
                $amount = $user->amount + $model->amount;
            $user->amount = $amount;
            $user->save();
        }
        $model->status = $request->status;
        $model->save();
    }
    public function getFee($campain, $item, $price)
    {
        $percen = 5;
        $use_ = $item->use_;
        if ($use_ == '') {
            $user = User::find($item->uid);
            $user->amount = $user->amount + $price;
            $user->save();
        } else {
            $user = User::find($item->uid);
            $a_ = ($price / 100) * $percen;
            $user->amount = $user->amount + ($price - $a_);
            $user->save();
            $check = CampainItem::where('url', $use_)->where('cid', $item->cid)->first();
            $this->getFee($campain, $check, $a_);
        }
    }

    public function saveResuftCheck($request)
    {
        $model = Resuft::find($request->id);
        $user = Auth::user();

        if ($model->status == 1) {
            $campain = Campain::find($model->campain);
            $item = CampainItem::where('uid', Auth::user()->id)->where('cid', $model->campain)->first();
            $this->getFee($campain, $item, $model->price);
        }
        $model->status = $request->status;
        $model->save();
    }
    public function getCampainInfo($id)
    {
        $check = CampainItem::where('uid', Auth::user()->id)->where('cid', $id)->first();
        return $check;
    }
    public function saveResuft($request)
    {
        $check = CampainItem::where('uid', Auth::user()->id)->where('cid', $request->id)->first();
        $use_ = '';
        if ($check) {
            $use_ = $check->use_;
        }
        $model = Resuft::where('user', Auth::user()->id)->where('campain', $request->id)->where('date', date('d-m-Y'))->first();
        $this->useModel = $this->useModel->find($request->id);
        if (!$model) {
            $model = new Resuft;
            $model->user = Auth::user()->id;
            $model->campain = $request->id;
        }
        $model->list_task = $this->useModel->list_task;
        $model->campain_name = $this->useModel->name;
        $model->image = $this->useModel->image;
        $model->user_name = Auth::user()->name;
        $model->price = $this->useModel->price;
        $model->status = 0;
        $model->use_ = $use_;
        $model->date = date('d-m-Y');
        $model->resuft = json_encode($request->resuft);
        $model->save();
    }
    public function updateModel($request)
    {
        if ($request->id != 0) {
            $this->useModel = $this->useModel->find($request->id);
        }
        $this->useModel->name = json_encode($request->name);
        $this->useModel->description = json_encode($request->description);
        $this->useModel->image = json_encode($request->image);
        $this->useModel->short_content = json_encode($request->short_content);
        $this->useModel->link_ = $request->link_;
        $this->useModel->date_public = $request->date_public;
        $this->useModel->price = $request->price;
        $this->useModel->list_task = json_encode($request->task);
        $this->useModel->save();
    }

}
