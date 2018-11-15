window.Page = function () {
    let dataTable = {};

    var handlePaymentMethodEditor = function () {
        let selector = '#payment-methods-table';

        $(selector).on('click', '.edit', function (e) {
            data = dataTable[selector].row('#' + $(this).data('id')).data();

            window.app.form.paymentMethod.id = data.id;
            window.app.form.paymentMethod.category = data.payment_method_category_id;
            window.app.form.paymentMethod.name = data.name;

            $('#payment-method-form').modal('show');
        });
    };

    var handlePaymentMethodCategoryEditor = function () {
        let selector = '#payment-method-categories-table';

        $(selector).on('click', '.edit', function (e) {
            data = dataTable[selector].row('#' + $(this).data('id')).data();

            window.app.form.paymentMethodCategory.id = data.id;
            window.app.form.paymentMethodCategory.name = data.name;

            $('#payment-method-category-form').modal('show');
        });
    };

    var handleOfferTagEditor = function () {
        let selector = '#offer-tags-table';

        $(selector).on('click', '.edit', function (e) {
            data = dataTable[selector].row('#' + $(this).data('id')).data();

            window.app.form.offerTag.id = data.id;
            window.app.form.offerTag.name = data.name;

            $('#offer-tag-form').modal('show');
        });
    };

    return {
        init: function () {
            this.initDataTable();

            // Begin Form Editor
            handlePaymentMethodEditor();
            handlePaymentMethodCategoryEditor();
            handleOfferTagEditor();
        },

        initDataTable: function () {
            $.each(window._tableData, function (index, value) {
                let selector = value['selector'],
                    options  = value['options'];

                dataTable[selector] = $(selector).DataTable(options);


                let searchBox = $('#search-contacts');

                // Set the search textbox functionality in sidebar
                if (searchBox.length > 0) {
                    searchBox.on('keyup', function () {
                        dataTable[selector].search(this.value).draw();
                    });
                }

                $('a[data-action="reload"]').on('click', function () {
                    dataTable[selector].ajax.reload();
                });
            });
        },
    }
}();

$(document).ready(function () {
    Page.init();
});
