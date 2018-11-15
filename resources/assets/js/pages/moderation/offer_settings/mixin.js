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
            resetPaymentMethod: function(id){
                this.form.paymentMethod.id = '';
                this.form.paymentMethod.category = '';
                this.form.paymentMethod.name = '';
            },

            resetPaymentMethodCategory: function(id){
                this.form.paymentMethodCategory.id = '';
                this.form.paymentMethodCategory.name = '';
            },

            resetOfferTag: function(id){
                this.form.offerTag.id = '';
                this.form.offerTag.name = '';
            },
        }
    };
})(window, document, jQuery);

