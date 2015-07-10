var SiteIndexPage = (function () {
    function SiteIndexPage(pointsCount, startDatetime, period) {
        this._pointsCount = pointsCount;
        this._startDatetime = startDatetime;
        this._period = period;

        this._temperatureChartSettings = {
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

        this._pressureChartSettings = {
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

        Chart.defaults.global.responsive = true;
        Chart.defaults.global.maintainAspectRatio = false;

        this._temperatureCanvas = $("#temperature-chart").get(0).getContext("2d");
        this._pressureCanvas = $("#pressure-chart").get(0).getContext("2d");
    }

    SiteIndexPage.prototype.init = function () {
        this.updateChartData();
    };

    SiteIndexPage.prototype.updateChartData = function () {
        var _this = this;
        $.getJSON("/chart-data",
            {
                'pointsCount': _this._pointsCount,
                'period': _this._period,
                'startDateTime': _this._startDatetime,
            },
            function (data) {
                _this.chartDataHandler(_this, data);
            });
    };

    SiteIndexPage.prototype.chartDataHandler = function (context, data) {
        data.forEach(
            function (element, index, array) {
                context._temperatureChartSettings.labels.push(element.dateTime);
                context._pressureChartSettings.labels.push(element.dateTime);
                context._temperatureChartSettings.datasets[0].data.push(element.temperature);
                context._pressureChartSettings.datasets[0].data.push(element.mmHg);
            }
        );

        new Chart(context._temperatureCanvas).Line(context._temperatureChartSettings, {
            'pointHitDetectionRadius': 5
        });
        new Chart(context._pressureCanvas).Line(context._pressureChartSettings, {
            'pointHitDetectionRadius': 5
        });
    };

    return SiteIndexPage;
})();