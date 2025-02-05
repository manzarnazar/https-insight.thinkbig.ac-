<?php


Route::namespace('User\Auth')->name('user.')->group(function () {

    Route::controller('LoginController')->group(function(){
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller('RegisterController')->group(function(){
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('registration.status');
        Route::post('check-mail', 'checkUser')->name('checkUser');
    });

    Route::controller('ForgotPasswordController')->group(function(){
        Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'sendResetCodeEmail')->name('password.email');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });
    Route::controller('ResetPasswordController')->group(function(){
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });
});

Route::middleware('auth')->name('user.')->group(function () {
    //authorization
    Route::namespace('User')->controller('AuthorizationController')->group(function(){
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend/verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify/email', 'emailVerification')->name('verify.email');
        Route::post('verify/mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify/g2fa', 'g2faVerification')->name('go2fa.verify');
    });

    Route::middleware(['check.status'])->group(function () {

        Route::get('user/data', 'User\UserController@userData')->name('data');
        Route::post('user/data/submit', 'User\UserController@userDataSubmit')->name('data.submit');

        Route::middleware('registration.complete')->namespace('User')->group(function () {

            Route::controller('UserController')->group(function(){
                Route::get('dashboard', 'home')->name('home');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions','transactions')->name('transactions');

                Route::get('attachment-download/{fil_hash}','attachmentDownload')->name('attachment.download');

            });

            //Profile setting
            Route::controller('ProfileController')->group(function(){
                Route::get('profile/setting', 'profile')->name('profile.setting');
                Route::post('profile/setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
                Route::post('profile', 'profileUpdate')->name('profile.update');
            });

            // Podcast
            Route::controller('PodcastController')->name('podcast.')->prefix('podcast')->group(function(){
                Route::get('list','podcastList')->name('list');
                Route::get('new','newPodcast')->name('new');
                Route::post('new','podcastStore');
                Route::post('list','podcastUpdate')->name('update');
                Route::post('/delete/{id}', 'podcastDelete')->name('delete');
                Route::get('new/episode','newEpisode')->name('new.episode');
                Route::post('new/episode','createEpisode')->name('new.episode');
                Route::get('episodes/list','episodeList')->name('episodes.list');
                Route::post('episodes/list','episodeUpdate')->name('episodes.list');
                Route::get('episode/audio/{id}','audio')->name('episode.audio');
                Route::post('delete/episode/{id}', 'episodeDelete')->name('episode.delete');
                Route::get('episode/play/{filename}','episodePlay')->name('episode.play');

                Route::get('/add/bookmark/{id}', 'bookmark')->name('bookmark.add');
                Route::get('bookmarks', 'bookmarks')->name('bookmarks');
                Route::get('subscriber/list', 'subscriberList')->name('subscriber.list');
                Route::get('subscription', 'subscription')->name('subscription');

            });

            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function(){
                Route::get('/', 'withdrawMoney');
                Route::post('/', 'withdrawStore')->name('.money');
                Route::get('preview', 'withdrawPreview')->name('.preview');
                Route::post('preview', 'withdrawSubmit')->name('.submit');
                Route::get('history', 'withdrawLog')->name('.history');
            });
        });

        // Payment
        Route::middleware('registration.complete')->controller('Gateway\PaymentController')->group(function(){
            Route::get('episode/podcast/subscription/{id}', 'payment')->name('payment');
            Route::get('podcast/subscription/{id}', 'podcastSubscriptionPayment')->name('subscription.payment');
            Route::post('subscription-calculation', 'subscriptionAmountCalculation')->name('subscription-calculation');
            Route::any('/deposit', 'deposit')->name('deposit');
            Route::post('deposit/insert', 'depositInsert')->name('deposit.insert');
            Route::get('deposit/confirm', 'depositConfirm')->name('deposit.confirm');
            Route::get('deposit/manual', 'manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'manualDepositUpdate')->name('deposit.manual.update');
        });
    });
});
