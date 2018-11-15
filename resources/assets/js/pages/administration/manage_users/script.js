window.Page = function () {
    let dataTable = {};

    return {
        init: function () {
            this.initDataTable();
        },

        initDataTable: function () {
            $.each(window._tableData, function (index, value) {
                let selector = value['selector'],
                    options  = value['options'];

                dataTable[selector] = $(selector).DataTable(options);

                $('a[data-action="reload"]').on('click', function () {
                    dataTable[selector].ajax.reload();
                });
            });
        },

        reloadDataTable: function (id) {
            dataTable[id].ajax.reload();
        },
    }
}();

$(document).ready(function () {
    Page.init();
});
