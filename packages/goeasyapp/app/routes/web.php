<?php

use Goeasyapp\App\Http\Controllers\AppController;
use Goeasyapp\App\Http\Controllers\CampainMissionController;
use Goeasyapp\App\Http\Controllers\LanguageController;
use Goeasyapp\App\Http\Controllers\CategoryNewController;
use Goeasyapp\App\Http\Controllers\NewItemController;
use Goeasyapp\App\Http\Controllers\CampainController;
use Goeasyapp\App\Http\Controllers\AgencyController;
use Goeasyapp\App\Http\Controllers\BannerController;
use Goeasyapp\App\Http\Controllers\ConfigController;
use Goeasyapp\App\Http\Controllers\ResuftManagementController;

use Goeasyapp\App\Http\Controllers\ShortLinkController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [AppController::class, 'home'])->name('home.base');
/* begin author Doi Tung Lam */
Route::get('/about-us', [AppController::class, 'homeAboutUs'])->name('home.aboutUs');
Route::get('/advetiser', [AppController::class, 'advertiser'])->name('home.advertiser');
Route::get('/publisher-overview', [AppController::class, 'publisherOverview'])->name('home.publisherOverview');
Route::get('/publisher-policy', [AppController::class, 'publisherPolicy'])->name('home.publisherPolicy');
Route::get('/contact', [AppController::class, 'contact'])->name('home.contact');
/* end author Doi Tung Lam */
Route::get('/introduce/{id}', [AppController::class, 'introduce'])->name('home.base.introduce');
Route::get('shortlink/{code}', [ShortLinkController::class, 'shortenLink'])->name('shortlink.get');
Route::prefix('admin')->group(function () {

    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [CampainController::class, 'day'])->name('home');
    Route::middleware(['auth:sanctum', 'verified'])->get('/language', [LanguageController::class, 'list'])->name('language.list');
    Route::middleware(['auth:sanctum', 'verified'])->get('/language/create', [LanguageController::class, 'create'])->name('language.create');
    Route::middleware(['auth:sanctum', 'verified'])->post('/language/store/{id}', [LanguageController::class, 'store'])->name('language.store');
    Route::middleware(['auth:sanctum', 'verified'])->get('language/update/{id}', [LanguageController::class, 'update'])->name('language.update');
    Route::middleware(['auth:sanctum', 'verified'])->delete('language/delete/{id}', [LanguageController::class, 'deleteItem'])->name('language.delete');
    Route::middleware(['auth:sanctum', 'verified'])->get('language/status/{id}', [LanguageController::class, 'status'])->name('language.status');

    Route::middleware(['auth:sanctum', 'verified'])->get('/category-new', [CategoryNewController::class, 'list'])->name('category-new.list');
    Route::middleware(['auth:sanctum', 'verified'])->get('/category-new/create', [CategoryNewController::class, 'create'])->name('category-new.create');
    Route::middleware(['auth:sanctum', 'verified'])->post('/category-new/store/{id}', [CategoryNewController::class, 'store'])->name('category-new.store');
    Route::middleware(['auth:sanctum', 'verified'])->get('category-new/update/{id}', [CategoryNewController::class, 'update'])->name('category-new.update');
    Route::middleware(['auth:sanctum', 'verified'])->delete('category-new/delete/{id}', [CategoryNewController::class, 'deleteItem'])->name('category-new.delete');
    Route::middleware(['auth:sanctum', 'verified'])->get('category-new/status/{id}', [CategoryNewController::class, 'status'])->name('category-new.status');

    Route::middleware(['auth:sanctum', 'verified'])->get('/blog', [NewItemController::class, 'list'])->name('blog.list');
    Route::middleware(['auth:sanctum', 'verified'])->get('/blog/create', [NewItemController::class, 'create'])->name('blog.create');
    Route::middleware(['auth:sanctum', 'verified'])->post('/blog/store/{id}', [NewItemController::class, 'store'])->name('blog.store');
    Route::middleware(['auth:sanctum', 'verified'])->get('blog/update/{id}', [NewItemController::class, 'update'])->name('blog.update');
    Route::middleware(['auth:sanctum', 'verified'])->delete('blog/delete/{id}', [NewItemController::class, 'deleteItem'])->name('blog.delete');
    Route::middleware(['auth:sanctum', 'verified'])->get('blog/status/{id}', [NewItemController::class, 'status'])->name('blog.status');

    Route::middleware(['auth:sanctum', 'verified'])->get('/banner', [BannerController::class, 'list'])->name('banner.list');
    Route::middleware(['auth:sanctum', 'verified'])->get('/banner/create', [BannerController::class, 'create'])->name('banner.create');
	Route::middleware(['auth:sanctum', 'verified'])->get('/banner/popup', [BannerController::class, 'popupList'])->name('banner.popup.list');
	Route::middleware(['auth:sanctum', 'verified'])->get('/banner/popup/create', [BannerController::class, 'popupCreate'])->name('banner.popup.create');
    Route::middleware(['auth:sanctum', 'verified'])->post('/banner/store/{id}', [BannerController::class, 'store'])->name('banner.store');
    Route::middleware(['auth:sanctum', 'verified'])->get('banner/update/{id}', [BannerController::class, 'update'])->name('banner.update');
    Route::middleware(['auth:sanctum', 'verified'])->delete('banner/delete/{id}', [BannerController::class, 'deleteItem'])->name('banner.delete');
    Route::middleware(['auth:sanctum', 'verified'])->get('banner/status/{id}', [BannerController::class, 'status'])->name('banner.status');

    Route::middleware(['auth:sanctum', 'verified'])->get('/config', [ConfigController::class, 'list'])->name('config.list');
    Route::middleware(['auth:sanctum', 'verified'])->get('/config/create', [ConfigController::class, 'create'])->name('config.create');
    Route::middleware(['auth:sanctum', 'verified'])->post('/config/store/{id}', [ConfigController::class, 'store'])->name('config.store');
    Route::middleware(['auth:sanctum', 'verified'])->get('config/update/{id}', [ConfigController::class, 'update'])->name('config.update');
    Route::middleware(['auth:sanctum', 'verified'])->delete('config/delete/{id}', [ConfigController::class, 'deleteItem'])->name('config.delete');
    Route::middleware(['auth:sanctum', 'verified'])->get('config/status/{id}', [ConfigController::class, 'status'])->name('config.status');

    Route::middleware(['auth:sanctum', 'verified'])->get('/campain', [CampainController::class, 'list'])->name('campain.list');
    Route::middleware(['auth:sanctum', 'verified'])->get('/campain/create', [CampainController::class, 'create'])->name('campain.create');
    Route::middleware(['auth:sanctum', 'verified'])->post('/campain/store/{id}', [CampainController::class, 'store'])->name('campain.store');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/update/{id}', [CampainController::class, 'update'])->name('campain.update');
    Route::middleware(['auth:sanctum', 'verified'])->delete('campain/delete/{id}', [CampainController::class, 'deleteItem'])->name('campain.delete');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/status/{id}', [CampainController::class, 'status'])->name('campain.status');


    Route::middleware(['auth:sanctum', 'verified'])->post('payment/done', [CampainController::class, 'paymentCreateStore'])->name('payment.store.done');
    Route::middleware(['auth:sanctum', 'verified'])->get('/campain/hot', [CampainController::class, 'hot'])->name('campain.hot');

    Route::middleware(['auth:sanctum', 'verified'])->get('/link/{campain}/{use_}', [CampainController::class, 'link_'])->name('campain.link');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/view/member/{id}', [CampainController::class, 'member'])->name('campain.member');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/statistical', [CampainController::class, 'statistical'])->name('campain.statistical');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/category/{id}', [CampainController::class, 'category'])->name('campain.category');
    Route::middleware(['auth:sanctum', 'verified'])->post('campain/export', [CampainController::class, 'export'])->name('campain.export');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/day', [CampainController::class, 'day'])->name('campain.day');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/my', [CampainController::class, 'my'])->name('campain.my');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/register/{id}', [CampainController::class, 'register'])->name('campain.register');
    Route::middleware(['auth:sanctum', 'verified'])->post('campain/register/{id}', [CampainController::class, 'registerStore'])->name('campain.register.store');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/resuft/{id}', [CampainController::class, 'resuft'])->name('campain.resuft');
    Route::middleware(['auth:sanctum', 'verified'])->post('campain/resuft/{id}', [CampainController::class, 'resuftStore'])->name('campain.resuft.store');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/list/resuft', [CampainController::class, 'resuftList'])->name('campain.resuft.list');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/list/check/{id}', [CampainController::class, 'resuftCheck'])->name('campain.resuft.check');
    Route::middleware(['auth:sanctum', 'verified'])->post('campain/resuft/check/{id}', [CampainController::class, 'resuftStoreCheck'])->name('campain.resuft.store.check');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/payment', [CampainController::class, 'payment'])->name('campain.payment');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/view/{id}', [CampainController::class, 'view'])->name('campain.view.info');
	Route::middleware(['auth:sanctum', 'verified'])->get('campain/mission', [CampainMissionController::class, 'index'])->name('campain.mission.list');
	Route::middleware(['auth:sanctum', 'verified'])->get('campain/mission/create', [CampainMissionController::class, 'getCreate'])->name('campain.mission.getCreate');
	Route::middleware(['auth:sanctum', 'verified'])->post('campain/mission/create', [CampainMissionController::class, 'postCreate'])->name('campain.mission.postCreate');
	Route::middleware(['auth:sanctum', 'verified'])->get('campain/mission/update/{id}', [CampainMissionController::class, 'getUpdate'])->name('campain.mission.getUpdate');
	Route::middleware(['auth:sanctum', 'verified'])->post('campain/mission/update/{id}', [CampainMissionController::class, 'postUpdate'])->name('campain.mission.postUpdate');
	Route::middleware(['auth:sanctum', 'verified'])->get('campain/mission/delete/{id}', [CampainMissionController::class, 'delete'])->name('campain.mission.delete');

    Route::middleware(['auth:sanctum', 'verified'])->get('resuft/management', [ResuftManagementController::class, 'list'])->name('resuft.management');
    Route::middleware(['auth:sanctum', 'verified'])->post('resuft/management/{id}', [ResuftManagementController::class, 'handleAction'])->name('resuft.handle.action');
    Route::middleware(['auth:sanctum', 'verified'])->post('resuft/management', [ResuftManagementController::class, 'handleAcceptAll'])->name('resuft.accept_all_resuft');

    Route::middleware(['auth:sanctum', 'verified'])->get('campain/download', [CampainController::class, 'download'])->name('campain.download');

    Route::middleware(['auth:sanctum', 'verified'])->get('campain/payment/create', [CampainController::class, 'paymentCreate'])->name('campain.payment.create');
    Route::middleware(['auth:sanctum', 'verified'])->post('payment/create', [CampainController::class, 'paymentCreateStore'])->name('payment.store');
    Route::middleware(['auth:sanctum', 'verified'])->get('campain/link/{id}', [CampainController::class, 'link'])->name('campain.link');
    Route::middleware(['auth:sanctum', 'verified'])->post('campain/link/{id}', [CampainController::class, 'linkStore'])->name('campain.link.store');
    Route::middleware(['auth:sanctum', 'verified'])->post('shortlink/{id}', [ShortLinkController::class, 'store'])->name('shortlink.store');



    Route::middleware(['auth:sanctum', 'verified'])->get('payment/list', [CampainController::class, 'paymentList'])->name('payment.list');
    Route::middleware(['auth:sanctum', 'verified'])->get('payment/request/{id}', [CampainController::class, 'paymentRequest'])->name('payment.request');
    Route::middleware(['auth:sanctum', 'verified'])->post('payment/request/{id}', [CampainController::class, 'paymentRequestCheck'])->name('payment.request.check');
    Route::middleware(['auth:sanctum', 'verified'])->get('payment/list_recharge', [CampainController::class, 'paymentListRecharge'])->name('payment.listRecharge');
    Route::middleware(['auth:sanctum', 'verified'])->get('payment/list_withdraw', [CampainController::class, 'paymentListWithdraw'])->name('payment.listWithdraw');
    Route::middleware(['auth:sanctum', 'verified'])->post('payment/recharge', [CampainController::class, 'paymentRecharge'])->name('payment.recharge');
    Route::middleware(['auth:sanctum', 'verified'])->post('payment/withdraw', [CampainController::class, 'paymentWithdraw'])->name('payment.withdraw');
    Route::middleware(['auth:sanctum', 'verified'])->get('payment/accept_all/{type}', [CampainController::class, 'paymentAcceptAll'])->name('payment.acceptAll');
    Route::middleware(['auth:sanctum', 'verified'])->get('payment/list_admin_recharge', [CampainController::class, 'paymentAdminListRecharge'])->name('payment.listAdminRecharge');
    Route::middleware(['auth:sanctum', 'verified'])->get('payment/list_admin_withdraw', [CampainController::class, 'paymentAdminListWithdraw'])->name('payment.listAdminWithdraw');

    Route::middleware(['auth:sanctum', 'verified'])->get('/set-locale-en', [AppController::class, 'localeEn'])->name('admin.locale.en');
    Route::middleware(['auth:sanctum', 'verified'])->get('/set-locale-vi', [AppController::class, 'localeVi'])->name('admin.locale.vi');
    Route::middleware(['auth:sanctum', 'verified'])->get('/set-locale-cn', [AppController::class, 'localeCn'])->name('admin.locale.cn');

    Route::middleware(['auth:sanctum', 'verified'])->get('user/reset/{id}', [AgencyController::class, 'reset'])->name('user.reset');
    Route::middleware(['auth:sanctum', 'verified'])->get('user/restore', [AgencyController::class, 'restore'])->name('user.restore');
    Route::middleware(['auth:sanctum', 'verified'])->post('user/delete/all', [AgencyController::class, 'deleteAll'])->name('user.delete.all');
    Route::middleware(['auth:sanctum', 'verified'])->post('user/restore/all', [AgencyController::class, 'restoreAll'])->name('user.restore.all');
    Route::middleware(['auth:sanctum', 'verified'])->get('user/agency', [AgencyController::class, 'index'])->name('user');
    Route::middleware(['auth:sanctum', 'verified'])->get('user/staff', [AgencyController::class, 'indexStaff'])->name('user.staff');
    Route::middleware(['auth:sanctum', 'verified'])->get('user/alert', [AgencyController::class, 'alert'])->name('user.alert');
    Route::middleware(['auth:sanctum', 'verified'])->get('create-user/agency', [AgencyController::class, 'create'])->name('user.create');
    Route::middleware(['auth:sanctum', 'verified'])->get('create-user/staff', [AgencyController::class, 'createStaff'])->name('user.create.staff');
    Route::middleware(['auth:sanctum', 'verified'])->post('create-user/{id}', [AgencyController::class, 'store'])->name('user.store');
    Route::middleware(['auth:sanctum', 'verified'])->get('status-user/{id}', [AgencyController::class, 'status'])->name('user.status');
    Route::middleware(['auth:sanctum', 'verified'])->post('update-user/{id}', [AgencyController::class, 'storeUpdate'])->name('user.storeUpdate');
    Route::middleware(['auth:sanctum', 'verified'])->get('update-user/{id}', [AgencyController::class, 'update'])->name('user.update');
    Route::middleware(['auth:sanctum', 'verified'])->delete('delete-user/{id}', [AgencyController::class, 'deleteItem'])->name('user.delete');
    Route::middleware(['auth:sanctum', 'verified'])->get('user/change-amount/{id}', [AgencyController::class, 'viewChangeAmount'])->name('user.view_change_amount');
    Route::middleware(['auth:sanctum', 'verified'])->post('user/change-amount/{id}', [AgencyController::class, 'changeAmount'])->name('user.change_amount');
    Route::middleware(['auth:sanctum', 'verified'])->get('user/change-all-amount', [AgencyController::class, 'viewChangeAllAmount'])->name('user.view_change_all_amount');
    Route::middleware(['auth:sanctum', 'verified'])->post('user/change-all-amount', [AgencyController::class, 'changeAllAmount'])->name('user.change_all_amount');
    Route::middleware(['auth:sanctum', 'verified'])->post('user/change-password/{id}', [AgencyController::class, 'changePassword'])->name('user.change_password');

    // Route::middleware(['auth:sanctum', 'verified'])->get('setting', [SettingController::class, 'index'])->name('setting.index');
    // Route::middleware(['auth:sanctum', 'verified'])->get('setting/edit', [SettingController::class, 'viewSetting'])->name('setting.edit');
    // Route::middleware(['auth:sanctum', 'verified'])->post('setting', [SettingController::class, 'store'])->name('setting.store');
});
