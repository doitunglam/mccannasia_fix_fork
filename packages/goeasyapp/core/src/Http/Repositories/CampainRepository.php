<?php

namespace Goeasyapp\Core\Http\Repositories;

use App\Models\Campain;
use App\Models\Resuft;
use App\Models\Payment;
use App\Models\User;
use App\Models\Language;
use App\Models\CampainItem;
use Illuminate\Support\Facades\DB;
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
            'title' => __trans($language, 'All.campain', 'Chiến dịch'),
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
    public function getModelByIdAndMissionInfo($id)
    {
        return $this->useModel->where('campains.id', $id)
        ->leftJoin('campain_missions', 'campain_missions.id', '=', 'campains.mission_id')
        ->select('campains.*', 'campain_missions.id as mission_id', 'campain_missions.name as mission_name', 'campain_missions.daily_profit', 'campain_missions.binding_fee', 'campain_missions.content')
        ->first();
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
        // ["1", "2"]
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
        })->leftJoin('campain_categories', 'campain_categories.id', '=', 'campains.category')
            ->select('campains.*', 'campain_categories.name as category_name')
            ->get();
    }
    public function getTotalRechargeAmountToday() {
        $day = date('Y-m-d');
        return Payment::where('type', 1)->where('created_at', 'like', '%' . $day . '%')
        ->where('status', 1)
        ->sum('amount');
    }
    public function getTotalWithdrawAmountToday() {
        $day = date('Y-m-d');
        return Payment::whereNull('type')->where('created_at', 'like', '%' . $day . '%')
        ->where('status', 1)
        ->sum('amount');
    }
    public function getTotalUserRegisterToday() {
        $day = date('Y-m-d');
        return User::where('created_at', 'like', '%' . $day . '%')->count();
    }
    public function getTop5UserMostReferralCode() {
        $groupByReferralCode = User::select('parent_referral_code', 'id', DB::raw('count(*) as user_count'))
            ->groupBy('parent_referral_code', 'id')
            ->whereNotNull('parent_referral_code')
            ->orderByDesc('user_count')
            ->get();
        $summary = User::whereIn('users.id', $groupByReferralCode->pluck('id'))
            ->leftJoin('payments', 'payments.user', '=', 'users.id')
            ->where('payments.status', 1)
            ->select('users.parent_referral_code',
                    DB::raw('SUM(CASE WHEN payments.type = 1 THEN payments.amount ELSE 0 END) as totalRechargeAmount'),
                    DB::raw('SUM(CASE WHEN payments.type IS NULL THEN payments.amount ELSE 0 END) as totalWithdrawAmount'))
            ->groupBy('users.parent_referral_code')
            ->get();
        $topAgency = User::whereIn('referral_code', $groupByReferralCode->pluck('parent_referral_code')->toArray())
            ->get()
            ->map(function ($user) use ($groupByReferralCode) {
                $user->user_count = $groupByReferralCode->where('parent_referral_code', $user->referral_code)->first()->user_count;
                return $user;
            })
            ->map(function ($user) use ($summary) {
                $user->total_recharge_amount = $summary->where('parent_referral_code', $user->referral_code)->first()->totalRechargeAmount;
                $user->total_withdraw_amount = $summary->where('parent_referral_code', $user->referral_code)->first()->totalWithdrawAmount;
                return $user;
            });
        $topByReferralCode = $topAgency->sortByDesc('user_count')->take(20);
        $topByRechargeAmount = $topAgency->sortByDesc('total_recharge_amount')->where('total_recharge_amount', '>', 0)->take(20);
        $topByWithdrawAmount = $topAgency->sortByDesc('total_withdraw_amount')->where('total_withdraw_amount', '>', 0)->take(20);
        return [
            'topByReferralCode' => $topByReferralCode,
            'topByRechargeAmount' => $topByRechargeAmount,
            'topByWithdrawAmount' => $topByWithdrawAmount
        ];

    }
    public function getTopAgencyHaveMostRechargeAmount() {
        $groupByAgency = User::select('parent_referral_code', DB::raw('count(*) as user_count'))
        ->groupBy('parent_referral_code')
        ->whereNotNull('parent_referral_code')
        ->get();

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

    public function registerCampain($id, $request, $update_beginner)
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
        if($update_beginner){
            $user->is_beginner = 0;
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
        $results = Resuft::where('user', Auth::user()->id)->where('campain', $id)->get();
        foreach ($results as $result) {
            $json_data = json_decode($result->resuft);

            if (json_last_error() === JSON_ERROR_NONE) {
                $result->resuft = $json_data;
            } else {
                $result->resuft = [];
            }
        }
        return $results;
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
            return Payment::orderBy('created_at')->whereIn('user', $user)->paginate(20);
        }
        return Payment::orderBy('created_at')->paginate(20);
    }

    public function getAdminPaymentRecharge_Withdraw($request, $type)
    {
        $user = [];
        if ($request->s_name != '') {
            $user = User::select('id')->where('name', 'like', '%' . $request->s_name . '%')->get()->toArray();
        }
        if (count($user) != 0) {
            return Payment::where('type', $type)->orderBy('created_at')->whereIn('user', $user)->paginate(20);
        }
        return Payment::where('type', $type)->orderBy('created_at', 'DESC')->paginate(20);
    }

    public function getMyPaymentRecharge_Withdraw($request, $type)
    {
        return Payment::where('type', $type)->where('user', Auth::id())->orderBy('created_at', 'DESC')->paginate(20);
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
        if ($model->status == 1 || $request->status == "2") {
            $user = User::find($model->user);
            $amount = $user->amount;
            if ($request->type == 1 || $request->status == "2")
            {
                $amount = $user->amount + $model->amount;
            }
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
        $new_resuft = array_merge(json_decode($model->resuft, true) ?: [], $request->resuft);
        $decoded_resuft_explain = json_decode($model->resuft_explain, true) ?: [];
        array_push($decoded_resuft_explain, $request->resuft_explain);
        $new_resuft_explain = $decoded_resuft_explain;
        $model->resuft = json_encode($new_resuft);
        $model->resuft_explain = json_encode($new_resuft_explain);
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
	    $this->useModel->is_hot = !empty($request->is_hot);
	    $this->useModel->is_beginner = !empty($request->is_beginner);
	    $this->useModel->category = $request->category;
	    $this->useModel->mission_id = $request->mission_id;
        $this->useModel->save();
    }

}
