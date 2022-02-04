const geoapi_url = 'https://geo-api.stage.riskprofiler.ca'
const elastic_url = 'https://api.stage.riskprofiler.ca'

// var feature_index = "opendrr_dsra_sim9p0_cascadiainterfacebestfault_indicators_s",
var feature_index_prop = "sH_PGA",
		base_url = elastic_url + '/',
		featureLimit = 10000,
		markers = [],
		scroll_id = null;

// scenario profiler
// v1.0

(function ($) {

  // custom select class

  function rp_scenarios(item, options) {

    // options

    var defaults = {
			api: {
				base_URL: geoapi_url + '/collections/opendrr_dsra_',
				retrofit: 'b0', // or r1
				aggregation: 'csd', // or s
				agg_prop: 'csduid', // or Sauid
				featureProperties: '', // Limit fetched properties for performance
				limit: 10,
				lang: 'en_US',
				bbox: null,
				geojson_URL: null,
				data: [],
				features: []
			},
			elastic: {
				merc: null
			},
			map: {
				object: null,
				legend: null,
				offset: $('.app-sidebar').outerWidth(),
				geojson: null,
				panes: [],
				layers: {
					bbox: null,
					shake_grid: null,
					shake_choro: null,
					choro: null
				},
				markers: null,
				selected_marker: null,
				geojsonLayer: null,
				current_zoom: 4,
				last_zoom: -1,
				zoom_changed_agg: false,
			},
			breadcrumbs: {
				'init': [
					{
						text: 'Select a marker to retrieve data',
						class: 'tip'
					}
				],
				'select': [
					{
						text: 'Scenario',
						id: 'breadcrumb-scenario-name'
					}
				],
				'detail': [
					{
						text: 'Scenario Detail',
						id: 'breadcrumb-scenario-name'
					},
					{
						text: '',
						id: 'breadcrumb-scenario-indicator',
						class: 'tip'
					}
				],
			},
			current_view: 'init',
			scenario: {},
			indicator: {},
			legend: {
				max: 0
			},
			colors: {
				marker: '#9595a0',
				marker_hover: '#b6b6bf',
				marker_select: '#2b2c42',
			},
			logging: {
				feature_count: 0,
				update_count: 0
			},
      debug: false
    };

    this.options = $.extend(true, defaults, options);

    this.item = $(item);
    this.init();
  }

  rp_scenarios.prototype = {

    // init

    init: function () {

      var plugin_instance = this
      //var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      //var plugin_elements = plugin_settings.elements

      //
      // INITIALIZE
      //

      if (plugin_settings.debug == true) {
        console.log('initializing')
      }

			$('#spinner-progress').text('Initializing map')

			//
			// MAP
			// initialize the leaflet map, panes, etc.
			//

			// OBJECT

	    plugin_settings.map.object = L.map('map', {
				zoomControl: false
			}).setView([55,-105], plugin_settings.map.current_zoom)

			plugin_settings.map.object.on('fullscreenchange', function () {
				plugin_settings.map.object.invalidateSize()
			})

			// CONTROLS

			L.control.zoom({
				position: 'topright'
			}).addTo(plugin_settings.map.object);

			// PANES

			plugin_settings.map.panes.basemap = plugin_settings.map.object.createPane('basemap')
			plugin_settings.map.panes.basemap.style.zIndex = 399
			plugin_settings.map.panes.basemap.style.pointerEvents = 'none'

			// markers - for scenario markers and clusters
			plugin_settings.map.panes.markers = plugin_settings.map.object.createPane('markers')
			plugin_settings.map.panes.markers.style.zIndex = 600
			plugin_settings.map.panes.markers.style.pointerEvents = 'all'

			// bbox - for scenario bounding box
			plugin_settings.map.panes.bbox = plugin_settings.map.object.createPane('bbox')
			plugin_settings.map.panes.bbox.style.zIndex = 550
			plugin_settings.map.panes.bbox.style.pointerEvents = 'all'

			// data - for geojson layers
			plugin_settings.map.panes.data = plugin_settings.map.object.createPane('data')
			plugin_settings.map.panes.data.style.zIndex = 560
			plugin_settings.map.panes.data.style.pointerEvents = 'all'

			// shakemap - for shakemap data
			plugin_settings.map.panes.shakemap = plugin_settings.map.object.createPane('shakemap')
			plugin_settings.map.panes.shakemap.style.zIndex = 560
			// plugin_settings.map.panes.shakemap.style.pointerEvents = 'all'

			// epicenter - for selected scenario epicenter
			plugin_settings.map.panes.epicenter = plugin_settings.map.object.createPane('epicenter')
			plugin_settings.map.panes.epicenter.style.zIndex = 570
			plugin_settings.map.panes.epicenter.style.pointerEvents = 'none'
			plugin_settings.map.panes.epicenter.style.display = 'none'

			var pulsingIcon = L.icon.pulse({
				iconSize: [12, 12],
				fillColor: '#2b2c42',
				color: '#2b2c42',
				heartbeat: 2
			})

			plugin_settings.map.epicenter = L.marker([55,-105], {
				icon: pulsingIcon,
				pane: 'epicenter'
			}).addTo(plugin_settings.map.object)

			// LEGEND

			plugin_settings.map.legend = L.control( { position: 'bottomleft' } )

			plugin_settings.map.legend.onAdd = function () {

				var div = L.DomUtil.create('div', 'info legend'),
						grades = [].concat(plugin_settings.legend.grades).reverse(),
						prepend = plugin_settings.indicator.legend.prepend,
						append = plugin_settings.indicator.legend.append,
						aggregation = plugin_settings.indicator.aggregation

				switch (aggregation[plugin_settings.api.aggregation]['rounding']) {
					case -9 :
						append = 'billion ' + append
						break
					case -6 :
						append = 'million ' + append
						break
					case -3 :
						append = 'thousand ' + append
						break
				}

				legend_markup = '<h6>' + plugin_settings.indicator.label + '</h6>'

				// loop through our density intervals and generate a label with a colored square for each interval

				legend_markup += '<div class="items">'

				legend_markup += '<div class="legend-item" data-toggle="tooltip" data-placement="top" style="background-color: '
					+ plugin_instance._choro_color(grades[0]) + ';"'
					+ ' title="'
					+ prepend
					+ '0 – '
					+ prepend
					+ grades[0].toLocaleString(undefined, { maximumFractionDigits: aggregation[plugin_settings.api.aggregation]['decimals'] })
					+ ' '
					+ append
					+ '"></div>'

				for (var i = 0; i < grades.length; i++ ) {

					var row_markup = '<div class="legend-item" data-toggle="tooltip" data-placement="top" style="background-color: ' + plugin_instance._choro_color(grades[i] + 1) + ';"'
						+ ' title="'
						+ prepend
						+ grades[i].toLocaleString(undefined, { maximumFractionDigits: aggregation[plugin_settings.api.aggregation]['decimals'] })

					if (grades[i + 1]) {

						row_markup += ' – '
							+ prepend
							+ grades[i + 1].toLocaleString(undefined, { maximumFractionDigits: aggregation[plugin_settings.api.aggregation]['decimals'] })
							+ ' '
							+ append

					} else {

						row_markup += '+ ' + append

					}

					row_markup += '"></div>'

					legend_markup += row_markup

				}

				legend_markup	+= '</div>'

				// legend_markup = '<p class="mb-1"><i style="background:'
				// 	+ plugin_instance._choro_color(grades[0]) + '"></i> '
				// 	+ prepend
				// 	+ '0 – '
				// 	+ prepend
				// 	+ grades[0].toLocaleString(undefined, { maximumFractionDigits: aggregation[plugin_settings.api.aggregation]['decimals'] })
				// 	+ ' '
				// 	+ append
				// 	+ '</p>'

				// for (var i = 0; i < grades.length; i++ ) {
				//
				// 	var row_markup = '<p class="mb-1">'
				// 		+ '<i style="background-color:' + plugin_instance._choro_color(grades[i] + 1) + '"></i> '
				//
				// 	row_markup += prepend
				// 		+ grades[i].toLocaleString(undefined, { maximumFractionDigits: aggregation[plugin_settings.api.aggregation]['decimals'] })
				//
				// 	if (grades[i + 1]) {
				//
				// 		row_markup += ' – '
				// 			+ prepend
				// 			+ grades[i + 1].toLocaleString(undefined, { maximumFractionDigits: aggregation[plugin_settings.api.aggregation]['decimals'] })
				// 			+ ' '
				// 			+ append
				//
				// 	} else {
				//
				// 		row_markup += '+ ' + append
				//
				// 	}
				//
				// 	row_markup += '</p>'
				//
				// 	legend_markup += row_markup
				//
				// }

				div.innerHTML = legend_markup

				return div

			}

			// BASEMAP

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					pane: 'basemap',
			    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(plugin_settings.map.object)

			// CLUSTERS

			plugin_settings.map.clusters = L.markerClusterGroup({
				animateAddingMarkers: true,
				iconCreateFunction: function (cluster) {
					var markers = cluster.getAllChildMarkers();

					// console.log(markers)

					var n = 0

					for (var i = 0; i < markers.length; i++) {
						n += 1
					}

					return L.divIcon({ html: n, className: 'scenario-cluster', iconSize: L.point(40, 40) });
				},
				clusterPane: 'markers'
			})

			// layer for choropleth

			var selection

			plugin_settings.map.layers.choro = L.geoJSON([], {
				style: {
					fillColor: '#aaa',
					fillOpacity: 0.7,
					color: '#4b4d4d',
					weight: 0.4,
					opacity: 0.8
				},
				pane: 'data',
				onEachFeature: function(feature, layer) {

					var prop_key = plugin_settings.indicator.key + ((plugin_settings.indicator.retrofit !== false) ? '_' + plugin_settings.api.retrofit : '')

					plugin_settings.api.features[feature.id] = layer

					var rounded_color = feature.properties[prop_key] * Math.pow(10, plugin_settings.indicator.aggregation[plugin_settings.api.aggregation]['rounding'])

					layer.setStyle({
						fillColor: plugin_instance._choro_color(rounded_color)
					})

					layer.bindPopup(function(e) {

						return L.Util.template('<p>'
							+ plugin_settings.indicator.legend.prepend + ' '
							+ e.feature.properties[prop_key].toLocaleString(undefined, { maximumFractionDigits: plugin_settings.indicator.aggregation[plugin_settings.api.aggregation]['decimals'] }) + ' '
							+ plugin_settings.indicator.legend.append
							+ '</p>')

					}).on({

						click: function(e) {

							if ( selection ) {

								// reset style of previously selected feature
								selection.setStyle(plugin_instance._choro_style(selection.feature))

							}

							selection = e.target
							selection.setStyle(plugin_instance._choro_selected_style())

						},

						popupclose: function(e) {

							// reset the shape's style
							selection.setStyle(plugin_instance._choro_style(e.target.feature))

						}

					})

				}
			}).addTo(plugin_settings.map.object)

			//
			// FILTER
			//

			$(document).profiler('get_controls', 'scenarios')

			// $('.app-controls .control-toggle').click(function() {})

			// RETROFIT

			$('#retrofit-toggle').togglebox({
				off: '',
				on: ''
			})

			//
			// SIDEBAR
			//

			// GET SCENARIO LIST

			$(document).profiler('get_sidebar', {
				url: 'scenarios/items.php',
				success: function(data) {

					// GEOJSON

					var features = []

					$('body').find('.sidebar-item').each(function() {

						var feature_props = JSON.parse($(this).attr('data-scenario'))

						features.push({
							"type": "Feature",
							"properties": feature_props,
							"geometry": {
								"type": "Point",
								"coordinates": [parseFloat(feature_props.coords.lng), parseFloat(feature_props.coords.lat)]
							}
						})

					})

					plugin_settings.map.geojson = [{
						"type": "FeatureCollection",
						"features": features
					}]

					plugin_settings.map.markers = L.geoJSON(plugin_settings.map.geojson, {
						onEachFeature: function(feature, layer) {

							if (typeof feature !== 'undefined') {

								layer
									.on('mouseover', function(e) {

										if (plugin_settings.map.selected_marker != feature.properties.id) {

											this.setStyle({
												'color': plugin_settings.colors.marker_hover,
												'fillColor': plugin_settings.colors.marker_hover
											})

										}

									})
									.on('mouseout', function() {

										// if already selected, do nothing
										// if another layer is selected, reset this one

										$('.sidebar-item').removeClass('hover')

										if (plugin_settings.map.selected_marker != feature.properties.id) {

											this.setStyle({
												'color': plugin_settings.colors.marker,
												'fillColor': plugin_settings.colors.marker
											})

										}

									})
									.on('click', function(e) {

										plugin_instance.item_select({
											scenario: feature.properties,
											marker: this
										})

									})
							}

						},
						pointToLayer: function (feature, latlng) {

							// var marker = L.marker(latlng, { title: 'test' });

							var marker = L.circleMarker(latlng, {
								pane: 'markers',
								radius: 5,
								fillColor: plugin_settings.colors.marker,
								weight: 0,
								opacity: 1,
								fillOpacity: 1
							})

							plugin_settings.map.clusters.addLayer(marker)

							return marker

						}
					})

					plugin_settings.map.object.addLayer(plugin_settings.map.clusters)

				}
			})

			//
			// EVENTS
			//

			// adjust aggregation on zoom
			plugin_settings.map.object.on('zoomend dragend', function (e) {

				// console.log('zoom drag', plugin_settings.map.object.getZoom())

				if (plugin_settings.current_view == 'detail') {

					plugin_settings.map.current_zoom = e.target.getZoom()

					plugin_instance.prep_for_api()

					plugin_settings.map.last_zoom = plugin_settings.map.current_zoom

				}

			})

			//
			// ACTIONS
			//

			// click the 'explore' button in a sidebar item

			$('body').on('click', '.sidebar-item .sidebar-button', function(e) {
				plugin_instance.item_detail({
					scenario: plugin_settings.scenario
				})
			})

			// click an unselected sidebar item

			$('body').on('click', '.sidebar-item:not(.selected)', function(e) {

				var this_scenario = JSON.parse($(this).attr('data-scenario'))

				plugin_settings.map.markers.resetStyle().eachLayer(function(layer) {

					if (this_scenario.id == layer.feature.properties.id) {

						plugin_instance.item_select({
							scenario: this_scenario,
							marker: layer
						})

					}

				})
			})

			// DETAIL

			// select an indicator

			$('.app-sidebar').on('click', '.indicator-item', function() {

				if (!$(this).hasClass('selected')) {

					// close popup

					plugin_settings.map.object.closePopup()

					// switch retrofit off

					if ($('#retrofit .togglebox').attr('data-state') == 'on') {
						$('#retrofit .togglebox').trigger('click')
					}

					// set classes

					$('.app-sidebar').find('.indicator-item').removeClass('selected')
					$(this).addClass('selected')

					// update layer

					plugin_instance.set_indicator(JSON.parse($(this).attr('data-indicator')))

					plugin_instance.get_layer()

				}

			})


			// click the 'back' button

			$('body').on('click', '.app-head-back', function(e) {

				plugin_instance.do_breadcrumb('init')

				$(document).profiler('get_sidebar', {
					url: 'scenarios/items.php',
					before: function() {

						plugin_settings.current_view = 'init'

						plugin_settings.api.features = []

						plugin_settings.api.aggregation = 'csd'
						plugin_settings.api.agg_prop = 'csduid'
						plugin_settings.api.bbox = null

						// empty the data and shakemaps layer
						$('.leaflet-data-pane path').remove()
						$('.leaflet-shakemap-pane path').remove()

						// remove the legend
						plugin_settings.map.legend.remove()

						// reset the map view
						plugin_settings.map.object.setView([55,-105], 4)

						// close popups
						plugin_settings.map.object.closePopup()

						// hide epicenter
						plugin_settings.map.panes.epicenter.style.display = 'none'

						// show markers
						plugin_settings.map.panes.markers.style.display = ''

						// reset interface atts
						$('body').attr('data-sidebar-width', '')
						$('.app-head').attr('data-mode', '')

						// reset the last_zoom flag
						plugin_settings.map.last_zoom = -1

						// empty the current scenario object
						plugin_settings.scenario = {}

					},
					success: function() {


					}
				})

			})

			// click the 'retrofit' toggle

			$('#retrofit').click(function() {
				if (!$(this).hasClass('disabled')) {

					if (plugin_settings.api.retrofit == 'b0') {
						plugin_settings.api.retrofit = 'r1'
						// $(this).find('span').text('on')
					} else {
						plugin_settings.api.retrofit = 'b0'
						// $(this).find('span').text('off')
					}

					plugin_settings.map.object.closePopup()

					if (plugin_settings.current_view == 'detail') {
						plugin_instance.fetch_geoapi(null, false) // don't do legend
					}

				}
			})

    },

		set_scenario: function(fn_options) {

			var plugin_instance = this
			//var plugin_item = this.item
			var plugin_settings = plugin_instance.options
			//var plugin_elements = plugin_settings.elements

			var settings = $.extend(true, {}, fn_options)

		},

		set_indicator: function(indicator) {

			var plugin_instance = this
			//var plugin_item = this.item
			var plugin_settings = plugin_instance.options
			//var plugin_elements = plugin_settings.elements

			plugin_settings.indicator = indicator

			if (indicator.key == 'sh_PGA') {
				plugin_settings.api.limit = 1000
			}

			// console.log(indicator)

			$('#retrofit-toggle').togglebox('enable')

			if (indicator.retrofit == false) {
				$('#retrofit-toggle').togglebox('disable')
			}

		},

    item_select: function(fn_options) {

      var plugin_instance = this
      //var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      //var plugin_elements = plugin_settings.elements

      // options

			var defaults = {
				scenario: null,
				marker: null,
				event: null
			}

			if (typeof fn_options == 'string') {
				defaults.scenario = fn_options
				fn_options = {}
			}

      var settings = $.extend(true, defaults, fn_options)

			console.log('select', settings)

			// selected polygon = clicked ID or null
			plugin_settings.map.selected_marker = settings.scenario.id

			// reset choropleth
			plugin_settings.map.markers.resetStyle()

			// reset sidebar
			$('.sidebar-item').removeClass('selected')

			if (settings.scenario != null) {

				plugin_settings.scenario = settings.scenario

				// select the marker

				settings.marker.setStyle({
					color: plugin_settings.colors.marker_select,
					fillColor: plugin_settings.colors.marker_select
				})

				// center the map on the marker

				// $('body').profiler('center_map', {
				// 	map: plugin_settings.map.object,
				// 	coords: settings.marker._latlng,
				// 	offset: plugin_settings.map.offset
				// })

				// select the sidebar item

				// console.log($('.sidebar-item[data-id="' + settings.scenario.id + '"]'))

				$('.sidebar-item[data-id="' + settings.scenario.id + '"]').addClass('selected')

				// get the bounding layer

				plugin_instance.get_bounds({
					scenario: settings.scenario
				})

				plugin_instance.do_breadcrumb('select')

				plugin_settings.current_view = 'select'

			}

    },

    item_detail: function(fn_options) {

      var plugin_instance = this
      //var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      //var plugin_elements = plugin_settings.elements

      // options

			var defaults = {
				item_id: 1,
				scenario: null
			}

			if (typeof fn_options == 'string') {
				defaults.item_id = fn_options
				fn_options = {}
			}

      var settings = $.extend(true, defaults, fn_options)

			console.log('detail', plugin_settings.scenario.key)

			// set param values for initial view

			plugin_settings.api.limit = 10

			var detail_html

			// load the detail sidebar template

			$(document).profiler('get_sidebar', {
				url: 'scenarios/detail.php',
				data: plugin_settings.scenario,
				before: function() {

					$('body').attr('data-sidebar-width', 'half')
					$('.app-head').attr('data-mode', 'scenario-detail')

				},
				success: function(data) {

					// console.log('detail', 'success')

					plugin_settings.current_view = 'detail'
					plugin_settings.map.last_zoom = -1

					// empty the bbox pane
					plugin_settings.map.object.removeLayer(plugin_settings.map.layers.bbox)
					plugin_settings.map.panes.bbox.style.display = 'none'

					// find the first indicator item in the template and set it as the current indicator

					plugin_instance.set_indicator(JSON.parse($('.app-sidebar-content').find('.indicator-item').first().attr('data-indicator')))

					// update the epicentre and display it
					plugin_instance.set_epicenter()

					// hide the markers pane
					plugin_settings.map.panes.markers.style.display = 'none'

					// get ready to call the API

					plugin_instance.get_layer()

				},
				complete: function() {

					console.log('detail', 'done')

					// add bootstrap behaviours to the newly loaded template

					$('.app-sidebar').find('.accordion').on('shown.bs.collapse', function () {

						var selected_card = $('.app-sidebar').find('.collapse.show'),
								selected_header = selected_card.prev()

						// add 'open' class to header

						selected_header.addClass('open')

					}).on('hide.bs.collapse', function () {

						$('.app-sidebar').find('.collapse').prev().removeClass('open')

					})

					plugin_instance.do_breadcrumb('detail')

					$('.app-breadcrumb .breadcrumb').find('#breadcrumb-scenario-name').text(plugin_settings.scenario.title)

					// $('.app-sidebar').find('.accordion').on('click', '.')

				}
			})


    },

		get_bounds: function(fn_options) {

      var plugin_instance = this
      var plugin_settings = plugin_instance.options

      var settings = $.extend(true, {
				scenario: null
			}, fn_options)

			console.log('bounds', settings.scenario.key)

			if (settings.scenario != null) {

				// spinner
				$('body').addClass('spinner-on')
				$('#spinner-progress').text('Loading scenario data')

				plugin_settings.map.panes.bbox.style.display = ''

				$.ajax({
					url: plugin_settings.api.base_URL + settings.scenario.key.toLowerCase() + '_shakemap?f=json',
					success: function(data) {

						// console.log('success', data)

						var box_coords = data.extent.spatial.bbox[0]

						// define rectangle geographical bounds

						var bounds = [[box_coords[1], box_coords[0]], [box_coords[3], box_coords[2]]]

						if (plugin_settings.map.layers.bbox) {
							plugin_settings.map.object.removeLayer(plugin_settings.map.layers.bbox)
						}

						// create an orange rectangle

						plugin_settings.map.layers.bbox = L.rectangle(bounds, {
							color: "#f05a23",
							weight: 1,
							pane: 'bbox'
						}).addTo(plugin_settings.map.object)

						// zoom the map to the rectangle bounds

						plugin_settings.map.object.fitBounds(bounds, {
							paddingTopLeft: [$(window).outerWidth() / 4, 0]
						})

						// spinner
						$('body').removeClass('spinner-on')
						$('#spinner-progress').text('')

					}
				})


			}


		},

    get_layer: function(fn_options) {

      var plugin_instance = this
      var plugin_settings = plugin_instance.options

      var settings = $.extend(true, {
				scenario: null
			}, fn_options)

			if (plugin_settings.scenario == null) {

				console.log('error: no scenario set')

			} else {

				console.log('get layer', plugin_settings.scenario.key, plugin_settings.indicator.key)

				// close the popup
				plugin_settings.map.object.closePopup()

				// use the selected scenario to populate the API url
				plugin_instance.update_api_url()

				// spinner
				$('body').addClass('spinner-on')
				$('#spinner-progress').text('Retrieving data')

				// reset the legend's max value so it can be regenerated
				// while looping through the new data
				plugin_settings.legend.max = 0

				// empty the API data array
				plugin_settings.api.data = []

				// LAYER TYPE:
				// if shakemap, run the elasticsearch function,
				// if anything else, run the geoAPI function

				if (plugin_settings.indicator.key == 'sh_PGA') {

					// swap pane display

					// hide choro layer & data pane
					plugin_settings.api.features = []
					plugin_settings.map.layers.choro.clearLayers()
					// plugin_settings.map.object.removeLayer(plugin_settings.map.layers.choro)
					// plugin_settings.map.panes.data.style.display = 'none'

					// show shakemap pane
					plugin_settings.map.panes.shakemap.style.display = ''

					plugin_settings.elastic.merc = new SphericalMercator({
		        size: 256
		      });

					// create shakemap geoJSON object

					plugin_settings.map.layers.shake_choro = L.geoJSON(null, {
						pane: 'shakemap',
						style: {
							fillColor: '#aaa',
							weight: 0.4,
							opacity: 1,
							color: 'white',
							dashArray: '0',
							fillOpacity: 0.5
						},
						onEachFeature: function(feature, layer) {

							layer.setStyle({
								fillColor: plugin_instance.getFeatureColor(feature.properties[feature_index_prop])
							})

						}
					}).addTo(plugin_settings.map.object)

					// create shakemap grid object

					plugin_settings.map.layers.shake_grid = L.featureGroup([]).addTo(plugin_settings.map.object)

				} else {

					// not shakemap

					// pane/layer visibility

					plugin_settings.map.layers.shake_choro.clearLayers()
					plugin_settings.map.layers.shake_grid.clearLayers()

					plugin_settings.map.object.removeLayer(plugin_settings.map.layers.shake_choro)
					plugin_settings.map.object.removeLayer(plugin_settings.map.layers.shake_grid)

					plugin_settings.map.panes.data.style.display = ''
					plugin_settings.map.panes.shakemap.style.display = 'none'


				}

				plugin_instance.prep_for_api()

			}

		},

		update_api_url: function() {

      var plugin_instance = this
      var plugin_settings = plugin_instance.options

			if (plugin_settings.indicator.key == 'sh_PGA') {

				url = elastic_url
					+ '/opendrr_dsra_'
					+ plugin_settings.scenario.key.toLowerCase()
					+ '_indicators_' + plugin_settings.api.aggregation
					+ '/_search'

				if (plugin_settings.map.current_zoom > 11) {
					url += '?scroll=1m'
				}

			} else {

				url = plugin_settings.api.base_URL
					+ plugin_settings.scenario.key.toLowerCase()
					+ '_indicators_'
					+ plugin_settings.api.aggregation
					+ '/items?'
					+ "lang=" + plugin_settings.api.lang
					+ "&f=json"
					+ "&limit=" + plugin_settings.api.limit
					+ '&properties=' + plugin_settings.api.agg_prop + ','
					 	+ plugin_settings.indicator.key
					+ ((plugin_settings.indicator.retrofit !== false) ? '_' + plugin_settings.api.retrofit : '')

					if (plugin_settings.api.bbox !== null) {
						url += '&bbox=' + plugin_settings.api.bbox
					}

			}

			plugin_settings.api.geojson_URL = url

			console.log('update_api_url', url)

			return url

		},

		prep_for_api: function(url = null) {

      var plugin_instance = this
      var plugin_settings = plugin_instance.options

			console.log('prep', plugin_settings.indicator.key)

			// SHAKEMAP OR OTHER

			if (plugin_settings.indicator.key == 'sh_PGA') {

				// clear existing shakemap layers
				plugin_settings.map.layers.shake_choro.clearLayers()
				plugin_settings.map.layers.shake_grid.clearLayers()

				// remove the legend
				plugin_settings.map.legend.remove()

				if ( plugin_settings.map.object.getZoom() > 11 ) {

					plugin_settings.api.aggregation = 's'

					// show shake choro layer

					plugin_settings.map.object.removeLayer(plugin_settings.map.layers.shake_grid)
					plugin_settings.map.object.addLayer(plugin_settings.map.layers.shake_choro)

					// get feature data
					plugin_instance.getFeatureData(scroll_id)

				} else {

					plugin_settings.api.aggregation = 'b'

					// show shake grid layer

					plugin_settings.map.object.removeLayer(plugin_settings.map.layers.shake_choro)
					plugin_settings.map.object.addLayer(plugin_settings.map.layers.shake_grid)

					// get grid data
					plugin_instance.getGridData()

				}

			} else {

				var fetch = false

				if ( plugin_settings.map.current_zoom > 10 ) {

					if (plugin_settings.map.last_zoom <= 10) {
						console.log('zoomed past 10')
						plugin_settings.map.zoom_changed_agg = true
					}

					// if zooming in past 10,
					// always run it because we're using the bounding box

					// reset the layer
					plugin_settings.map.layers.choro.clearLayers()
					plugin_settings.api.features = []

					// adjust the query and rebuild geojson_URL
					var bounds = plugin_settings.map.object.getBounds()

					plugin_settings.api.bbox = [
						bounds.getSouthWest().lng,
						bounds.getSouthWest().lat,
						bounds.getNorthEast().lng,
						bounds.getNorthEast().lat,
					]

					plugin_settings.api.limit = 500
					plugin_settings.api.aggregation = 's'
					plugin_settings.api.agg_prop = 'Sauid'

					plugin_settings.legend.max = 0

					// empty the API data array
					plugin_settings.api.data = []

					// run the geoapi call
					fetch = true

				} else if (plugin_settings.map.last_zoom > 10) {

					plugin_settings.map.zoom_changed_agg = true

					// if zooming out from 10

					// clear the layers
					plugin_settings.map.layers.choro.clearLayers()

					plugin_settings.api.features = []
					plugin_settings.api.bbox = null
					plugin_settings.api.limit = 10
					plugin_settings.api.aggregation = 'csd'
					plugin_settings.api.agg_prop = 'csduid'

					plugin_settings.legend.max = 0

					// empty the API data array
					plugin_settings.api.data = []

					// run the geoapi call
					fetch = true

				} else if (plugin_settings.api.data.length == 0) {

					// if initial load

					// plugin_settings.api.features = []
					plugin_settings.api.bbox = null
					plugin_settings.api.limit = 10
					plugin_settings.api.aggregation = 'csd'
					plugin_settings.api.agg_prop = 'csduid'

					plugin_settings.legend.max = 0

					fetch = true

				}

				if (fetch == true) {
					// run the geoapi call
					plugin_instance.fetch_geoapi() // do legend
				}

			}


		},

		fetch_geoapi: function(url = null, do_legend = true) {

      var plugin_instance = this
      var plugin_settings = plugin_instance.options

			var nxt_lnk;

			// if no URL given, use the global geoJSON URL setting

			if ( url == null ) {
				url = plugin_instance.update_api_url()
			}

			$('body').addClass('spinner-on')
			$('#spinner-progress').text('Retrieving data')

			// do we need to redo the legend?
			// - anytime we're loading a new indicator
			// - the zoom action changed the aggregation level

			// if (
			// 	( plugin_settings.api.data.length == 0 &&
			// 		( plugin_settings.indicator.retrofit == false || plugin_settings.api.retrofit == 'b0' ) ) ||
			// 	plugin_settings.map.zoom_changed_agg == true
			// ) {
			//
			// 	console.log('do legend stuff')
			//
			// 	redo_legend = true
			// }

			$.getJSON(url, function (data) {

				// console.log('fetching ' + url)

				// console.log(url, data)

				if (typeof data.features !== 'undefined') {

					// do legend calculations if not retrofit

					if (do_legend == true) {

						data.features.forEach(function(feature) {

							var feature_val_key = plugin_settings.indicator.key

							if (plugin_settings.indicator.retrofit !== false) {
								feature_val_key += '_' + plugin_settings.api.retrofit
							}

							// check/update max value

							if (feature.properties[feature_val_key] > plugin_settings.legend.max) {
								plugin_settings.legend.max = feature.properties[feature_val_key]
							}

						})

					}

					plugin_settings.api.data.push(data)

				}

				// plugin_settings.map.layers.choro.addData(data)

				for (var l in data.links) {
					lnk = data.links[l]

					if (lnk.rel == 'next') {
						nxt_lnk = lnk.href
						break
					}
				}

				// if a 'next' link exists, continue loading data

				if (nxt_lnk) {

 					// inherit do_legend setting
					plugin_instance.fetch_geoapi(nxt_lnk, do_legend)

				} else {

					if (do_legend == true) {

						console.log('process new legend')

						// determine legend grades

						console.log(plugin_settings.indicator)
						console.log(plugin_settings.api.aggregation)
						console.log(plugin_settings.indicator.aggregation[plugin_settings.api.aggregation])

						var max_step = plugin_settings.legend.max * Math.pow(10, plugin_settings.indicator.aggregation[plugin_settings.api.aggregation]['rounding']),
								pow = 0,
								legend_step = 0

						console.log('max ' + max_step)

						if (max_step >= 1) {

							while (max_step > 100) {
								pow += 1
								max_step = plugin_settings.legend.max / Math.pow(10, pow)
							}

							// create an array of breaks for the legend values

							legend_step = max_step / 5

							// console.log('step', legend_step)

							plugin_settings.legend.grades = [
								(max_step - (legend_step)) * Math.pow(10, pow),
								(max_step - (legend_step * 2)) * Math.pow(10, pow),
								(max_step - (legend_step * 3)) * Math.pow(10, pow),
								(max_step - (legend_step * 4)) * Math.pow(10, pow)
							]

						} else {

							legend_step = max_step / 5

							console.log('step', legend_step)

							plugin_settings.legend.grades = [
								max_step - (legend_step),
								max_step - (legend_step * 2),
								max_step - (legend_step * 3),
								max_step - (legend_step * 4)
							]

						}

						console.log('legend', plugin_settings.legend.grades)

					}

					if (plugin_settings.map.zoom_changed_agg == true) {
						plugin_settings.map.zoom_changed_agg = false
					}

					plugin_instance.process_geoapi()

				}
			})
			.fail(function(jqXHR, error) {

				// $( '#alert' ).show()
				// console.log(error)
				// $('body').removeClass('spinner-on')

			})

		},

		process_geoapi: function(data) {

      var plugin_instance = this
      //var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      //var plugin_elements = plugin_settings.elements

			console.log('processing', plugin_settings.api.data)
			$('#spinner-progress').text('Drawing layers')

			// iterate through collections

			if (plugin_settings.indicator.key == 'sh_PGA') {

				// if the data is a shakemap

				// hide the geojson pane
				plugin_settings.map.panes.data.style.display = 'none'

				// show the shakemap pane
				plugin_settings.map.panes.shakemap.style.display = ''

			} else {

				// hide the shakemap pane
				plugin_settings.map.panes.shakemap.style.display = 'none'

				// show the geojson pane
				plugin_settings.map.panes.data.style.display = ''

				// if the data is geoJSON

				plugin_settings.api.data.forEach(function(collection) {

					// iterate through the returned features

					collection.features.forEach(function(feature, z) {

						if (typeof plugin_settings.api.features[feature.id] !== 'undefined') {

							// update the feature with the new data
							// plugin_settings.api.features[feature.id]['properties'] = feature.properties

							// console.log(feature.properties)

							var prop_key = plugin_settings.indicator.key

							if (plugin_settings.indicator.retrofit !== false) {
								prop_key += '_' + plugin_settings.api.retrofit
							}

							// if the feature already exists on the map,

							// update its properties

							plugin_settings.api.features[feature.id]['feature'] = feature

							// plugin_settings.api.features[feature.id] = feature

							// update its color

							var rounded_color = feature.properties[prop_key] * Math.pow(10, plugin_settings.indicator.aggregation[plugin_settings.api.aggregation]['rounding'])

							plugin_settings.api.features[feature.id].setStyle({
								fillColor: plugin_instance._choro_color(rounded_color)
							}).setPopupContent(function(e) {

								// update the popup content

								return L.Util.template('<p>'
									+ plugin_settings.indicator.legend.prepend + ' '
									+ feature.properties[prop_key].toLocaleString(undefined, { maximumFractionDigits: plugin_settings.indicator.aggregation[plugin_settings.api.aggregation]['decimals'] })
									+ ' '
									+ plugin_settings.indicator.legend.append
									+ '</p>'
								)

							})

							plugin_settings.logging.update_count += 1

						} else {

							// if not, add the feature

							plugin_settings.map.layers.choro.addData(feature)

							plugin_settings.logging.feature_count += 1

						}

					})
				})

				// set map bounds to frame loaded features on first load

				if ( plugin_settings.map.last_zoom == -1 ) {

					plugin_settings.map.object.fitBounds(plugin_settings.map.layers.choro.getBounds(), {
						paddingTopLeft: [$(window).outerWidth() / 2, 0]
					})

				}

				// if retrofit is off, add the legend

				if (plugin_settings.indicator.retrofit == true && plugin_settings.api.retrofit == 'b0') {

					plugin_settings.map.legend.addTo(plugin_settings.map.object)

					$('body').find('.legend-item').tooltip()

				}

				// console.log(plugin_settings.api.data, plugin_settings.api.features)

				console.log('added ' + plugin_settings.logging.feature_count + ' layers, updated ' + plugin_settings.logging.update_count + ' layers')

				plugin_settings.logging.feature_count = 0
				plugin_settings.logging.update_count = 0

			}

			// update breadcrumb

			$('.app-breadcrumb .breadcrumb').find('#breadcrumb-scenario-indicator').text(plugin_settings.indicator.title)

			// remove progress
			$('body').removeClass('spinner-on')
			$('#spinner-progress').text('')

		},

		set_epicenter: function() {

      var plugin_instance = this
      //var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      //var plugin_elements = plugin_settings.elements

			// console.log(plugin_settings.scenario.coords)

			var marker_coords = new L.LatLng(plugin_settings.scenario.coords.lat, plugin_settings.scenario.coords.lng)

			plugin_settings.map.epicenter.setLatLng(marker_coords)

			plugin_settings.map.panes.epicenter.style.display = ''

		},

		_choro_color: function(d) {

      var plugin_instance = this
      //var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      //var plugin_elements = plugin_settings.elements

			return d > plugin_settings.legend.grades[0] ? '#ff3b00' :
				d > plugin_settings.legend.grades[1]   ? '#ff6500' :
					d > plugin_settings.legend.grades[2]   ? '#ff9000' :
						d > plugin_settings.legend.grades[3]   ? '#ffba00' :
							'#fff176'

		},

		_choro_style: function(feature) {

      var plugin_instance = this
      //var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      //var plugin_elements = plugin_settings.elements

			// console.log(feature)

			var prop_key = plugin_settings.indicator.key + ((plugin_settings.indicator.retrofit !== false) ? '_' + plugin_settings.api.retrofit : '')

			var rounded_color = feature.properties[prop_key] * Math.pow(10, plugin_settings.indicator.aggregation[plugin_settings.api.aggregation]['rounding'])

			return {
					fillColor: plugin_instance._choro_color(rounded_color),
					weight: 0.4,
					fillOpacity: 0.7,
					color: '#4b4d4d',
					opacity: 1
			};
		},

		_choro_selected_style: function(feature) {
			return {
				fillColor: '#9595a0',
				color: '#2b2c42',
				weight: 0.8,
				fillOpacity: 0.5
			};
		},

		do_breadcrumb: function(fn_options) {

			var plugin_instance = this
			//var plugin_item = this.item
			var plugin_settings = plugin_instance.options
			//var plugin_elements = plugin_settings.elements

			var settings = $.extend(true, {}, fn_options)

			$('.app-breadcrumb li:not(.persistent)').remove()

			if (typeof fn_options == 'string') {

				// console.log(fn_options)

				// check settings for breadcrumb object

				plugin_settings.breadcrumbs[fn_options].forEach(function(i) {

					// console.log(i)

					new_item = $('<li class="breadcrumb-item">' + i.text + '</li>').appendTo('.app-breadcrumb .breadcrumb')

					if (typeof i.class !== 'undefined') {
						new_item.addClass(i.class)
					}

					if (typeof i.id !== 'undefined') {
						new_item.attr('id', i.id)
					}

				})

			}

		},

		tile2long: function(x, z) {
				return (x/Math.pow( 2, z ) * 360 - 180)
		},

		tile2lat: function(y, z) {
			var n = Math.PI-2 * Math.PI * y / Math.pow(2, z)

			return (180/Math.PI * Math.atan(0.5 * (Math.exp(n) -Math.exp(-n))))
		},

		getFeatureColor: function(v) {
			return v >= 0.31 ? '#bd0026' :
				v >= 0.20 ? '#eb3420' :
				v >= 0.13 ? '#fb7b35' :
				v >= 0.08 ? '#feb751' :
				v >= 0.03 ? '#ffe98c' :
				v >= 0.01 ? '#ffff1d' :
				'#ffff1d';
		},

		getBucketColor: function( v ) {
			return v >= 10000 ? '#bd0026' :
				v >= 7778 ? '#eb3420' :
				v >= 5556 ? '#fb7b35' :
				v >= 3333 ? '#feb751' :
				v >= 1111 ? '#ffe98c' :
				v >= 0 ? '#ffff1d' :
				'#ffff1d';
		},

		calcPrecision: function() {

      var plugin_instance = this
      //var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      //var plugin_elements = plugin_settings.elements

			let p = ((plugin_settings.map.object.getZoom() * (29/18)) - 1).toFixed(0)

			// p = ++p;

			if (plugin_settings.map.object.getZoom() > 8) {

				p = plugin_settings.map.object.getZoom() + 5

			} else if (plugin_settings.map.object.getZoom() > 6) {

				p = 12

			} else {

				p = 10

			}

			return p

		},

		getGridData: function() {

      var plugin_instance = this,
					plugin_settings = plugin_instance.options

			$('body').addClass('spinner-on')
			$('#spinner-progress').text('Retrieving grid data')

			// console.log('getGridData')

			var b = plugin_settings.map.object.getBounds(),
					b1 = {
						"tllat": b.getNorthWest().lat > 90 ? 90 : b.getNorthWest().lat,
						"tllon": b.getNorthWest().lng < -180 ? -180 : b.getNorthWest().lng,
						"brlat": b.getSouthEast().lat < -90 ? -90 : b.getSouthEast().lat,
						"brlon": b.getSouthEast().lng > 180 ? 180 : b.getSouthEast().lng
					}, scroll_id;

			var url = plugin_instance.update_api_url()

			$.ajax({
					method: "POST",
					tryCount : 0,
					retryLimit : 3,
					crossDomain: true,
					url: url,
					data: JSON.stringify({
						"size": 0,
						"aggs": {
							"my_applicable_filters": {
								"filter": {
									"bool": {
										"must": [
											{
												"geo_bounding_box": {
													"coordinates": {
														"top_left": b1.tllat + ',' + b1.tllon,
														"bottom_right": b1.brlat + ',' + b1.brlon
													}
												}
											}
										]
									}
								},
								"aggs": {
									"avg_my_field": {
										"avg": {
											"field": "properties.sH_PGA"
										}
									},
									"large-grid": {
										"geotile_grid": {
											"field": "coordinates",
											"precision": plugin_instance.calcPrecision()
										}
									}
								}
							}
						}
					}),
					headers: { "content-type": "application/json" },
					success: function(resp) {

						// console.log(url)
						// console.log('getGridData', resp)

						let markers = [];

						const buckets = resp.aggregations['my_applicable_filters']['large-grid'].buckets;

						buckets.forEach( bucket => {

							splitbucket = bucket.key.split('/');

							let z = splitbucket[0]
							let x = splitbucket[1]
							let y = splitbucket[2]

							let lat = plugin_instance.tile2lat(y, z)
							let lon = plugin_instance.tile2long(x, z)

							markers.push([lat, lon, bucket.doc_count])

							var bbox = plugin_settings.elastic.merc.bbox(x, y, z)

							// define rectangle geographical bounds
							var bounds = [ [ bbox[1], bbox[0] ], [ bbox[3], bbox[2] ] ]

							// console.log(bucket.doc_count, plugin_instance.getBucketColor( bucket.doc_count ))

							// create an orange rectangle
							var feature = L.rectangle(bounds, {
								color: plugin_instance.getBucketColor( bucket.doc_count ),
								weight: 0,
								fillOpacity: 0.5,
								pane: 'shakemap'
							}).addTo(plugin_settings.map.layers.shake_grid)

						})

						$('body').removeClass('spinner-on')
						$('#spinner-progress').text('')

					},
					complete: function() {

						if (plugin_settings.map.last_zoom == -1) {
							plugin_settings.map.object.fitBounds(plugin_settings.map.layers.shake_grid.getBounds(), {
								paddingTopLeft: [$(window).outerWidth() / 2, 0]
							})
						}

						// update breadcrumb

						$('.app-breadcrumb .breadcrumb').find('#breadcrumb-scenario-indicator').text(plugin_settings.indicator.title)

					},
					fail: function(error) {

						this.tryCount++

						if (this.tryCount <= this.retryLimit) {
							// try again
							$.ajax(this)
							return
						}

						console.log('error: ' + error)
						return

					}
			})

			// $( '#modal' ).remove();
		},

		getFeatureData: function(scroll_id) {

			// gets shakemap choropleth

      var plugin_instance = this
      //var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      //var plugin_elements = plugin_settings.elements

			$('body').addClass('spinner-on')
			$('#spinner-progress').text('Retrieving data')

			console.log('getFeatureData', scroll_id)

			var b = plugin_settings.map.object.getBounds(),
					b1 = {
							"tllat": b.getNorthWest().lat > 90 ? 90 : b.getNorthWest().lat,
							"tllon": b.getNorthWest().lng < -180 ? -180 : b.getNorthWest().lng,
							"brlat": b.getSouthEast().lat < -90 ? -90 : b.getSouthEast().lat,
							"brlon": b.getSouthEast().lng > 180 ? 180 : b.getSouthEast().lng
					}

			var url = plugin_instance.update_api_url(),
					feature_query = {
						"size": 1000,
						"_source": [ "id","type", "geometry.*", "properties." + feature_index_prop ],
						"query": {
							"geo_shape": {
								"geometry": {
									"shape": {
										"type": "envelope",
										"coordinates": [ [ b1.tllon, b1.tllat ], [ b1.brlon, b1.brlat ] ]
									},
									"relation": "intersects"
								}
							}
						}
					}

			if (scroll_id) {

				url = elastic_url + '/_search/scroll'

				feature_query = {
					'scroll': '1m',
					'scroll_id': scroll_id
				}

			}

			$.ajax({
					method: "POST",
					tryCount : 0,
					retryLimit : 3,
					crossDomain: true,
					url: url,
					data: JSON.stringify(feature_query),
					headers: { "content-type": "application/json" },
					success: function(resp) {

						var len = plugin_settings.map.layers.shake_choro.getLayers().length;

						if ( len === resp.hits.total.value || len === featureLimit ) {
								// $( '#modal' ).remove();
						}

						if ( len < resp.hits.total.value && len < featureLimit ) {

							plugin_instance.addGeoJSONFeatures( resp.hits.hits, function( e ) {

								if ( resp.hits.hits.length > 0 && len <= featureLimit ) {
									plugin_instance.getFeatureData(resp._scroll_id);
								}

								if ( plugin_settings.map.layers.shake_choro.getLayers().length >= featureLimit ) {
										// $( '#alert' ).show();
								}

							} )

						}

						console.log('spinner off')
						$('body').removeClass('spinner-on')
						$('#spinner-progress').text('')

					},
					complete: function() {

						// update breadcrumb

						$('.app-breadcrumb .breadcrumb').find('#breadcrumb-scenario-indicator').text(plugin_settings.indicator.title)

					},
					fail: function(error) {
						this.tryCount++

						if ( this.tryCount <= this.retryLimit ) {
							//try again
							$.ajax(this)
							return;
						}

						console.log(error)
						return
					}
			})

		},

		addGeoJSONFeatures: function( data, callback ) {

			// adds sh_PGA choropleth in the map.layers.shake_choro layer

      var plugin_instance = this
      var plugin_settings = plugin_instance.options

				var features = [],
						source,
						d;

				data.forEach( feature => {
					source = feature._source;
					source.properties._id = feature._id;
					features.push( source );
				});

				plugin_settings.map.layers.shake_choro.addData( features );

				if ( callback ) {
					callback();
				}
		}

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
