window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('./plugins/jquery.min');
} catch (e) {
    console.error("Unable to load Jquery!")
}

try {
    window.bootstrap = require('./plugins/bootstrap.min');
} catch (e) {
    console.error("Unable to load Bootstrap!")
}

/**
 * We load all other bundled requirements for the home page.
 */

require('jquery-validation');
require('magnific-popup');

require('./plugins/jquery.easing.min');
require('./plugins/jquery.form.min');
require('./plugins/jquery.parallaxie.min');
require('./plugins/owl.carousel');

require('particles.js');

/**
 * Including page level scripts
 */
require('./core/global');
require('./core/particle');
