$(function () {
    //Widgets count
    $('.count-to').countTo();

    //Sales count to
    $('.sales-count-to').countTo({
        formatter: function (value, options) {
            return '$' + value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, ' ').replace('.', ',');
        }
    });

    // Only initialize charts if containers exist
    if ($('#real_time_chart').length) {
        initRealTimeChart();
    } else {
        console.warn('Chart container #real_time_chart not found');
    }
    
    if ($('#donut_chart').length) {
        initDonutChart();
    } else {
        console.warn('Chart container #donut_chart not found');
    }
    
    initSparkline();
});

var realtime = 'on';
function initRealTimeChart() {
    var chartContainer = $('#real_time_chart');
    
    // Check if container exists and has dimensions
    if (!chartContainer.length) {
        console.warn('Chart container #real_time_chart not found');
        return;
    }
    
    // Ensure container has proper dimensions
    if (chartContainer.width() === 0 || chartContainer.height() === 0) {
        console.warn('Chart container has no dimensions. Setting defaults...');
        chartContainer.css({
            'width': '100%',
            'height': '300px',
            'display': 'block'
        });
    }
    
    // Wait if still no width
    if (chartContainer.width() === 0) {
        setTimeout(initRealTimeChart, 300);
        return;
    }
    
    try {
        //Real time ==========================================================================================
        var plot = $.plot('#real_time_chart', [getRandomData()], {
            series: {
                shadowSize: 0,
                color: 'rgb(0, 188, 212)'
            },
            grid: {
                borderColor: '#f3f3f3',
                borderWidth: 1,
                tickColor: '#f3f3f3'
            },
            lines: {
                fill: true
            },
            yaxis: {
                min: 0,
                max: 100
            },
            xaxis: {
                min: 0,
                max: 100
            }
        });

        function updateRealTime() {
            plot.setData([getRandomData()]);
            plot.draw();

            var timeout;
            if (realtime === 'on') {
                timeout = setTimeout(updateRealTime, 320);
            } else {
                clearTimeout(timeout);
            }
        }

        updateRealTime();

        $('#realtime').on('change', function () {
            realtime = this.checked ? 'on' : 'off';
            updateRealTime();
        });
        //====================================================================================================
    } catch (e) {
        console.error('Flot chart initialization error:', e);
    }
}

function initSparkline() {
    $(".sparkline").each(function () {
        var $this = $(this);
        $this.sparkline('html', $this.data());
    });
}

function initDonutChart() {
    var chartContainer = document.getElementById('donut_chart');
    
    if (!chartContainer) {
        console.warn('Chart container #donut_chart not found');
        return;
    }
    
    try {
        Morris.Donut({
            element: 'donut_chart',
            data: [{
                label: 'Chrome',
                value: 37
            }, {
                label: 'Firefox',
                value: 30
            }, {
                label: 'Safari',
                value: 18
            }, {
                label: 'Opera',
                value: 12
            },
            {
                label: 'Other',
                value: 3
            }],
            colors: ['rgb(233, 30, 99)', 'rgb(0, 188, 212)', 'rgb(255, 152, 0)', 'rgb(0, 150, 136)', 'rgb(96, 125, 139)'],
            formatter: function (y) {
                return y + '%'
            }
        });
    } catch (e) {
        console.error('Morris chart initialization error:', e);
    }
}

var data = [], totalPoints = 110;
function getRandomData() {
    if (data.length > 0) data = data.slice(1);

    while (data.length < totalPoints) {
        var prev = data.length > 0 ? data[data.length - 1] : 50, y = prev + Math.random() * 10 - 5;
        if (y < 0) { y = 0; } else if (y > 100) { y = 100; }

        data.push(y);
    }

    var res = [];
    for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]]);
    }

    return res;
}