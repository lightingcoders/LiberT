let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/**
 * JavaScript Assets: This is where both global assets as well as each pages's
 * scope javascript assets are compiled from the resource folder into the public
 * folder.
 */

/* Landing - Global */
mix.js('resources/assets/js/landing/welcome/app.js', 'public/js/landing/welcome');

let i, page, script, source, destination;

const page_scripts = {
    'authentication': ['script'], // Authentication
    'profile': ['script', 'mixin'], // Profile
    'home': ['script', 'mixin'], // Home
    'home/offers': ['script', 'mixin'], // Home/Offers
    'home/trades': ['script', 'mixin'], // Home/Trades
    'administration/configuration/general': ['script', 'mixin'], // Administration/Configuration/General
    'administration/configuration/notification': ['script', 'mixin'], // Administration/Configuration/Notification
    'administration/configuration/settings': ['script', 'mixin'], // Administration/Configuration/Settings
    'administration/manage_users': ['script'], // Administration/ManageUsers
    'marketplace/sell_coin': ['script', 'mixin'], // Marketplace/SellCoin
    'marketplace/create_offer': ['script', 'mixin'], // Marketplace/CreateOffer
    'marketplace/buy_coin': ['script', 'mixin'], // Marketplace/BuyCoin
    'moderation/manage_trades': ['script', 'mixin'], // Moderation/ManageTrades
    'moderation/offer_settings': ['script', 'mixin'], // Moderation/OfferSettings
    'wallet': ['script', 'mixin'], // Wallet
};

/* Dashboard - Global */
mix.js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/vue.js', 'public/js');

for (page in page_scripts) {
    for (i = 0; i < page_scripts[page].length; i++) {
        mix.js('resources/assets/js/pages/' + page + '/' + page_scripts[page][i] + '.js', 'public/js/pages/' + page);
    }
}

/**
 * StyleSheet Assets: This is where both global assets as well as each pages's
 * scope stylesheets assets are compiled from the resource folder into the public
 * folder.
 */
/* Landing - Global */
mix.sass('resources/assets/sass/landing/welcome/app.scss', 'public/css/landing/welcome');

/* Dashboard - Global */
mix.sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/pages/chat.scss', 'public/css/pages') // Chat Page
   .sass('resources/assets/sass/pages/authentication.scss', 'public/css/pages') // Authentication Page
   .sass('resources/assets/sass/pages/profile.scss', 'public/css/pages'); // Profile Page

