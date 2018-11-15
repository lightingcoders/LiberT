require('particles.js');

let Page = function () {
    let handleFormElements = function () {
        $('.skin-square input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
        });
    };

    return {
        init: function () {
            handleFormElements();

            this.initParticleJs();
        },

        initParticleJs: function () {
            particlesJS.load(
                'particles-js', '/js/pages/authentication/assets/particles.json'
            );
        }
    }
}();

$(document).ready(function () {
    Page.init();
});
