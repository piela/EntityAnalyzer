/*
 * plugin lazy loading
 * do przenoiesienia do bowera
 */


(function ($) {





    $.fn.lazyLoader = function (options) {
        if ($.fn.lazyLoader.methods[options]) {
            return $.fn.lazyLoader.methods[ options ].apply($.fn.lazyLoader.methods, (Array.prototype.slice.call(arguments, 1)));
        } else if (typeof options === 'object' || !options) {
            return $.fn.lazyLoader.methods['init'].apply($.fn.lazyLoader.methods, arguments);
        } else {
            $.error('Method ' + options + ' does not exist on jQuery.lazyLoaded');
        }
    };

    $.fn.lazyLoader.methods = {
        actualRequest: null,
        options: {},
        initialized: false,
        init: function (options) {

            var that = this;
            window.addEventListener('popstate', function (event) {

                console.debug("historyp pop");
                console.debug(event);
                var state = event.state;
                if (state)
                {
                    that.options.url = window.location.href;
                    that.options.container = "#content";
                    that.options.element = $('.body');
                    that.options.done = function (loader, request, status, extra) {
                    }
                    that.request();

                } else
                {
                    console.debug("full relaod to first step");
                    location.href = window.location.href;
                }
            });
        },
        load: function (options)
        {
            if (!this.initialized)
            {
                this.init(options);
                this.initialized = true;
            }

            var defaults = {
                "element": null,
                "url": null,
                "container": null,
                "done": function (loader, url, request, status, extra) {
                },
                "complete": function (loader, url, request, status, extra) {
                },
                "error": function (loader, url, jqXHR, textStatus, errorThrown) {
                },
                "dataType": "html",
                "params": {
                    "method": 'GET',
                    "data": []
                }
            }




            this.options = $.extend({}, defaults, options);

            if (!this.options.element)
                throw "option \"element\" not set";
            if (!this.options.url)
                throw "option \"url\" not set";
            if (!this.options.container)
                throw "option \"container\" not set";

            if (this.actualRequest)
            {
                this.actualRequest.abort();
            }

            this.request();

        },
        request: function ()
        {

            var that = this;


            if (this.options.element.prop("tagName") == "FORM")
            {

                this.options.params.method = this.options.element.attr('method');
                this.options.params.data = $.extend([], this.options.params.data, this.options.element.serializeArray());
            }



            var ajaxParams = $.extend({url: this.options.url, dataType: this.options.dataType}, this.options.params);
            this.actualRequest = $.ajax(ajaxParams).complete(function (request, status, extra)
            {


                that.options.complete(that, this.url, request, status, extra)
            }).done(function (data, textStatus, request) {


                if (that.options.dataType == "html") {

                    that.render(data);
                }

                that.options.done(that, this.url, data, textStatus, request);

            }).error(function (jqXHR, textStatus, errorThrown) {

                that.options.error(that, this.url, jqXHR, textStatus, errorThrown);

            })



        },
        render: function (data)
        {

            $(this.options.container).html(data);
        }

    }

})(jQuery);