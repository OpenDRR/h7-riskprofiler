// scenario profiler
// v1.0

(function ($) {

  // custom select class

  function scenario_profiler(item, options) {

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

  scenario_profiler.prototype = {

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
        console.log('scenarios', 'initializing')
      }

			//
			// MAP
			//

	    var map = L.map('map').setView([55,-105], 4);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map)

			//
			// SIDEBAR
			//

			$.ajax({
				url: admin_ajax_data.url,
				success: function(data) {
					console.log('hey')
				}
			})

			//
			// ACTIONS
			//

			var marker1 = L.marker([50.2, -85])
				.on('click', function(e) {
					plugin_instance.select_item(1)
				})
				.addTo(map)

			var marker2 = L.marker([57, -94])
				.on('click', function(e) {
					plugin_instance.select_item(2)
				})
				.addTo(map)

			//
			// DUMMY CLICKS
			//

			$('.sidebar-item').click(function(e) {
				console.log($(this).attr('data-id'))
				plugin_instance.select_item($(this).attr('data-id'))
			})

    },

    select_item: function(fn_options) {

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

      // options

			var defaults = {
				item_id: 1
			}

			if (typeof fn_options == 'string') {
				defaults.item_id = fn_options
				fn_options = {}
			}

      var settings = $.extend(true, defaults, fn_options)

			console.log('select ' + settings.item_id)

			$('.sidebar-item').removeClass('selected')
			$('.sidebar-item[data-id="' + settings.item_id + '"]').addClass('selected')

    },

		//
    // _eval: function(fn_code) {
		//
    //   return Function('return ' + fn_code)();
		//
    // }

  }

  // jQuery plugin interface

  $.fn.scenario_profiler = function (opt) {
    var args = Array.prototype.slice.call(arguments, 1);

    return this.each(function () {

      var item = $(this);
      var instance = item.data('scenario_profiler');

      if (!instance) {

        // create plugin instance if not created
        item.data('scenario_profiler', new scenario_profiler(this, opt));

      } else {

        // otherwise check arguments for method call
        if (typeof opt === 'string') {
          instance[opt].apply(instance, args);
        }

      }
    });
  }

}(jQuery));
