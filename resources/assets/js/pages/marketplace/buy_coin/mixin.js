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
            formatAmount: function (value) {
                let currency = (this.currency) ? this.currency : 'USD';

                return new Intl.NumberFormat(this.locale, {
                    style: 'currency', currencyDisplay: 'symbol', currency: currency
                }).format(value);
            }
        },

        computed: {
            coinPrice: function () {
                let currency = (this.currency) ? this.currency : 'USD';
                let coin = (this.coin) ? this.coin : 'BTC';

                return this.coin_prices[coin.toUpperCase()][currency.toUpperCase()];
            },

            profitMarginPrice: function() {
                return (this.totalPercent * this.coinPrice) / 100;
            },

            totalPercent: function () {
                let margin = 0;

                if (this.profit_margin) {
                    margin = Math.abs(this.profit_margin);
                }

                return 100 + margin;
            }
        }
    };
})(window, document, jQuery);

