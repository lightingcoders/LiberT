(function (window, document, $) {
    window.pageMixin = {
        data: function () {
            let data = {};

            if (window._vueData !== undefined) {
                data = window._vueData;
            }

            return data;
        },

        methods: {

        }
    };
})(window, document, jQuery);

