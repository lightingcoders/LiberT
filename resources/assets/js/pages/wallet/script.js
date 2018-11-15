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
