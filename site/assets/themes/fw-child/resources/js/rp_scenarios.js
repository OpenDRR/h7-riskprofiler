// scenario profiler
// v1.0

(function ($) {

  // custom select class

  function rp_scenarios(item, options) {

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

  rp_scenarios.prototype = {

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
			// FILTER
			//

			$(document).profiler('get_filter', 'scenarios/filter.php')

			//
			// SIDEBAR
			//

			$(document).profiler('get_sidebar', 'scenarios/items.php')

			//
			// ACTIONS
			//

			// DUMMY MARKERS

			var marker1 = L.marker([50.2, -85])
				.on('click', function(e) {
					plugin_instance.item_select('1')
				})
				.addTo(map)

			var marker2 = L.marker([57, -94])
				.on('click', function(e) {
					plugin_instance.item_select('2')
				})
				.addTo(map)

			//
			// DUMMY CLICKS
			//

			$('body').on('click', '.sidebar-item .sidebar-button', function(e) {
				plugin_instance.item_detail($(this).closest('.sidebar-item').attr('data-id'))
			})

			$('body').on('click', '.sidebar-item', function(e) {
				plugin_instance.item_select($(this).attr('data-id'))
			})

			$('body').on('click', '.app-head-back', function(e) {

				$(document).profiler('get_sidebar', {
					url: 'scenarios/items.php',
					before: function() {

						$('.app-sidebar').attr('data-width', '')
						$('.app-head').attr('data-mode', '')

					},
					success: function() {

					}
				})

			})

    },

    item_select: function(fn_options) {

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

			console.log('scenarios', 'select', settings.item_id)

			$('.sidebar-item').removeClass('selected')
			$('.sidebar-item[data-id="' + settings.item_id + '"]').addClass('selected')

    },

    item_detail: function(fn_options) {

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

			console.log('scenarios', 'detail', settings.item_id)

			var detail_html

			$(document).profiler('get_sidebar', {
				url: 'scenarios/detail.php',
				data: {
					id: settings.item_id
				},
				before: function() {

					$('.app-sidebar').attr('data-width', 'half')
					$('.app-head').attr('data-mode', 'scenario-detail')

				},
				success: function(data) {

					console.log('scenarios', 'detail', 'success')

				},
				complete: function() {

					console.log('scenarios', 'detail', 'done')

					$('.app-sidebar').find('.accordion').on('shown.bs.collapse', function () {

						$('.app-sidebar').find('.collapse.show').prev().addClass('open')

					}).on('hide.bs.collapse', function () {

						$('.app-sidebar').find('.collapse').prev().removeClass('open')

					})//.collapse()

				}
			})


    },

		//
    // _eval: function(fn_code) {
		//
    //   return Function('return ' + fn_code)();
		//
    // }

  }

  // jQuery plugin interface

  $.fn.rp_scenarios = function (opt) {
    var args = Array.prototype.slice.call(arguments, 1);

    return this.each(function () {

      var item = $(this);
      var instance = item.data('rp_scenarios');

      if (!instance) {

        // create plugin instance if not created
        item.data('rp_scenarios', new rp_scenarios(this, opt));

      } else {

        // otherwise check arguments for method call
        if (typeof opt === 'string') {
          instance[opt].apply(instance, args);
        }

      }
    });
  }

}(jQuery));
