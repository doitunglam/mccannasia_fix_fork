<?php

namespace Goeasyapp\App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Goeasyapp\Core\Http\Hooks\CampainHook;
use Goeasyapp\Core\Http\Repositories\CampainRepository;
use Auth;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AgencyController extends Controller
{


    public function restoreAll(Request $request)
    {
        $array = explode(',', $request->delete_all);
        $models = User::whereIn('id', $array);
        $models->update(['close_account' => null]);
        return redirect()->back()
            ->with('success', 'Deleted the user successfully!');

    }
    public function deleteAll(Request $request)
    {
        $array = explode(',', $request->delete_all);
        $models = User::whereIn('id', $array);
        $models->update(['close_account' => 1]);
        return redirect()->back()
            ->with('success', 'Deleted the user successfully!');

    }
    public function deleteItem(Request $request, $id)
    {
        $model = User::find($id);
        $model->close_account = 1;
        $model->save();
        return redirect()->back()
            ->with('success', 'Deleted the user successfully!');
    }

    public function update(Request $request, $id)
    {

        $model = User::find($id);
        $referral_list = empty($model->referral_code)
            ? []
            : DB::table('users')
            ->leftJoin('payments', 'payments.user', '=', 'users.id')
            ->select('users.*',
                        DB::raw('SUM(CASE WHEN payments.type = 1 THEN payments.amount ELSE 0 END) as total_recharge'),
                        DB::raw('SUM(CASE WHEN payments.type IS NULL THEN payments.amount ELSE 0 END) as total_withdraw'))
            ->where('users.parent_referral_code', $model->referral_code)
            ->groupBy('users.id')
            ->get();
        return view('app::user.edit', [
            'model' => $model,
            'store' => 'user.store',
            'title' => 'Users',
            'banks' => Bank::BANKS,
            'referral_list' => $referral_list
        ]);
    }
    public function reset(Request $request, $id)
    {
        $item = User::find($id);
        $item->password = bcrypt('mccannasia@123');
        $item->save();
        return redirect()->back()
            ->with('success', 'Password reset successful!');
    }
    public function status(Request $request, $id)
    {
        $item = User::find($id);
        if ($item->status == 1) {
            $item->status = 0;
        } else {
            $item->status = 1;
        }
        $item->save();
        return redirect()->back()
            ->with('success', 'Changed their status successfully!');
    }
    public function store(Request $request, $id)
    {
        if ($id == 0) {
            $request->validate([
                'username' => 'required',
            ]);
        }
        if ($request->type_ == 'nhanvien') {
            $r = 'staff';
        } else {
            $r = 'agency';
        }
        if ($id == 0) {
            $check = User::where('email', $request->username)->first();
            if ($check) {
                return redirect()->intended('user/' . $r)
                    ->with('success', 'Email already exists in the system.');
            }
            $model = new User;
        } else {

            $model = User::find($id);
        }

        $model->name = $request->display;
        $model->email = $request->username;
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->type = $request->type_;
        $model->gender = $request->gender;
	    $model->bank_name = $request->bank_name;
	    $model->bank_name_account = $request->bank_name_account;
        $model->bank_account = $request->bank_account;
        $model->referral_code = $request->referral_code;
        if (!empty($request->password))
            $model->password = bcrypt($request->password);


        $model->save();
        if ($request->file('image')) {
            $file_name = $request->file('image')->getClientOriginalName();
            $end = explode('.', $file_name);
            $index_ = count($end) - 1;
            $file_name = time() . '.' . $end[$index_];
            $request->file('image')->move('upload/user/' . $model->id, $file_name);
            $model->image	 = 'upload/user/' . $model->id . '/' . $file_name;
        }

        $model->save();
        return redirect()->route('user')
            ->with('success', 'Updated the user information successfully!');
    }
    public function create(Request $request)
    {
        return view('app::user.create', [
            'store' => 'user.store',
            'title' => 'Agency',
            'type_' => 'agency',

        ]);
    }
    public function createStaff(Request $request)
    {
        return view('user.create', [
            'store' => 'user.store',
            'title' => 'Nhân viên',
            'breadcrumb_1' => 'Nhân viên',
            'type_' => 'nhanvien',

        ]);
    }

    public function restore(Request $request)
    {
        $search = $request->all();
        $items = User::orderBy('updated_at', 'DESC')->where('close_account', 1);
        if ($request->f_name != '') {

            $items = $items->where('name', 'like', '%' . $request->f_name . '%');
        }
        if ($request->f_email != '') {
            $items = $items->where('email', 'like', '%' . $request->f_email . '%');
        }
        if ($request->f_phone != '') {
            $items = $items->where('phone', 'like', '%' . $request->f_phone . '%');
        }
        $items = $items->get();
        $search = $request->all();
        $data = [
            'search' => $search,
            'items' => $items,
            'title' => 'Nhân viên',
            'breadcrumb_1' => 'Settings',
            'breadcrumb_2' => 'Nhân viên',

        ];
        $data['update'] = 'user.update';
        $data['delete'] = 'user.delete';
        $data['status'] = 'user.status';
        $data['restore'] = 1;
        $data['create'] = 'user.create.staff';
        return view('user.list', $data);
    }
    public function indexStaff(Request $request)
    {
        $search = $request->all();
        $items = User::orderBy('updated_at', 'DESC')->where('type_', 'nhanvien')->where('close_account', null);
        if ($request->f_name != '') {

            $items = $items->where('name', 'like', '%' . $request->f_name . '%');
        }
        if ($request->f_email != '') {
            $items = $items->where('email', 'like', '%' . $request->f_email . '%');
        }
        if ($request->f_phone != '') {
            $items = $items->where('phone', 'like', '%' . $request->f_phone . '%');
        }
        $items = $items->get();
        $search = $request->all();


        $data = [
            'search' => $search,
            'items' => $items,
            'title' => 'Nhân viên',
            'breadcrumb_1' => 'Settings',
            'breadcrumb_2' => 'Nhân viên',

        ];
        $data['update'] = 'user.update';
        $data['delete'] = 'user.delete';
        $data['status'] = 'user.status';
        $data['create'] = 'user.create.staff';
        return view('user.list', $data);
    }
    public function alert(Request $request)
    {
        $search = $request->all();
        $items = User::orderBy('updated_at', 'DESC')->where('type', 'agency');
        if ($request->f_name != '') {

            $items = $items->where('name', 'like', '%' . $request->f_name . '%');
        }
        if ($request->f_email != '') {
            $items = $items->where('email', 'like', '%' . $request->f_email . '%');
        }

        if ($request->f_phone != '') {
            $items = $items->where('phone', 'like', '%' . $request->f_phone . '%');
        }
        $items = $items->get();
        $search = $request->all();


        $data = [
            'search' => $search,
            'items' => $items,
            'title' => 'Khách hàng',
            'breadcrumb_1' => 'Settings',
            'breadcrumb_2' => 'Khách hàng',

        ];
        $data['update'] = 'user.update';
        $data['delete'] = 'user.delete';
        $data['status'] = 'user.status';
        $data['create'] = 'user.create';
        return view('user.list_alert', $data);
    }
    public function index(Request $request)
    {
        $search = $request->all();
        $items = User::orderBy('updated_at', 'DESC')->where('type', 'agency')->where('close_account', null);
        if ($request->f_name != '') {
            $items = $items->where('name', 'like', '%' . $request->f_name . '%');
        }
        if ($request->f_email != '') {
            $items = $items->where('email', 'like', '%' . $request->f_email . '%');
        }

        if ($request->f_phone != '') {
            $items = $items->where('phone', 'like', '%' . $request->f_phone . '%');
        }
        $items = $items->get();
        $search = $request->all();


        $data = [
            'search' => $search,
            'items' => $items,
            'title' => 'Agency',

        ];
        $data['update'] = 'user.update';
        $data['delete'] = 'user.delete';
        $data['status'] = 'user.status';
        $data['create'] = 'user.create';
        $data['change_amount'] = 'user.view_change_amount';
        return view('app::user.list', $data);
    }

    public function viewChangeAllAmount(Request $request)
    {
        $search = $request->all();
        $items = User::orderBy('updated_at', 'DESC')->where('type', 'agency')->where('close_account', null);
        if ($request->f_name != '') {
            $items = $items->where('name', 'like', '%' . $request->f_name . '%');
        }
        if ($request->f_email != '') {
            $items = $items->where('email', 'like', '%' . $request->f_email . '%');
        }

        if ($request->f_phone != '') {
            $items = $items->where('phone', 'like', '%' . $request->f_phone . '%');
        }
        $items = $items->get();
        $search = $request->all();

        $data = [
            'search' => $search,
            'items' => $items,
            'title' => 'Thay đổi số dư',

        ];
        $data['update'] = 'user.update';
        $data['delete'] = 'user.delete';
        $data['status'] = 'user.status';
        $data['create'] = 'user.create';
        $data['change_amount'] = 'user.view_change_amount';
        return view('app::user.change-all-amount', $data);
    }

    public function viewChangeAmount($id)
    {
        $model = User::find($id);
        return view('app::user.change_amount', [
            'model' => $model,
            'store' => 'user.change_amount',
            'title' => 'Thay đổi số dư',
            'banks' => Bank::BANKS
        ]);
    }

    public function changeAllAmount(Request $request){
        foreach ($request->amount as $key =>$plus_amount){
            if(is_numeric($plus_amount)) {
                $userModel = User::where('id',$key);
                $user = $userModel->first();
                $amount = $user->amount + $plus_amount;
                $userModel->update(['amount' => $amount]);
            }
        }
        return redirect()->back()->with('success', 'Cộng tiền thành công');
    }

    public function changeAmount(Request $request, $id){
        if(is_numeric($request->plus_amount)) {
            $userModel = User::where('id',$id);
            $user = $userModel->first();
            $amount = $user->amount + $request->plus_amount;
            $userModel->update(['amount' => $amount]);
            return redirect()->route('user')
                ->with('success', 'Updated the user information successfully!');
        }
        return redirect()->back()
            ->with('error', 'The increase amount must be an number');
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);

        if(empty($request->password) || empty($request->new_password) || empty($request->confirm_password)){
            return redirect()->back()->with('error', 'Các trường mật khẩu không được bỏ trống');
        }
        if(Hash::check($request->password, $user->password)){
            if ($request->new_password == $request->confirm_password){

                $user->password = bcrypt($request->password);
                $user->save();
                return redirect()->back()->with('success', 'Thay đổi mật khẩu thành công');
            }
            return redirect()->back()->with('error', 'Nhập lại mật khẩu không chính xác');
        }
        return redirect()->back()->with('error', 'Mật khẩu củ không chính xác');
    }
}
