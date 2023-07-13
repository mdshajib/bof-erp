function monthlyBarChart(){
    var options = {
        series: [{
            name: 'PRODUCT A',
            data: [44, 55, 41, 67, 22, 43, 66, 66,77, 87, 99, 76]
        }, {
            name: 'PRODUCT B',
            data: [44, 55, 41, 67, 22, 43, 66, 66,77, 87, 99, 76]
        }, {
            name: 'PRODUCT C',
            data: [44, 55, 41, 67, 22, 43, 66, 66,77, 87, 99, 76]
        }, {
            name: 'PRODUCT D',
            data: [44, 55, 41, 67, 22, 43, 66, 66,77, 87, 99, 76]
        }],
        title: {
            text: 'This Year Sales'
        },
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        responsive: [{
            // breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 10,
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: '13px',
                            fontWeight: 900
                        }
                    }
                }
            },
        },
        stroke: {
            width: 0,
            colors: ['red']
        },
        tooltip: {
            showOnMarkerHover: true,
            intersect: false,
            shared: true,
        },
        xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            title: {
                text: "Month"
            }
        },
        legend: {
            position: 'right',
            offsetY: 40
        },
        fill: {
            opacity: 1
        },
        states: {
            hover: {
                filter: {
                    type: 'none'
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#monthly_sales"), options);
    chart.render();
}

function initCounterNumber()
{
    var counter = document.querySelectorAll('.counter-value');
    var speed = 250; // The lower the slower

    counter.forEach(function (counter_value) {
    function updateCount() {
        var target = +counter_value.getAttribute('data-target');
        var count = +counter_value.innerText;
        var inc = target / speed;

        if (inc < 1) {
        inc = 1;
        } // Check if target is reached


        if (count < target) {
        // Add inc to count and output in counter_value
        counter_value.innerText = (count + inc).toFixed(0); // Call function every ms

        setTimeout(updateCount, 1);
        } else {
        counter_value.innerText = target;
        }
    }

    updateCount();
    });
}

