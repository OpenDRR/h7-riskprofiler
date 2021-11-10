// risk profiler
// v1.0

(function ($) {

  // custom select class

  function rp_risks(item, options) {

    // options

    var defaults = {
      chart_dir: child_theme_dir + 'resources/js/charts/',
      chart_options: null,
      charts: {},
      map_dir: child_theme_dir + 'resources/js/maps/',
      generated_ID: 1,
			geojson: null,
			regions: {},
			selected_polygon: null,
      debug: false
    };

    this.options = $.extend(true, defaults, options);

    this.item = $(item);
    this.init();
  }

  rp_risks.prototype = {

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

	    var map = L.map('map').setView([55,-105], 4);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map)

			// GEOJSON

			plugin_settings.geojson = [{
		    "type": "Feature",
		    "properties": {
					id: 1,
					city: 'Ottawa-Gatineau'
				},
		    "geometry": {
	        "type": "Polygon",
	        "coordinates": [[
            [-105, 55],
				    [-107, 55.5],
				    [-108, 57],
				    [-110, 55],
				    [-108, 54]
	        ]]
		    }
			}, {
		    "type": "Feature",
		    "properties": {
					id: 2,
					city: 'Vancouver'
				},
		    "geometry": {
	        "type": "Polygon",
	        "coordinates": [[
            [-120, 50],
				    [-122, 53],
				    [-125, 52]
	        ]]
		    }
			}]

			plugin_settings.choropleth = L.geoJSON(plugin_settings.geojson, {
		    style: {
					color: '#8b0707',
					fillColor: '#8b0707'
				},
				onEachFeature: function (feature, layer) {

					if (typeof feature !== 'undefined') {

						layer
							.bindPopup(plugin_instance.create_popup(feature.properties.id))
							.on('mouseover', function () {

	              this.setStyle({
									'color': '#d90429',
									'fillColor': '#d90429'
								})

								$('.sidebar-item').removeClass('hover')

								$('.sidebar-item[data-id="' + feature.properties.id + '"]').addClass('hover')

	            })
							.on('mouseout', function () {

								$('.sidebar-item').removeClass('hover')

								if (plugin_settings.selected_polygon != feature.properties.id) {

									this.setStyle({
										'color': '#8b0707',
										'fillColor': '#8b0707'
									})

								}

	            })
							.on('click', function() {

								plugin_instance.item_select({
									item_id: feature.properties.id,
									polygon: this
								})

							})

					}

				}

			}).addTo(map)

			// EVENTS

			map.on('popupclose', function(e) {
				plugin_settings.choropleth.resetStyle()
			});

			//
			// FILTER
			//

			$(document).profiler('get_filter', 'risks/filter.php')

			//
			// SIDEBAR
			//

			$(document).profiler('get_sidebar', 'risks/items.php')

			//
			// DUMMY CLICKS
			//

			$('body').on('click', '.risk-detail-link', function() {
				map.closePopup()

				plugin_instance.item_detail($(this).attr('data-id'))
			})

			$('body').on('click', '.app-head-back', function(e) {

				$(document).profiler('get_sidebar', {
					url: 'risks/items.php',
					before: function() {

						$('.app-sidebar').attr('data-width', '')
						$('.app-head').attr('data-mode', '')

					},
					success: function() {

					}
				})

			})

    },

		create_popup: function(fn_options) {

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

      // options

			var defaults = {
				item_id: 1
			}

			if (typeof fn_options == 'number') {
				defaults.item_id = fn_options
				fn_options = {}
			}

      var settings = $.extend(true, defaults, fn_options)

			var popup_data = {
				1: {
					city: 'Ottawa-Gatineau',
					province: 'Ontario',
					rank: 1
				},
				2: {
					city: 'Vancouver',
					province: 'British Columbia',
					rank: 2
				},
			}

			var this_popup = popup_data[settings.item_id]

			var popup_markup = '<div>'

			popup_markup += '<h4>' + this_popup.city + '</h4>'

			popup_markup += '<div>' + this_popup.rank + '</div>'

			popup_markup += '<div>'

			popup_markup += '<span class="risk-detail-link" data-id="' + settings.item_id + '">View Details</span>'

			popup_markup += '</div>'

			popup_markup += '</div>'

			return popup_markup

		},

    item_select: function(fn_options) {

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

      // options

			var defaults = {
				item_id: null
			}

			if (typeof fn_options == 'number') {
				defaults.item_id = fn_options
				fn_options = {}
			}

      var settings = $.extend(true, defaults, fn_options)

			console.log('risks', 'select', settings.item_id)

			plugin_settings.selected_polygon = settings.item_id

			plugin_settings.choropleth.resetStyle()

			settings.polygon.setStyle({
				color: '#d90429',
				fillColor: '#d90429'
			})

			$('.sidebar-item').removeClass('selected')

			if (settings.item_id != null) {

				$('.sidebar-item[data-id="' + settings.item_id + '"]').addClass('selected')

			}



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

			console.log('risks', 'detail', settings.item_id)

			var detail_html

			$(document).profiler('get_sidebar', {
				url: 'risks/detail.php',
				data: {
					id: settings.item_id
				},
				before: function() {

					$('.app-sidebar').attr('data-width', 'half')
					$('.app-head').attr('data-mode', 'risk-detail')

				},
				success: function(data) {

					console.log('risks', 'detail', 'success')

				},
				complete: function() {

					console.log('risks', 'detail', 'done')

					$('.app-sidebar').find('.accordion').on('shown.bs.collapse', function () {

						$('.app-sidebar').find('.collapse.show').prev().addClass('open')

					}).on('hide.bs.collapse', function () {

						$('.app-sidebar').find('.collapse').prev().removeClass('open')

					})

				}
			})


    }

  }

  // jQuery plugin interface

  $.fn.rp_risks = function (opt) {
    var args = Array.prototype.slice.call(arguments, 1);

    return this.each(function () {

      var item = $(this);
      var instance = item.data('rp_risks');

      if (!instance) {

        // create plugin instance if not created
        item.data('rp_risks', new rp_risks(this, opt));

      } else {

        // otherwise check arguments for method call
        if (typeof opt === 'string') {
          instance[opt].apply(instance, args);
        }

      }
    });
  }

}(jQuery));
