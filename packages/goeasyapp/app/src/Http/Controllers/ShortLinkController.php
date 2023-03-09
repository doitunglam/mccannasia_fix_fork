<?php

namespace Goeasyapp\App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ShortLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shortLinks = ShortLink::latest()->get();

        return view('shortenLink', compact('shortLinks'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'original_link' => 'required|url'
        ]);

        $input['link_original'] = $request->original_link;
        $input['code'] = Str::random(6);
        $input['short_link'] = $_SERVER['HTTP_HOST'].'/shortlink/'.$input['code'];
        $input['link'] = $_SERVER['HTTP_HOST'].'/shortlink/'.random_int(1000000000, 9999999999).$input['code'].random_int(1000000000, 9999999999);
        $input['user'] = Auth::id();
        $input['campain'] = $id;

        ShortLink::create($input);

        return redirect()->back()->with('success', 'Shorten Link Generated Successfully!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shortenLink($code)
    {
        if(strlen($code) > 6) {
            $code = substr($code,10,6);
        }

        $find = ShortLink::where('code', $code)->first();
        header("Location: $find->link_original");
        exit();
    }
}
