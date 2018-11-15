window.Page = function () {
    let dataTable = {}, tradesChart;

    return {
        init: function () {
            this.initDataTable();
            this.initTradesChart();
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

                let card = $(selector).closest('.card');

                card.on('click', '[data-action="reload"]', function (e) {
                    dataTable[selector].ajax.reload();
                });
            });
        },

        initTradesChart: function () {
            let config = {
                type: 'line',

                // Chart Options
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetStrokeWidth: 3,
                    pointDotStrokeWidth: 4,
                    tooltipFillColor: "rgba(0,0,0,0.8)",
                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                    hover: {
                        mode: 'label'
                    },
                    scales: {
                        xAxes: [{
                            display: false,
                        }],
                        yAxes: [{
                            display: false,
                            ticks: {
                                min: 0,
                                max: 70
                            },
                        }]
                    },
                    title: {
                        display: false,
                        fontColor: "#FFF",
                        fullWidth: false,
                        fontSize: 40,
                        text: '82%'
                    }
                },

                data: {
                    labels: window.tradesChart.month,
                    datasets: [{
                        label: "Total",
                        data: window.tradesChart.total,
                        backgroundColor: 'rgba(30,196,129,0.12)',
                        borderColor: "#1EC481",
                        borderWidth: 3,
                        strokeColor: "#1EC481",
                        capBezierPoints: true,
                        pointColor: "#fff",
                        pointBorderColor: "#1EC481",
                        pointBackgroundColor: "#FFF",
                        pointBorderWidth: 3,
                        pointRadius: 5,
                        pointHoverBackgroundColor: "#FFF",
                        pointHoverBorderColor: "#1EC481",
                        pointHoverRadius: 7,
                    }]
                }
            };

            let context = document.getElementById("trades-chart")
                                  .getContext("2d");

            tradesChart = new Chart(context, config);
        }
    }
}();

$(document).ready(function () {
    Page.init();
});
