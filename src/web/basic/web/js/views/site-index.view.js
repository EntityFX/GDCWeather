$(function() {
    "use strict";
    Chart.defaults.global.responsive = true;
    Chart.defaults.global.maintainAspectRatio = false;
    var temperatureCanvas = $("#temperature-chart").get(0).getContext("2d");
    var pressureCanvas = $("#pressure-chart").get(0).getContext("2d");

    $.getJSON("/chart-data", function (data) {
        var temperatureChartSettings = {
            'labels': [],
            'datasets': [
                {
                    label: "Temperature",
                    fillColor: "rgba(110,220,220,0.2)",
                    strokeColor: "rgba(110,220,220,1)",
                    pointColor: "rgba(110,220,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: []
                }
            ]
        };

        var pressureChartSettings = {
            'labels': [],
            'datasets': [
                {
                    label: "Pressure",
                    fillColor: "rgba(110,110,220,0.2)",
                    strokeColor: "rgba(110,110,220,1)",
                    pointColor: "rgba(110,110,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(110,110,220,1)",
                    data: []
                }
            ]
        };


        data.forEach(
            function (element, index, array) {
                temperatureChartSettings.labels.push(element.dateTime);
                pressureChartSettings.labels.push(element.dateTime);
                temperatureChartSettings.datasets[0].data.push(element.temperature);
                pressureChartSettings.datasets[0].data.push(element.mmHg);
            }
        );

        new Chart(temperatureCanvas).Line(temperatureChartSettings, {
            'pointHitDetectionRadius': 5
        });
        new Chart(pressureCanvas).Line(pressureChartSettings, {
            'pointHitDetectionRadius': 5
        });
    });

});