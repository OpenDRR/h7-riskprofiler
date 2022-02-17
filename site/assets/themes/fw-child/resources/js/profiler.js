// scenario profiler
// v1.0

(function ($) {

  // custom select class

  function profiler(item, options) {

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

  profiler.prototype = {

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
        console.log('profiler', 'initializing')
      }

			$('<div id="spinner-overlay">').insertBefore('#spinner')
			$('<div id="spinner-progress">').insertAfter('#spinner')

    },

    get_sidebar: function(fn_options) {

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

      // options

			var defaults = {
				url: '',
				method: 'GET',
				data: null,
				before: null,
				success: null,
				complete: null
			}

			if (typeof fn_options == 'string') {
				defaults.url = fn_options
				fn_options = {}
			}

      var settings = $.extend(true, defaults, fn_options)

			$('body').addClass('spinner-on')
			$('#spinner-progress').text('Initializing')

			if (typeof settings.before == 'function') {
				settings.before()
			}

			$('.app-sidebar-content').fadeOut(125, function() {

				$.ajax({
					url: '/site/assets/themes/fw-child/template/' + settings.url,
					method: settings.method,
					data: settings.data,
					success: function(data) {

						$('.app-sidebar-content').html(data).fadeIn(500)

						if (typeof settings.success == 'function') {
	            settings.success(data)
	          }
					},
					complete: function() {

	          if (typeof settings.complete == 'function') {
	            settings.complete()
	          }
	        }
				})

			})

    },

    get_controls: function(fn_options) {

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

      // options

			var defaults = {
				dir: ''
			}

			if (typeof fn_options == 'string') {
				defaults.dir = fn_options
				fn_options = {}
			}

      var settings = $.extend(true, defaults, fn_options)

			// bar

			$.ajax({
				url: '/site/assets/themes/fw-child/template/' + settings.dir + '/control-bar.php',
				success: function(bar_data) {
					$('.app-controls-content').html(bar_data)

					// filter

					$.ajax({
						url: '/site/assets/themes/fw-child/template/' + settings.dir + '/control-filter.php',
						success: function(filter_data) {
							$('.app-sidebar-filter').html(filter_data)

							// sort

							$.ajax({
								url: '/site/assets/themes/fw-child/template/' + settings.dir + '/control-sort.php',
								success: function(sort_data) {
									$('.app-sidebar-sort').html(sort_data)

									if (typeof settings.success == 'function') {
				            settings.success()
				          }

				          if (typeof settings.complete == 'function') {
				            settings.complete()
				          }
								},
								complete: function() {
				          $('body').removeClass('spinner-on')
									$('#spinner-progress').text('')
								}
							})

						}
					})

				},
				complete: function() {

        }
			})

    },

		center_map: function(fn_options) {

			// centers the map on a point with an X offset of half of the width of the sidebar

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

			var settings = $.extend(true, {
				map: null,
				coords: [0, 0],
				offset: 0,
				zoom: 5
			}, fn_options)

			var center = settings.map.project(settings.coords)

			center = settings.map.unproject(new L.point(center.x - (settings.offset / 2), center.y))

			console.log('center', settings.coords, center)

      settings.map.setView([center.lat, center.lng], settings.zoom)

		},

		//
    // _eval: function(fn_code) {
		//
    //   return Function('return ' + fn_code)();
		//
    // }

  }

  // jQuery plugin interface

  $.fn.profiler = function (opt) {
    var args = Array.prototype.slice.call(arguments, 1);

    return this.each(function () {

      var item = $(this);
      var instance = item.data('profiler');

      if (!instance) {

        // create plugin instance if not created
        item.data('profiler', new profiler(this, opt));

      } else {

        // otherwise check arguments for method call
        if (typeof opt === 'string') {
          instance[opt].apply(instance, args);
        }

      }
    });
  }

}(jQuery));
