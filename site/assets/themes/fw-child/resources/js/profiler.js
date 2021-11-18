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


    },

    get_sidebar: function(fn_options) {

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

      // options

			var defaults = {
				url: '',
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

			if (typeof settings.before == 'function') {
				settings.before()
			}

			$('.app-sidebar-content').fadeOut(125, function() {

				$.ajax({
					url: '/site/assets/themes/fw-child/template/' + settings.url,
					success: function(data) {

						$('.app-sidebar-content').html(data).fadeIn(500)

						if (typeof settings.success == 'function') {
	            settings.success(data)
	          }
					},
					complete: function() {

	          $('body').removeClass('spinner-on')

	          if (typeof settings.complete == 'function') {
	            settings.complete()
	          }
	        }
				})

			})

    },

    get_filter: function(fn_options) {

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

      // options

			var defaults = {
				url: ''
			}

			if (typeof fn_options == 'string') {
				defaults.url = fn_options
				fn_options = {}
			}

      var settings = $.extend(true, defaults, fn_options)

			$.ajax({
				url: '/site/assets/themes/fw-child/template/' + settings.url,
				success: function(data) {
					$('.app-filter-content').html(data)

					if (typeof settings.success == 'function') {
            settings.success()
          }
				},
				complete: function() {

          $('body').removeClass('spinner-on')

          if (typeof settings.complete == 'function') {
            settings.complete()
          }
        }
			})

    },

		_center_map: function(fn_options) {

			// centers the map on a point with an X offset of half of the width of the sidebar

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

			var settings = $.extend(true, {
				map: null,
				coords: [0, 0],
				offset: 0
			}, fn_options)

			var center = settings.map.project(settings.coords)

      settings.map.panTo(settings.map.unproject(new L.point(center.x - (settings.offset / 2), center.y)))

		}

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
