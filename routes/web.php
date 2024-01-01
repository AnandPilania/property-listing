<?php

use App\Lib\Router;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
    Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});

// User conversations
Route::controller('GroupchatController')->prefix('conversation')->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('conversation.index');
    Route::post('/store', 'store')->name('conversation.store');
    Route::get('/show/{id}', 'show')->name('conversation.show');
    Route::get('/add_part/{id}', 'add_part')->name('conversation.add_part');
    Route::post('/send_message/{conversation_id}', 'send_message')->name('conversation.send_message');
    Route::get('/search_users/{conversation_id?}', 'search_users')->name('conversation.search_users');
    Route::get('/invite_users/{conversation_id}/{user_id}', 'invite_users')->name('conversation.invite_users');
    Route::get('/accept_invite/{conversation_id}/{user_id}', 'accept_invite')->name('conversation.accept_invite');
    Route::get('/decline_invite/{conversation_id}/{user_id}', 'decline_invite')->name('conversation.decline_invite');
    Route::get('/leave_group/{conversation_id}/{user_id}', 'leave_group')->name('conversation.leave_group');
    Route::post('/share_prop_to_conversation', 'share_prop_to_conversation')->name('conversation.share_prop_to_conversation');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit')->name('contact.submit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    // blog
    Route::get('blog', 'blog')->name('blog');
    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');


    // property
    Route::get('properties', 'propertyShow')->name('properties');
    Route::get('property/details/{slug}/{id}', 'propertyDetails')->name('property.details');
    Route::post('property/search', 'propertySearch')->name('property.search');
    Route::get('property/location/{id}', 'cityProperty')->name('property.city');


    // plan
    Route::get('plans', 'plans')->name('plans');

    // subscriber
    Route::post('/subscribe', 'subscribe')->name('subscribe');


    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});
