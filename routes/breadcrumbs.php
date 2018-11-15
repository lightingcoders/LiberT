<?php
/**
 * ======================================================================================================
 * File Name: breadcrumbs.blade.php
 * ======================================================================================================
 * Author: HolluwaTosin360
 * ------------------------------------------------------------------------------------------------------
 * Portfolio: http://codecanyon.net/user/holluwatosin360
 * ------------------------------------------------------------------------------------------------------
 * Date & Time: 9/1/2018 (7:15 PM)
 * ------------------------------------------------------------------------------------------------------
 *
 * Copyright (c) 2018. This project is released under the standard of CodeCanyon License.
 * You may NOT modify/redistribute this copy of the project. We reserve the right to take legal actions
 * if any part of the license is violated. Learn more: https://codecanyon.net/licenses/standard.
 *
 * ------------------------------------------------------------------------------------------------------
 */

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home.index'));
});

// Wallet
Breadcrumbs::for('wallet', function ($trail) {
    $trail->parent('home');
    $trail->push('Wallet', route('wallet.index'));
});

// Buy Coin
Breadcrumbs::for('marketplace.buy_coin', function ($trail) {
    $trail->parent('home');
    $trail->push('Buy Coin', route('marketplace.buy-coin.index'));
});

// Buy Offer
Breadcrumbs::for('buy_offer', function ($trail, $token) {
    $trail->parent('marketplace.buy_coin');
    $trail->push('Offer', route('home.offers.index', ['token' => $token]));
});

// Sell Coin
Breadcrumbs::for('marketplace.sell_coin', function ($trail) {
    $trail->parent('home');
    $trail->push('Sell Coin', route('marketplace.sell-coin.index'));
});

// Sell Offer
Breadcrumbs::for('sell_offer', function ($trail, $token) {
    $trail->parent('marketplace.sell_coin');
    $trail->push('Offer', route('home.offers.index', ['token' => $token]));
});

// Create Buy Offer
Breadcrumbs::for('marketplace.create_offer.buy', function ($trail) {
    $trail->parent('home');
    $trail->push('Create Buy Offer', route('marketplace.create-offer.buy'));
});

// Create Sell Offer
Breadcrumbs::for('marketplace.create_offer.sell', function ($trail) {
    $trail->parent('home');
    $trail->push('Create Sell Offer', route('marketplace.create-offer.sell'));
});

// Manage Users
Breadcrumbs::for('administration.manage_users', function ($trail) {
    $trail->parent('home');
    $trail->push('Manage Users', route('administration.manage_users.index'));
});

// General Configuration
Breadcrumbs::for('administration.configuration.general', function ($trail) {
    $trail->parent('home');
    $trail->push('General Configuration', route('administration.configuration.notification.index'));
});

// Notification Configuration
Breadcrumbs::for('administration.configuration.notification', function ($trail) {
    $trail->parent('home');
    $trail->push('Notification Configuration', route('administration.configuration.notification.index'));
});

// Settings Configuration
Breadcrumbs::for('administration.configuration.settings', function ($trail) {
    $trail->parent('home');
    $trail->push('Settings Configuration', route('administration.configuration.settings.index'));
});

// Profile
Breadcrumbs::for('profile', function ($trail, $name) {
    $trail->parent('home');
    $trail->push('Profile', route('profile.index', compact('name')));
});

