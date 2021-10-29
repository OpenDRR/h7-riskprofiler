// risk profiler
// v1.0

(function ($) {

  // custom select class

  function risk_profiler(item, options) {

    // options

    var defaults = {
      chart_dir: child_theme_dir + 'resources/js/charts/',
      chart_options: null,
      charts: {},
      map_dir: child_theme_dir + 'resources/js/maps/',
      generated_ID: 1,
      debug: false
    };

    this.options = $.extend(true, defaults, options);

    this.item = $(item);
    this.init();
  }

  risk_profiler.prototype = {

    // init

    init: function () {

      var plugin_instance = this;
      var plugin_item = this.item;
      var plugin_settings = plugin_instance.options;
      var plugin_elements = plugin_settings.elements;

      //
      // INITIALIZE
      //

      if (plugin_settings.debug == true) {
        console.log('risks', 'initializing')
      }

			//
			// MAP
			//

	    var map = L.map('map').setView([51.505, -0.09], 13);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

			L.marker([51.5, -0.09]).addTo(map)
			    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
			    .openPopup();


			//
			// DUMMY CLICKS
			//

    },

    select_item: function(fn_options) {

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

      // options

      var settings = $.extend(true, {
        parent: 'body'
      }, fn_options)

      // console.log('finding objects', settings.parent)



    },
		//
		//
    // _eval: function(fn_code) {
		//
    //   return Function('return ' + fn_code)();
		//
    // }

  }

  // jQuery plugin interface

  $.fn.risk_profiler = function (opt) {
    var args = Array.prototype.slice.call(arguments, 1);

    return this.each(function () {

      var item = $(this);
      var instance = item.data('risk_profiler');

      if (!instance) {

        // create plugin instance if not created
        item.data('risk_profiler', new risk_profiler(this, opt));

      } else {

        // otherwise check arguments for method call
        if (typeof opt === 'string') {
          instance[opt].apply(instance, args);
        }

      }
    });
  }

}(jQuery));
