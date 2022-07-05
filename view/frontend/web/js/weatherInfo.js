define(
    [
        'ko',
        'jquery',
        'uiComponent',
    ],
    function (ko, $, Component ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Meteomatics_Core/weatherInfo'
            },
            data: ko.observable([]),
            isVisible: ko.observable(false),
            /** @inheritdoc */
            initialize: function () {
                this._super();
                let $this = this
                $.ajax({
                    url: '/Meteomatics/WeatherInfo/index',
                    dataType: 'json',
                    success: function (result) {
                        $this.data(result) ;
                        $this.isVisible(true) ;
                    },
                    error: function () {
                        $this.isVisible(false);
                    }
                });

            }
        });
    }
);
