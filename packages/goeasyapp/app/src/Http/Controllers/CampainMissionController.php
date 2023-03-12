<?php

namespace Goeasyapp\App\Http\Controllers;

use App\Models\CampainMission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampainMissionController extends Controller
{
	public function index(Request $request)
	{
		$items = CampainMission::query()->paginate(20);

		return view('app::campain_mission.index', compact('items'));
	}

	public function getCreate()
	{
		return view('app::campain_mission.create');
	}

	public function postCreate(Request $request)
	{
		$validated = $request->validate([
			'name'          => 'required|max:255',
			'binding_fee'   => 'required',
			'daily_profit'  => 'required',
			'contract_term' => 'required',
			'content'       => 'required',
		]);

		(new CampainMission($request->all()))->save();
		session()->flash('success', 'Created Successfully');

		return redirect()->route('campain.mission.list');
	}

	public function getUpdate(Request $request, $id)
	{
		$item = CampainMission::query()->find($id);

		return view('app::campain_mission.update', compact('item'));
	}

	public function postUpdate(Request $request, $id)
	{
		$validated = $request->validate([
			'name'          => 'required|max:255',
			'binding_fee'   => 'required',
			'daily_profit'  => 'required',
			'contract_term' => 'required',
			'content'       => 'required',
		]);

		CampainMission::query()->find($id)->update($request->all());
		session()->flash('success', 'Updated Successfully');

		return back();
	}

	public function delete($id)
	{
		CampainMission::query()->find($id)->delete();
		session()->flash('success', 'Updated Successfully');

		return redirect()->route('campain.mission.list');
	}
}