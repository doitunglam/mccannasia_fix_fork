<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
Route::get('/lalala', function(){
	Artisan::call('route:clear');
	Artisan::call('cache:clear');
	Artisan::call('config:clear');
	Artisan::call('view:clear');
	session()->flash('success', trans("Cache is cleared"));
	return redirect()->back();
})->name('system.clear.cache');

