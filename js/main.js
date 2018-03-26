function Init (params) {
        // getPost(params);
        postInit(params);
}


function getHigh2(data) {
    $('#content2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Status of orders for the current year'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Orders',
            colorByPoint: true,
            data: [{
                name: 'Not paid',
                y: data['data_not_paid']/(data['data']/100)
            }, {
                name: 'Paid',
                y: data['data_paid']/(data['data']/100),
                sliced: true,
                selected: true
            }, {
                name: 'Shipping',
                y: data['data_shipping']/(data['data']/100)
            }, {
                name: 'Delivered',
                y: data['data_delivered']/(data['data']/100)
            }, {
                name: 'Cancelled',
                y: data['data_cancelled']/(data['data']/100)
            }, {
                name: 'Undefined',
                y: data['data_indefined']/(data['data']/100)
            }]
        }]
    });
}
function getHigh(data) {
    $('#content').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Statistics of orders by years'
        },
        subtitle: {
            text: 'All orders in UDK since 01.01.2018'
        },
        xAxis: {
            categories: data['category'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Amount'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:1f} зак.</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Not paid',
            data: data['data_not_paid']
        }, {
            name: 'Paid',
            data: data['data_paid']
        }, {
            name: 'Shipping',
            data: data['data_shipping']
        }, {
            name: 'Delivered',
            data: data['data_delivered']
        },  {
            name: 'Cancelled',
            data: data['data_cancelled']
        },  {
            name: 'Undefined',
            data: data['data_indefined']
        }, {
            name: 'All',
            data: data['data']
        }
        ]
    });
}

function postInit(params) {

    params.highcharts ='column';
    $.post(
        '/../analytics/core/request.php',
        params,
        function (data) {
            data = JSON.parse(data);
            if(data['data']) {
                getHigh(data);
                getHigh2(data);
            } else {
                $('#content').empty();
                $('#content').html('Что то пошло не так');
            }
        }
    )
}

function getPost(params) {
    $('#submit').on('click', function (event) {
        event.preventDefault();
        params.name = $('#inputEmail3').val();
        params.password = $('#inputPassword3').val();
        params.test = 'test';
        $.post(
            '/../analytics/core/request.php',
            params,
            function (data) {
                var data = JSON.parse(data);
                if(data['name']) {
                    $('#content').empty().html(data['name']);
                } else {
                    $('#content').empty();
                    $('#content').html('Error information');
                }
            }
        )
    });

}