<?php

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

Route::group([], function () {
    // Landing routes
    Route::get('/', function () { return redirect()->route('home.index'); });

    // Authentication route
    Route::group(['namespace' => 'Authentication'], function () {
        // Login Routes
        Route::group(['prefix' => 'login'], function () {
            Route::get('', 'LoginController@showLoginForm')->name('login');
            Route::post('', 'LoginController@login');
            Route::post('check-2fa', 'LoginController@check2FA')->name('login.check-2fa');
        });

        Route::post('logout', 'LoginController@logout')->name('logout');


        // Registration Routes...
        Route::group(['prefix' => 'register'], function () {
            Route::get('', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('', 'RegisterController@register');

            Route::get('verify', 'RegisterController@verify')->name('verifyEmailLink');
        });

        // Password Reset Routes...
        Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
            // Reset
            Route::group(['prefix' => 'reset'], function () {
                Route::get('', 'ForgotPasswordController@showLinkRequestForm')->name('request');
                Route::get('{token}', 'ResetPasswordController@showResetForm')->name('reset');
                Route::post('', 'ResetPasswordController@reset');
            });

            Route::post('email', 'ForgotPasswordController@sendResetLinkEmail')->name('email');
        });

    });

    // Profile
    Route::group(['as' => 'profile.', 'prefix' => 'profile'], function () {
        // Picture
        Route::get('{user_name}/storage/{picture}', 'ProfileController@picture')->name('picture');
    });

    // ThirdParty Services
    Route::group(['namespace' => 'Services'], function () {
        // BlockCypher
        Route::group(['as' => 'blockcypher.', 'prefix' => 'blockcypher'], function (){
            // Webhook
            Route::group(['as' => 'hook.', 'prefix' => 'hook'], function (){
                // Test
                Route::post('test', 'BlockCypher\WebhookController@handleBitcoin')->name('test');

                // Bitcoin
                Route::post('btc', 'BlockCypher\WebhookController@handleBitcoin')->name('btc');

                // Dogecoin
                Route::post('doge', 'BlockCypher\WebhookController@handleDogecoin')->name('doge');

                // Dash
                Route::post('dash', 'BlockCypher\WebhookController@handleDash')->name('dash');

                // Litecoin
                Route::post('ltc', 'BlockCypher\WebhookController@handleLitecoin')->name('ltc');
            });
        });
    });

    // Dashboard Routes
    Route::group(['middleware' => 'auth'], function () {
        // Stateless API
        Route::group(['as' => 'ajax.', 'prefix' => 'ajax'], function () {

            // Profile
            Route::group(['as' => 'profile.', 'prefix' => 'profile/{user}'], function () {
                // Get Notifications
                Route::post('unread-notifications', 'ProfileController@unreadNotifications')->name('unreadNotifications');

                // Get Trade Chats
                Route::post('active-trade-chats', 'ProfileController@activeTradeChats')->name('activeTradeChats');

                // Set Online Status
                Route::put('online', 'ProfileController@setOnline')->name('setOnline');

                // Set Away Status
                Route::put('away', 'ProfileController@setAway')->name('setAway');

                // Resend Email Verification
                Route::post('resend-verification-email', 'ProfileController@resendVerificationEmail')->name('resendVerificationEmail');

                // Resend Phone Verification
                Route::post('resend-verification-sms', 'ProfileController@resendVerificationSms')->name('resendVerificationSms');

                // Confirm Phone
                Route::post('confirm-phone', 'ProfileController@confirmPhone')->name('confirmPhone');

                // Get Ratings
                Route::post('get-ratings', 'ProfileController@getRatings')->name('get-ratings');
            });
        });

        // Home Page
        Route::group(['as' => 'home.', 'prefix' => 'home'], function () {
            // Index
            Route::get('', 'Home\HomeController@index')->name('index');

            Route::group(['as' => 'offers.', 'prefix' => 'offer'], function (){
                // Actions
                Route::group(['prefix' => '{token}'], function (){
                    // Index
                    Route::get('', 'Home\OffersController@index')->name('index');

                    // Start Trade
                    Route::post('start-trade', 'Home\OffersController@startTrade')->name('start-trade');

                    // Delete
                    Route::delete('delete', 'Home\OffersController@delete')->name('delete');

                    // Toggle
                    Route::post('toggle', 'Home\OffersController@toggle')->name('toggle');
                });

                // Offers Data
                Route::post('data', 'Home\OffersController@data')->name('data');
            });

            Route::group(['as' => 'trades.', 'prefix' => 'trade'], function (){
                // Actions
                Route::group(['prefix' => '{token}'], function (){
                    // Index
                    Route::get('', 'Home\TradesController@index')->name('index');

                    // Confirm
                    Route::post('confirm', 'Home\TradesController@confirm')->name('confirm');

                    // Complete
                    Route::post('complete', 'Home\TradesController@complete')->name('complete');

                    // Dispute
                    Route::post('dispute', 'Home\TradesController@dispute')->name('dispute');

                    // Send Message
                    Route::post('send-message', 'Home\TradesController@sendMessage')->name('send-message');

                    // Upload Media
                    Route::post('upload-media', 'Home\TradesController@uploadMedia')->name('upload-media');

                    // Download
                    Route::get('file/{name}', 'Home\TradesController@download')->name('download');

                    // Cancel
                    Route::post('cancel', 'Home\TradesController@cancel')->name('cancel');

                    // Rate
                    Route::post('rate', 'Home\TradesController@rate')->name('rate');
                });

                // Offers Data
                Route::post('data', 'Home\TradesController@data')->name('data');
            });

        });

        Route::group(['as' => 'marketplace.', 'prefix' => 'marketplace', 'namespace' => 'Marketplace'], function () {
            // Create Offer
            Route::group(['as' => 'create-offer.', 'prefix' => 'create-offer'], function () {
                // Buy
                Route::get('buy', 'CreateOfferController@buyIndex')->name('buy');

                // Sell
                Route::get('sell', 'CreateOfferController@sellIndex')->name('sell');

                // Store
                Route::post('{type}', 'CreateOfferController@store')->name('store');
            });

            // Buy Coin
            Route::group(['as' => 'buy-coin.', 'prefix' => 'buy-coin'], function () {
                // Index
                Route::get('', 'BuyCoinController@index')->name('index');

                // Data
                Route::post('data', 'BuyCoinController@data')->name('data');
            });

            // Sell Coin
            Route::group(['as' => 'sell-coin.', 'prefix' => 'sell-coin'], function () {
                // Index
                Route::get('', 'SellCoinController@index')->name('index');

                // Data
                Route::post('data', 'SellCoinController@data')->name('data');
            });
        });

        // Wallet Page
        Route::group(['as' => 'wallet.', 'prefix' => 'wallet'], function () {
            // Index
            Route::get('', 'WalletController@index')->name('index');

            // Generate Address
            Route::post('{coin}/generate-address', 'WalletController@generateAddress')->name('generate-address');

            // Address Data
            Route::post('{coin}/address-data', 'WalletController@addressData')->name('address-data');

            // Transaction Data
            Route::post('{coin}/transaction-data', 'WalletController@transactionData')->name('transaction-data');

            // Send Asset
            Route::post('{coin}/send', 'WalletController@send')->name('send');

        });

        // Profile Page
        Route::group([
            'as' => 'profile.', 'namespace' => 'Profile', 'middleware' => 'profile.view', 'prefix' => 'profile/{user}',
        ], function () {
            // Index
            Route::get('', 'ProfileController@index')->name('index');

            // Ratings Data
            Route::post('ratings-data', 'ProfileController@ratingsData')->name('ratings-data');

            // Offer Data
            Route::post('offers-data', 'ProfileController@offersData')->name('offers-data');

            // Private Details
            Route::group(['middleware' => 'profile.view_private_details'], function () {
                // Notifications
                Route::group(['as' => 'notifications.', 'prefix' => 'notifications'], function () {
                    // Index
                    Route::get('', 'NotificationsController@index')->name('index');

                    // markAllAsRead
                    Route::post('markAllAsRead', 'NotificationsController@markAllAsRead')->name('markAllAsRead');

                    // markAllAsRead
                    Route::post('{id}/markAsRead', 'NotificationsController@markAsRead')->name('markAsRead');

                    // Notifications Data
                    Route::post('data', 'NotificationsController@data')->name('data');
                });

                // Trades
                Route::group(['as' => 'trades.', 'prefix' => 'trades'], function () {
                    // Index
                    Route::get('', 'TradesController@index')->name('index');

                    // Data
                    Route::post('data', 'TradesController@data')->name('data');
                });
            });

            // Settings
            Route::group(['middleware' => 'profile.edit_private_details', 'as' => 'settings.', 'prefix' => 'settings'], function () {
                // Index
                Route::get('', 'SettingsController@index')->name('index');

                // Update Profile
                Route::post('update-profile', 'SettingsController@updateProfile')->name('update-profile');

                // Update Settings
                Route::post('update-settings', 'SettingsController@updateSettings')->name('update-settings');

                // Update Password
                Route::post('update-password', 'SettingsController@updatePassword')->name('update-password');

                Route::middleware('role:admin')->group(function () {
                    // Update Role
                    Route::post('update-role', 'SettingsController@updateRole')->name('update-role');
                });

                // Moderation Activity Data
                Route::post('moderation-activity-data', 'SettingsController@moderationActivityData')
                    ->name('moderation-activity-data');

                // Upload Picture
                Route::post('upload-picture', 'SettingsController@uploadPicture')->name('upload-picture');

                // Delete Picture
                Route::post('delete-picture', 'SettingsController@deletePicture')->name('delete-picture');

                // Delete Account
                Route::post('delete-account', 'SettingsController@deleteAccount')->name('delete-account');
            });

            // Two Factor Authentication
            Route::group(['middleware' => 'profile.edit_private_details', 'as' => '2fa.', 'prefix' => '2fa'], function () {
                // Setup
                Route::post('setup', 'TwoFactorController@setup')->name('setup');

                // Reset
                Route::post('reset', 'TwoFactorController@reset')->name('reset');
            });

            // Contacts
            Route::group(['as' => 'contacts.', 'prefix' => 'contacts'], function () {
                // Index
                Route::get('', 'ContactsController@index')->name('index');

                // Add
                Route::put('add', 'ContactsController@add')->name('add');

                // Delete
                Route::put('delete', 'ContactsController@delete')->name('delete');

                // Trust
                Route::put('trust', 'ContactsController@trust')->name('trust');

                // Untrust
                Route::put('untrust', 'ContactsController@untrust')->name('untrust');

                // Block
                Route::put('block', 'ContactsController@block')->name('block');

                // Unblock
                Route::put('unblock', 'ContactsController@unblock')->name('unblock');

                // Contacts Data
                Route::post('data', 'ContactsController@data')->name('data');
            });

        });

        // Administration Routes
        Route::group([
            'as' => 'administration.', 'namespace' => 'Administration', 'middleware' => 'role:admin|super_moderator',
            'prefix' => 'administration',
        ], function () {
            // Manage Users Page
            Route::group(['as' => 'manage_users.', 'prefix' => 'manage_users'], function () {
                // Index
                Route::get('', 'ManageUsersController@index')->name('index');

                // Activate
                Route::post('activate', 'ManageUsersController@activate')->name('activate');

                // Deactivate
                Route::post('deactivate', 'ManageUsersController@deactivate')->name('deactivate');

                // Trash
                Route::post('trash', 'ManageUsersController@trash')->name('trash');

                // Trash
                Route::post('restore', 'ManageUsersController@restore')->name('restore');

                // Delete
                Route::post('delete', 'ManageUsersController@delete')->name('delete');

                // DataTable
                Route::post('data', 'ManageUsersController@data')->name('data');
            });

            // Configuration
            Route::group(['as' => 'configuration.', 'prefix' => 'configuration', 'namespace' => 'Configuration'], function () {
                // General
                Route::group(['as' => 'general.', 'prefix' => 'general'], function () {
                    // Index
                    Route::get('', 'GeneralController@index')->name('index');

                    // Update General
                    Route::post('update', 'GeneralController@update')->name('update');
                });

                // Notification
                Route::group(['as' => 'notification.', 'prefix' => 'notification'], function () {
                    // Index
                    Route::get('', 'NotificationController@index')->name('index');

                    // Update General
                    Route::post('update-general', 'NotificationController@updateGeneral')->name('update-general');

                    // Update Component
                    Route::post('update-component', 'NotificationController@updateComponent')->name('update-component');

                    // Update Template
                    Route::post('update-template', 'NotificationController@updateTemplate')->name('update-template');
                });

                // Settings
                Route::group(['as' => 'settings.', 'prefix' => 'settings'], function () {
                    // Index
                    Route::get('', 'SettingsController@index')->name('index');

                    // Update General
                    Route::post('update', 'SettingsController@update')->name('update');
                });

            });

        });

        Route::group([
            'as' => 'moderation.', 'namespace' => 'Moderation', 'middleware' => 'role:admin|super_moderator|moderator', 'prefix' => 'moderation',
        ], function () {
            // Manage trades Page
            Route::group(['as' => 'manage_trades.', 'role:admin|super_moderator', 'prefix' => 'manage_trades'], function () {
                // Index
                Route::get('', 'ManageTradesController@index')->name('index');

                // Admin Exclusive Actions
                Route::middleware('role:admin')->group(function (){
                    // Payout
                    Route::post('payout', 'ManageTradesController@payout')->name('payout');
                });

                // Data
                Route::post('data', 'ManageTradesController@data')->name('data');
            });

            // Offer settings Page
            Route::group(['as' => 'offer_settings.', 'prefix' => 'offer_settings'], function () {
                // Index
                Route::get('', 'OfferSettingsController@index')->name('index');

                // Payment Methods Store
                Route::post('store-payment-methods', 'OfferSettingsController@storePaymentMethod')->name('store-payment-methods');

                // Payment Method Categories Store
                Route::post('store-payment-method-categories', 'OfferSettingsController@storePaymentMethodCategory')->name('store-payment-method-categories');

                // Offer Tags Store
                Route::post('store-offer-tags', 'OfferSettingsController@storeOfferTag')->name('store-offer-tags');

                // Payment Methods Delete
                Route::delete('delete-payment-methods', 'OfferSettingsController@deletePaymentMethod')->name('delete-payment-methods');

                // Payment Method Categories Delete
                Route::delete('delete-payment-method-categories', 'OfferSettingsController@deletePaymentMethodCategory')->name('delete-payment-method-categories');

                // Offer Tags Delete
                Route::delete('delete-offer-tags', 'OfferSettingsController@deleteOfferTag')->name('delete-offer-tags');

                // Payment Methods Data
                Route::post('payment-methods-data', 'OfferSettingsController@paymentMethodsData')->name('payment-methods-data');

                // Payment Method Categories Data
                Route::post('payment-method-categories-data', 'OfferSettingsController@paymentMethodCategoriesData')->name('payment-method-categories-data');

                // Offer Tags Data
                Route::post('offer-tags-data', 'OfferSettingsController@offerTagsData')->name('offer-tags-data');

            });
        });
    });
});

