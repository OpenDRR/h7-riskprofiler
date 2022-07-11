var z = 0

var csd_temp, s_temp

var grades, color_ramp

// scenario profiler
// v1.0

;(function ($) {

  // custom select class

  function rp_scenarios(item, options) {

    // options

    var defaults = {
			api: {
				version: '1.4.0',
				base_URL: geoapi_url + '/collections/opendrr_dsra_',
				retrofit: 'b0', // or r1
				lang: 'en_US',
				bbox: null
			},
      aggregation: {
        'current': {},
        'previous': null,
        'settings': {
          'shake': [
            { min: 10, max: 15, agg: '1km', prop: 'sH_PGA_max', bbox: true },
            { min: 6, max: 9, agg: '5km', prop: 'sH_PGA_max', bbox: true },
            { min: 1, max: 5, agg: '5km', prop: 'sH_PGA_max', bbox: false }
          ],
          'default': [
            { min: 11, max: 15, agg: 's', prop: 'Sauid', bbox: true },
            { min: 1, max: 10, agg: 'csd', prop: 'csduid', bbox: false }
          ]
        }
      },
			map: {
				object: null,
				legend: null,
				offset: $('.app-sidebar').outerWidth(),
				panes: [],
				layers: {
					bbox: null,
					shake_grid: null,
					shake_choro: null,
					choro: null,
					tiles: null
				},
				markers: null,
				popup: null,
				selected_marker: null,
				selected_feature: null,
				geojsonLayer: null,
				current_zoom: 3,
				last_zoom: -1,
				defaults: {
					coords: [60, -110],
					zoom: 3
				}
			},
			charts: {
				enabled: true,
				container: $('.app-charts'),
				elements: [
					{
						name: rp.building_type + ' (G)',
						field: 'E_BldgTypeG',
						size: 100,
						object: null,
						tooltips: false,
						columns: [
							{
								code: 'Wood',
								name: 'Wood',
								value: [0]
							},
							{
								code: 'Concrete',
								name: 'Concrete',
								value: [0]
							},
							{
								code: 'Steel',
								name: 'Steel',
								value: [0]
							},
							{
								code: 'URMasonry',
								name: 'Unreinforced Masonry',
								value: [0]
							},
							{
								code: 'RMasonry',
								name: 'Reinforced Masonry',
								value: [0]
							},
							{
								code: 'Precast',
								name: 'Precast',
								value: [0]
							},
							{
								code: 'Manufactured',
								name: 'Manufactured',
								value: [0]
							}
						]
					},
					{
						name: rp.building_type + ' (S)',
						field: 'E_BldgTypeS',
						size: 100,
						object: null,
						tooltips: true,
						columns: [
							{
								code: 'W1',
								name: 'Wood, Single Family',
								value: [0]
							},
							{
								code: 'W2',
								name: 'Wood, Multi Family',
								value: [0]
							},
							{
								code: 'W3',
								name: 'Wood, Commercial and Industrial',
								value: [0]
							},
							{
								code: 'W4',
								name: 'Wood, Single Family with Cripple Wall or Subfloor',
								value: [0]
							},
							{
								code: 'S1L',
								name: 'Steel Moment Frame (Low-Rise)',
								value: [0]
							},
							{
								code: 'S1M',
								name: 'Steel Moment Frame (Mid-Rise)',
								value: [0]
							},
							{
								code: 'S1H',
								name: 'Steel Moment Frame (High-Rise)',
								value: [0]
							},
							{
								code: 'S2L',
								name: 'Steel Braced (Low-Rise)',
								value: [0]
							},
							{
								code: 'S2M',
								name: 'Steel Braced (Mid-Rise)',
								value: [0]
							},
							{
								code: 'S2H',
								name: 'Steel Braced (High-Rise)',
								value: [0]
							},
							{
								code: 'S3',
								name: 'Steel Light Frame',
								value: [0]
							},
							{
								code: 'S4L',
								name: 'Steel Frame with Cast-in-Place Concrete Shear Walls (Low-Rise)',
								value: [0]
							},
							{
								code: 'S4M',
								name: 'Steel Frame with Cast-in-Place Concrete Shear Walls (Mid-Rise)',
								value: [0]
							},
							{
								code: 'S4H',
								name: 'Steel Frame with Cast-in-Place Concrete Shear Walls (High-Rise)',
								value: [0]
							},
							{
								code: 'S5L',
								name: 'Steel Frame with Unreinforced Masonry Infill Walls (Low-Rise)',
								value: [0]
							},
							{
								code: 'S5M',
								name: 'Steel Frame with Unreinforced Masonry Infill Walls (Mid-Rise)',
								value: [0]
							},
							{
								code: 'S5H',
								name: 'Steel Frame with Unreinforced Masonry Infill Walls (High-Rise)',
								value: [0]
							},
							{
								code: 'C1L',
								name: 'Concrete Moment (Low-Rise)',
								value: [0]
							},
							{
								code: 'C1M',
								name: 'Concrete Moment (Mid-Rise)',
								value: [0]
							},
							{
								code: 'C1H',
								name: 'Concrete Moment (High-Rise)',
								value: [0]
							},
							{
								code: 'C2L',
								name: 'Concrete Shear Walls (Low-Rise)',
								value: [0]
							},
							{
								code: 'C2M',
								name: 'Concrete Shear Walls (Mid-Rise)',
								value: [0]
							},
							{
								code: 'C2H',
								name: 'Concrete Shear Walls (High-Rise)',
								value: [0]
							},
							{
								code: 'C3L',
								name: 'Concrete Frame with Unreinforced Masonry Infill Walls (Low-Rise)',
								value: [0]
							},
							{
								code: 'C3M',
								name: 'Concrete Frame with Unreinforced Masonry Infill Walls (Mid-Rise)',
								value: [0]
							},
							{
								code: 'C3H',
								name: 'Concrete Frame with Unreinforced Masonry Infill Walls (High-Rise)',
								value: [0]
							},
							{
								code: 'PC1',
								name: 'Precast Concrete Tilt-up Walls',
								value: [0]
							},
							{
								code: 'PC2L',
								name: 'Precast Concrete Frames with Concrete Shear Walls (Low-Rise)',
								value: [0]
							},
							{
								code: 'PC2M',
								name: 'Precast Concrete Frames with Concrete Shear Walls (Mid-Rise)',
								value: [0]
							},
							{
								code: 'PC2H',
								name: 'Precast Concrete Frames with Concrete Shear Walls (High-Rise)',
								value: [0]
							},
							{
								code: 'RM1L',
								name: 'Reinforced Masonry Bearing Walls with Wood or Metal Deck Diaphragms (Low-Rise)',
								value: [0]
							},
							{
								code: 'RM1M',
								name: 'Reinforced Masonry Bearing Walls with Wood or Metal Deck Diaphragms (Mid-Rise)',
								value: [0]
							},
							{
								code: 'RM2L',
								name: 'Reinforced Masonry Bearing Walls with Precast Concrete Diaphragms (Low-Rise)',
								value: [0]
							},
							{
								code: 'RM2M',
								name: 'Reinforced Masonry Bearing Walls with Precast Concrete Diaphragms (Mid-Rise)',
								value: [0]
							},
							{
								code: 'RM2H',
								name: 'Reinforced Masonry Bearing Walls with Precast Concrete Diaphragms (High-Rise)',
								value: [0]
							},
							{
								code: 'URML',
								name: 'Unreinforced Masonry Bearing Walls (Low-Rise)',
								value: [0]
							},
							{
								code: 'URMM',
								name: 'Unreinforced Masonry Bearing Walls (Mid-Rise)',
								value: [0]
							},
							{
								code: 'MH',
								name: 'Mobile Homes',
								value: [0]
							}
						],
					},
					{
						name: rp.design_level,
						field: 'E_BldgDesLev',
						size: 6,
						object: null,
						tooltips: false,
						columns: [
							{
								code: 'LC',
								name: 'Low Code',
								value: [0]
							},
							{
								code: 'MC',
								name: 'Moderate Code',
								value: [0]
							},
							{
								code: 'HC',
								name: 'High Code',
								value: [0]
							},
							{
								code: 'PC',
								name: 'Pre-Code',
								value: [0]
							}
						]
					},
					{
						name: rp.occupancy_class + ' (G)',
						field: 'E_BldgOccG',
						size: 29,
						object: null,
						tooltips: false,
						columns: [
							{
								code: 'RES',
								name: 'Residential',
								value: [0]
							},
							{
								code: 'COM',
								name: 'Commercial',
								value: [0]
							},
							{
								code: 'IND',
								name: 'Industrial',
								value: [0]
							},
							{
								code: 'REL',
								name: 'Religion/Non-Profit',
								value: [0]
							},
							{
								code: 'EDU',
								name: 'Education',
								value: [0]
							},
							{
								code: 'GOV',
								name: 'Government',
								value: [0]
							},
							{
								code: 'AGR',
								name: 'Agriculture',
								value: [0]
							}
						]
					},
					{
						name: rp.occupancy_class + ' (S1)',
						field: 'E_BldgOccS1',
						size: 29,
						object: null,
						tooltips: true,
						columns: [
							{
								code: 'RES1',
								name: 'Single Family Dwelling',
								value: [0]
							},
							{
								code: 'RES2',
								name: 'Mobile Home',
								value: [0]
							},
							{
								code: 'RES3',
								name: 'Multi Family Dwelling',
								value: [0]
							},
							{
								code: 'RES3A',
								name: 'Duplex',
								value: [0]
							},
							{
								code: 'RES3B',
								name: '3–4 Units',
								value: [0]
							},
							{
								code: 'RES3C',
								name: '5–9 Units',
								value: [0]
							},
							{
								code: 'RES3D',
								name: '10–19 Units',
								value: [0]
							},
							{
								code: 'RES3E',
								name: '20–49 Units',
								value: [0]
							},
							{
								code: 'RES3F',
								name: '50+ Units',
								value: [0]
							},
							{
								code: 'RES4',
								name: 'Temporary Lodging',
								value: [0]
							},
							{
								code: 'RES5',
								name: 'Institutional Dormitory',
								value: [0]
							},
							{
								code: 'RES6',
								name: 'Nursing Home',
								value: [0]
							},
							{
								code: 'COM1',
								name: 'Retail Trade',
								value: [0]
							},
							{
								code: 'COM2',
								name: 'Wholesale Trade',
								value: [0]
							},
							{
								code: 'COM3',
								name: 'Personal and Repair Services',
								value: [0]
							},
							{
								code: 'COM4',
								name: 'Professional/Technical Services',
								value: [0]
							},
							{
								code: 'COM5',
								name: 'Banks',
								value: [0]
							},
							{
								code: 'COM6',
								name: 'Hospital',
								value: [0]
							},
							{
								code: 'COM7',
								name: 'Medical Office/Clinic',
								value: [0]
							},
							{
								code: 'COM8',
								name: 'Entertainment and Recreation',
								value: [0]
							},
							{
								code: 'COM9',
								name: 'Theaters',
								value: [0]
							},
							{
								code: 'COM10',
								name: 'Parking',
								value: [0]
							},
							{
								code: 'IND1',
								name: 'Heavy Industrial',
								value: [0]
							},
							{
								code: 'IND2',
								name: 'Light Industrial',
								value: [0]
							},
							{
								code: 'IND3',
								name: 'Food/Drugs/Chemicals',
								value: [0]
							},
							{
								code: 'IND4',
								name: 'Metals/Minerals Processing',
								value: [0]
							},
							{
								code: 'IND5',
								name: 'High Technology',
								value: [0]
							},
							{
								code: 'IND6',
								name: 'Construction',
								value: [0]
							},
							{
								code: 'REL1',
								name: 'Church/Non-Profit',
								value: [0]
							},
							{
								code: 'EDU1',
								name: 'Grade Schools',
								value: [0]
							},
							{
								code: 'EDU2',
								name: 'Colleges/Universities',
								value: [0]
							},
							{
								code: 'GOV1',
								name: 'General Services',
								value: [0]
							},
							{
								code: 'GOV2',
								name: 'Emergency Response',
								value: [0]
							},
							{
								code: 'AGR1',
								name: 'Agriculture',
								value: [0]
							}
						]
					}
				]
			},
			breadcrumbs: {
				'init': [
					{
						text: rp.crumb_select_marker,
						class: 'tip'
					}
				],
				'select': [
					{
						text: rp.crumb_scenario,
						id: 'breadcrumb-scenario-name'
					}
				],
				'detail': [
					{
						text: rp.crumb_scenario_detail,
						id: 'breadcrumb-scenario-name'
					},
					{
						text: '',
						id: 'breadcrumb-scenario-indicator',
						class: 'tip'
					}
				],
			},
			scenario: {},
			indicator: {},
			legend: {
				max: 0,
        grades: [],
				colors: {
					shake: [
						'#ffffcc',
						'#ffeda0',
						'#fed976',
						'#feb24c',
						'#fd8d3c',
						'#fc4e2a',
						'#e31a1c',
						'#bd0026',
						'#800026',
					],
					default: [
						'#F5F4CC',
						'#F2E7C3',
						'#F0DABA',
						'#EECDB1',
						'#EBC0A8',
						'#E9B39F',
						'#E7A696',
						'#E59A8D',
						'#E28D84',
						'#E0807B',
						'#DE7373',
						'#DC666A',
						'#D95961',
						'#D74D58',
						'#D5404F',
						'#D33346',
						'#D0263D',
						'#CE1934',
						'#CC0C2B',
						'#CA0023'
					],
					green: [
						'#F7F4F1',
						'#F2F1EB',
						'#EEEFE5',
						'#E9EDDF',
						'#E5EAD9',
						'#E0E8D4',
						'#DCE6CE',
						'#D8E3C8',
						'#D3E1C2',
						'#CFDFBC',
						'#CADCB7',
						'#C6DAB1',
						'#C1D8AB',
						'#BDD5A5',
						'#B9D39F',
						'#B4D19A',
						'#B0CE94',
						'#ABCC8E',
						'#A7CA88',
						'#A3C883'
					]
				}
			},
			colors: {
				marker: '#8b0707',
				marker_hover: '#b6b6bf',
				marker_select: '#2b2c42',
			},
			current_view: 'init',
			lang_prepend: '',
      debug: false
    };

    this.options = $.extend(true, defaults, options);

    this.item = $(item);
    this.init();
  }

  rp_scenarios.prototype = {

    // init

    init: function () {

      var plugin = this
      var plugin_settings = plugin.options

      //
      // INITIALIZE
      //

      if (plugin_settings.debug == true) {
        console.log('initializing')
      }

			if ($('body').hasClass('lang-fr')) {
				plugin_settings.lang_prepend = '/fr'
			}

			//
			// SETUP UX STUFF
			//

			$('#spinner-progress').text('Initializing map')

			$('#data-modal').modal({
				show: false
			})

			//
			// MAP
			// initialize the leaflet map, panes, etc.
			//

			// OBJECT

	    plugin_settings.map.object = L.map('map', {
				zoomControl: false,
				maxZoom: 15,
				crs: L.CRS.EPSG900913,
				// dragging: !L.Browser.mobile
			}).setView(plugin_settings.map.defaults.coords, plugin_settings.map.defaults.zoom)

			var map = plugin_settings.map.object

			// CONTROLS

			L.control.zoom({
				position: 'topright'
			}).addTo(map)

			// PANES

			plugin_settings.map.panes.basemap = map.createPane('basemap')
			plugin_settings.map.panes.basemap.style.zIndex = 399
			plugin_settings.map.panes.basemap.style.pointerEvents = 'none'

			// bbox - for scenario bounding box
			plugin_settings.map.panes.bbox = map.createPane('bbox')
			plugin_settings.map.panes.bbox.style.zIndex = 540
			plugin_settings.map.panes.bbox.style.pointerEvents = 'none'

			// markers - for scenario markers and clusters
			plugin_settings.map.panes.markers = map.createPane('markers')
			plugin_settings.map.panes.markers.style.zIndex = 550
			plugin_settings.map.panes.markers.style.pointerEvents = 'all'

			// data - for geojson layers
			plugin_settings.map.panes.data = map.createPane('data')
			plugin_settings.map.panes.data.style.zIndex = 560
			plugin_settings.map.panes.data.style.pointerEvents = 'all'

			// shakemap - for shakemap data
			plugin_settings.map.panes.shakemap = map.createPane('shakemap')
			plugin_settings.map.panes.shakemap.style.zIndex = 560
			plugin_settings.map.panes.shakemap.style.pointerEvents = 'all'

			// epicenter - for selected scenario epicenter
			plugin_settings.map.panes.epicenter = map.createPane('epicenter')
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
				interactive: false,
				pane: 'epicenter'
			}).addTo(map)

			// LEGEND

			plugin_settings.map.legend = L.control( { position: 'bottomleft' } )

			plugin_settings.map.legend.onAdd = function () {

				// console.log('add legend', plugin_settings.indicator, plugin_settings.legend)

				var div = L.DomUtil.create('div', 'info legend'),
						grades = plugin_settings.legend.grades,
						indicator = plugin_settings.indicator,
						legend = indicator.legend,
						prepend = legend.prepend,
						append = legend.append,
						aggregation = indicator.aggregation,
						current_agg = plugin_settings.aggregation.current.agg

				if (indicator.type != 'dollars') {

					switch (aggregation[current_agg]['rounding']) {
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

				}

				legend_markup = '<h6>' + indicator.label + '</h6>'

				// loop through our density intervals and generate a label with a colored square for each interval

				legend_markup += '<div class="items">'

				for (var i = 1; i <= grades.length; i++) {

					var this_val = plugin._round(grades[i - 1], aggregation[current_agg]['rounding']).toLocaleString(undefined, {
							maximumFractionDigits: aggregation[current_agg]['decimals']
						})

					if (indicator.type == 'dollars') {

						this_val = plugin._round_scale(grades[i - 1])

					}

					var row_markup = '<div class="legend-item" data-toggle="tooltip" data-placement="top" style="background-color: '
            + color_ramp[i - 1] + ';"'
						+ ' title="'
						+ prepend
						+ this_val

					if (grades[i]) {

						var next_val = plugin._round(grades[i], aggregation[current_agg]['rounding']).toLocaleString(undefined, {
								maximumFractionDigits: aggregation[current_agg]['decimals']
							})

						if (indicator.type == 'dollars') {

							next_val = plugin._round_scale(grades[i])

						}

						row_markup += ' – '
							+ prepend
							+ next_val
							+ ' '
							+ append

					} else {

						row_markup += '+ ' + append

					}

					row_markup += '"></div>'

					legend_markup += row_markup

				}

				legend_markup	+= '</div>'

				div.innerHTML = legend_markup

				return div

			}

			// BASEMAP

			var basemap_URL = 'https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
					basemap_att = 'Map data © 2022 Google | <a href="https://www.google.com/intl/en-CA_US/help/terms_maps/" target="_blank">Terms of use</a>'

			if ($('body').hasClass('lang-fr')) {
				basemap_URL += '&hl=fr'
				basemap_att = 'Map data © 2022 Google | <a href="https://www.google.com/intl/en-CA_US/help/terms_maps/" target="_blank">Terms of use</a>'
			}

			L.tileLayer(basemap_URL, {
				pane: 'basemap',
		    attribution: basemap_att,
	      detectRetina: true
			}).addTo(map)

			// L.tileLayer( 'https://osm-{s}.gs.mil/tiles/default_pc/{z}/{x}/{y}.png', {
	    //   subdomains: '1234',
	    //   attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
	    //   detectRetina: true
			// }).addTo(map)

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

			// POPUPS

			plugin_settings.map.popup = L.popup({
				pane: 'data'
			})

			map.on('popupopen', function(e) {

				// console.log('open', e.popup._source)

			})

			map.on('popupclose', function(e) {

				if (
					map.hasLayer(plugin_settings.map.layers.tiles)
				) {

					var feature_deselected = false

					// if there's a selected feature

					if (plugin_settings.map.selected_feature != null) {

						// reset it

	          plugin_settings.map.layers.tiles.resetFeatureStyle(plugin_settings.map.selected_feature)

						plugin_settings.map.selected_feature = null

						$('.app-main').removeClass('feature-selected')

						feature_deselected = true

	        }

					setTimeout(function() {

						// if a new feature has NOT been selected,
						// update the charts

						if (
							feature_deselected == true &&
							plugin_settings.charts.enabled == true &&
							plugin_settings.indicator.key !== 'sH_PGA'
						) {
							console.log('reset charts')
							plugin.get_charts({
								reset: true
							})
						}

					}, 500)

				}

			})

			//
			// FILTER
			//

			// CHARTS

			$('.app-main').addClass('charts-on')

			$('#chart-togglebox').togglebox({
				off: '',
				on: ''
			})

			// RETROFIT

			$('#retrofit-togglebox').togglebox({
				off: '',
				on: ''
			})

			//
			// SIDEBAR
			//

			// GET SCENARIO LIST

			$(document).profiler('get_sidebar', {
				url: plugin_settings.lang_prepend + '/scenario',
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

					plugin_settings.map.markers = L.geoJSON([{
						"type": "FeatureCollection",
						"features": features
					}], {
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
									.bindTooltip('<div>' + feature.properties.title +'</div>', {
										direction: 'top',
										offset: [0, -10]
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

										plugin.item_select({
											scenario: feature.properties,
											marker: this
										})

									})
							}

						},
						pointToLayer: function (feature, latlng) {

							var marker = L.circleMarker(latlng, {
								pane: 'markers',
								radius: 6,
								fillColor: plugin_settings.colors.marker,
								weight: 0,
								opacity: 1,
								fillOpacity: 1
							})

							plugin_settings.map.clusters.addLayer(marker)

							return marker

						}
					})

					map.addLayer(plugin_settings.map.clusters)

					if (window.location.hash) {

						var init_id = window.location.hash,
								init_item = $('body').find(init_id)

						// console.log(window.location.hash, $('body').find(init_id))

						// trigger click the item

						init_item.trigger('click')


					}

				},
        complete: function() {
          $('body').removeClass('spinner-on')
					$('#spinner-progress').text('')
        }
			})

			//
			// INITIALIZE CHARTS
			//

			// set options

			Highcharts.setOptions({
		    lang: {
		      thousandsSep: ','
		    },
				credits: {
					enabled: false
				}
		  })

			// each chart element

			plugin_settings.charts.elements.forEach(function(request, i) {

				this_chart_ID = request.field

				// series array to populate with [0]s
				this_series = []

				request.columns.forEach(function(column) {

					this_series.push({
						name: column.code,
						custom: {
							full_name: column.name
						},
						data: column.value
					})
				})

				request.object = Highcharts.chart('chart-' + request.field, {
					tooltip: {
						useHTML: true,
						headerFormat: '',
						formatter: function() {

							var series_name = this.series.name

							if (this.series.name != this.series.userOptions.custom.full_name) {
								series_name = this.series.userOptions.custom.full_name + ' (' + this.series.name + ')'
							}

							return '<strong>' + series_name + ':</strong> '
								+ plugin_settings.indicator.legend.prepend
								+ this.y.toLocaleString(undefined, {
									maximumFractionDigits: plugin_settings.indicator.aggregation[plugin_settings.aggregation.current.agg]['decimals']
								})
								+ ' '
								+ plugin_settings.indicator.legend.append

						}
					},
					chart: {
						type: 'column',
				    height: 250,
						marginTop: 30,
						styledMode: true
					},
					title: {
						enabled: false,
						text: null,
						align: 'left',
						x: 0
					},
					xAxis: {
						labels: {
							enabled: false
						},
						tickLength: 0
					},
					yAxis: {
						min: 0,
						title: { enabled: false },
						labels: {
							x: -5,
						}
					},
					plotOptions: {
						column: {
							groupPadding: 0.02,
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
					series: this_series,
					legend: {
						enabled: false,
						width: '100%',
						maxHeight: 100,
						margin: 10
					},
					navigation: {
						buttonOptions: {
							y: -10
						}
					},
					exporting: {
						menuItemDefinitions: {
							dataModal: {
								onclick: function() {

									$('#chart-data-placeholder').html(this.getTable())

									$('#chart-data-placeholder').find('table').addClass('table table-responsive')

									$('#data-modal .modal-title').html(plugin_settings.indicator.label + ' ' + rp.by + ' ' + request.name)

									$('#data-modal').modal('show')

								},
								text: 'View data table'
							}
						},
						buttons: {
							contextButton: {
								menuItems: [ 'downloadPNG', 'downloadPDF', 'downloadSVG', 'separator', 'downloadCSV', 'dataModal' ]
							}
						}
					}
				}, function (chart) {



		    })

				$.each(request.object.series, function (j, data) {

					var this_name = '',
							this_code = data.name

					var item_markup = '<div class="legend-item">'
						+'<div class="symbol highcharts-bg-' + data.colorIndex + '"></div>'
						+ '<div class="column-name">'

					// console.log(request.columns, data)

					// see if this columns name & code are different

					request.columns.every(column => {

						if (column.code == this_code) {
							this_name = column.name
							return false
						}

						return true
					})

					if (request.tooltips == true) {

						item_markup += '<span data-toggle="tooltip" title="' + this_name + '">' + this_code + '</span>'

					} else {

						item_markup += (this_name != '') ? this_name : this_code

					}

					item_markup += '</div></div>'

					var new_legend_item = $(item_markup).appendTo('#legend-' + request.field)

				})

				$('#legend-' + request.field + ' .legend-item').click(function(){

					var inx = $(this).index(),
							point = request.object.series[inx]

					if (point.visible) {
						$(this).addClass('opacity-50')
						point.setVisible(false)
					} else {
						$(this).removeClass('opacity-50')
						point.setVisible(true)
					}

				})

			})

			// console.log($('.legend-item [data-toggle="tooltip"]'))

			$('[data-toggle="tooltip"]').tooltip({
				template: '<div class="tooltip chart-tip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
			})

			// tabs

			$('.chart-section.has-tabs li').on('click', function (e) {
			  e.preventDefault()
			  $(this).tab('show')
			})

			//
			// EVENTS
			//

			// adjust aggregation on zoom
			map.on('zoomend dragend', function (e) {

				// console.log('zoom drag', map.getZoom())

				if (plugin_settings.current_view == 'detail') {

					plugin_settings.map.current_zoom = e.target.getZoom()

          plugin_settings.aggregation.previous = plugin_settings.aggregation.current.agg

					// plugin.prep_for_api({
					// 	event: 'zoomend'
					// })

					plugin.get_layer({
						event: 'zoomend'
					})

					plugin_settings.map.last_zoom = plugin_settings.map.current_zoom

				}

			})

			//
			// ACTIONS
			//

			// click the 'explore' button in a sidebar item

			$('body').on('click', '.sidebar-item .sidebar-button', function(e) {
				plugin.item_detail({
					scenario: plugin_settings.scenario
				})
			})

			// click an unselected sidebar item

			$('body').on('click', '.sidebar-item:not(.selected)', function(e) {

				var this_scenario = JSON.parse($(this).attr('data-scenario'))

				plugin_settings.map.markers.resetStyle().eachLayer(function(layer) {

					if (this_scenario.id == layer.feature.properties.id) {

						plugin.item_select({
							scenario: this_scenario,
							marker: layer
						})

					}

				})
			})

			// DETAIL

			// select an indicator

			$('.app-sidebar').on('click', '.indicator-item', function() {

        var this_indicator = JSON.parse($(this).attr('data-indicator'))

        if (
					this_indicator.key != plugin_settings.indicator.key &&
					!$(this).hasClass('selected')
				) {

  				// close popup

  				map.closePopup()

					// reset chart data
					$('.chart-container').attr('data-series', '')

  				// switch retrofit off

  				// if ($('#retrofit-toggle .togglebox').attr('data-state') == 'on') {
  				// 	$('#retrofit-toggle .togglebox').trigger('click')
  				// }

  				// set classes

  				$('.app-sidebar').find('.indicator-item').removeClass('selected')
  				$(this).addClass('selected')

  				// update layer

  				plugin.set_indicator(this_indicator)
  				plugin.get_layer()

  			}
			})


			// click the 'back' button

			$('body').on('click', '.app-head-back', function(e) {

				plugin.do_breadcrumb('init')

				$(document).profiler('get_sidebar', {
					url: plugin_settings.lang_prepend + '/scenario',
					before: function() {

						plugin_settings.current_view = 'init'

            plugin_settings.aggregation.current = {}
            plugin_settings.aggregation.previous = null

						plugin_settings.api.bbox = null

						// empty the data and shakemaps layer
						$('.leaflet-data-pane path').remove()
						$('.leaflet-shakemap-pane path').remove()

						map.removeLayer(plugin_settings.map.layers.tiles)

						plugin_settings.map.layers.tiles = null
						plugin_settings.map.layers.shake_grid = null
						plugin_settings.map.selected_feature = null

						// remove the legend
						plugin_settings.map.legend.remove()

						// reset the map view
						map.setView(
							plugin_settings.map.defaults.coords,
							plugin_settings.map.defaults.zoom
						)

						// close popups
						map.closePopup()

						// hide epicenter
						plugin_settings.map.panes.epicenter.style.display = 'none'

						// show markers
						plugin_settings.map.panes.markers.style.display = ''

						// reset interface atts
						$('body').attr('data-sidebar-width', '')
						$('.app-main').attr('data-mode', '')
						$('.app-main').removeClass('indicator-selected')

						// disable chart toggle
						$('#chart-togglebox').togglebox('disable')

						// reset chart data
						$('.chart-container').attr('data-series', '')

						// reset the last_zoom flag
						plugin_settings.map.last_zoom = -1

						// empty the current scenario object
						plugin_settings.scenario = {}

						// empty the indicator object
						plugin_settings.indicator = {}

						// reset the history state
						$(document).profiler('do_history')

					},
					success: function() {


					},
          complete: function() {
	          $('body').removeClass('spinner-on')
						$('#spinner-progress').text('')
          }
				})

			})

			// click the chart toggle

			$('#chart-toggle .togglebox').click(function() {

				if (!$(this).hasClass('disabled')) {

					if (plugin_settings.charts.enabled == true) {

						plugin_settings.charts.enabled = false

						$('.app-main').removeClass('charts-on')

					} else {

						plugin_settings.charts.enabled = true

						$('.app-main').addClass('charts-on')

						plugin.get_charts()

					}

				}

			})

			// click the 'retrofit' toggle

			$('#retrofit-toggle .togglebox').click(function() {
				if (!$(this).hasClass('disabled')) {

					if (plugin_settings.api.retrofit == 'b0') {
						plugin_settings.api.retrofit = 'r1'
						// $(this).find('span').text('on')
					} else {
						plugin_settings.api.retrofit = 'b0'
						// $(this).find('span').text('off')
					}

					map.closePopup()

					if (plugin_settings.current_view == 'detail') {
						plugin.get_layer()
					}

				}
			})

			//
			//
			//

			// check for hash


			// if (window.location.hash) {
			//
			// 	setTimeout(function() {
			//
			// 		var init_id = window.location.hash
			//
			// 		console.log(window.location.hash, $('body').find(init_id))
			//
			// 		$('body').find(init_id).trigger('click')
			//
			// 	}, 1000)
			//
			// }

    },

		set_scenario: function(fn_options) {

			var plugin = this
			//var plugin_item = this.item
			var plugin_settings = plugin.options
			//var plugin_elements = plugin_settings.elements

			var settings = $.extend(true, {}, fn_options)

		},

		set_indicator: function(indicator) {

			var plugin = this
			var plugin_settings = plugin.options

			plugin_settings.indicator = indicator

			// reset the previous agg
			plugin_settings.aggregation.previous = null

			// console.log(indicator)

			$('#retrofit-togglebox').togglebox('enable')

			if (indicator.retrofit == false) {
				$('#retrofit-togglebox').togglebox('disable')
			}

			plugin_settings.indicator.max = {
				csd: 0,
				s: 0
			}

		},

    item_select: function(fn_options) {

      var plugin = this
      //var plugin_item = this.item
      var plugin_settings = plugin.options
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

			// console.log('select', settings)

			$(document).profiler('do_history', '#' + settings.scenario.key)

			// selected polygon = clicked ID or null
			plugin_settings.map.selected_marker = settings.scenario.id

			// reset choropleth
			plugin_settings.map.markers.resetStyle()

			// reset sidebar
			$('.sidebar-item').removeClass('selected')

			if (settings.scenario != null) {

				plugin_settings.scenario = settings.scenario

				// console.log(plugin_settings.scenario)

				// select the marker

				settings.marker.setStyle({
					color: plugin_settings.colors.marker_select,
					fillColor: plugin_settings.colors.marker_select
				})

				// update the epicentre and display it
				plugin.set_epicenter()

				// select the sidebar item

				// console.log($('.sidebar-item[data-id="' + settings.scenario.id + '"]'))

				$('.sidebar-item[data-id="' + settings.scenario.id + '"]').addClass('selected')

				// get the bounding layer

				plugin.get_bounds({
					scenario: settings.scenario
				})

				plugin.do_breadcrumb('select')

				plugin_settings.current_view = 'select'

			}

    },

    item_detail: function(fn_options) {

      var plugin = this
      //var plugin_item = this.item
      var plugin_settings = plugin.options
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

			// console.log('detail', plugin_settings.scenario.key)

			// close the controls

			$('body').find('.control-toggle').removeClass('open')
			$('body').find('.app-sidebar-control').slideUp(200)

			// reset the sort/filter
			$('body').find('.controls-search input').val('')
			$('body').find('.sort-item').removeClass('selected').attr('data-sort-order', 'asc').first().addClass('selected')

			// set param values for initial view

			var detail_html

			// load the detail sidebar template

			$(document).profiler('get_sidebar', {
				url: plugin_settings.scenario.url,
				before: function() {

					$('#spinner-progress').text('Loading scenario')

					// $('body').attr('data-sidebar-width', 'half')
					$('.app-main').attr('data-mode', 'scenario-detail')

				},
				success: function(data) {

					// console.log('detail', 'success')

					plugin_settings.current_view = 'detail'
					plugin_settings.map.last_zoom = -1

					// empty the bbox pane
					plugin_settings.map.object.removeLayer(plugin_settings.map.layers.bbox)
					plugin_settings.map.panes.bbox.style.display = 'none'

					// find the first indicator item in the template and set it as the current indicator

					plugin.set_indicator(JSON.parse($('.app-sidebar-content').find('.indicator-item').first().attr('data-indicator')))

					// update the epicentre and display it
					plugin.set_epicenter()

					// hide the markers pane
					plugin_settings.map.panes.markers.style.display = 'none'

					plugin.do_breadcrumb('detail')

					// get ready to call the API

					plugin.get_layer()

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

					$('.app-breadcrumb .breadcrumb').find('#breadcrumb-scenario-name').text(plugin_settings.scenario.title)

				}
			})


    },

		get_bounds: function(fn_options) {

      var plugin = this
      var plugin_settings = plugin.options

      var settings = $.extend(true, {
				scenario: null
			}, fn_options)

			var map = plugin_settings.map.object

			// console.log('bounds', settings.scenario)

			if (settings.scenario != null) {

				// spinner
				$('body').addClass('spinner-on')
				$('#spinner-progress').text('Loading scenario data')

				plugin_settings.map.panes.bbox.style.display = ''

				$.ajax({
					url: 'https://geo-api.riskprofiler.ca/collections/opendrr_shakemap_scenario_extents/items/' + settings.scenario.key,
					data: {
						f: 'json'
					},
					dataType: 'json',
					success: function(bounds) {

						// remove existing

						if (map.hasLayer(plugin_settings.map.layers.bbox)) map.removeLayer(plugin_settings.map.layers.bbox)

						plugin_settings.map.layers.bbox = L.geoJSON(bounds, {
							style: {
								fillColor: '#d90429',
								fillOpacity: 0.2,
								weight: 0
							},
							pane: 'bbox'
						}).addTo(map)

						map.fitBounds(
							plugin_settings.map.layers.bbox.getBounds(),
							{
								paddingTopLeft: [$(window).outerWidth() / 4, 0]
							}
						)

					}
				})

				// spinner
				$('body').removeClass('spinner-on')
				$('#spinner-progress').text('')

			}

		},

		get_layer: function(fn_options) {

      var plugin = this
      var plugin_settings = plugin.options

      var settings = $.extend(true, {
				event: null
			}, fn_options)

			// console.log('prep', plugin_settings.indicator.key)

      var fetch = false

			if (plugin_settings.scenario == {}) {

				console.log('error: no scenario set')

			} else if (plugin_settings.indicator == {}) {

				console.log('error: no indicator set')

			} else {

				// console.log('get layer', plugin_settings.scenario.key, plugin_settings.indicator.key)

				// close the popup
				plugin_settings.map.object.closePopup()

				// prep_for_api fn moved here

				// go through the aggregation settings
				// to find the right keys
	      // for the current indicator and zoom level

	      var agg_key = 'default'

	      if (plugin_settings.indicator.key == 'sH_PGA') {

					agg_key = 'shake'

					$('.app-main').removeClass('indicator-selected')
					$('#chart-togglebox').togglebox('disable')

	      } else {

					$('.app-main').addClass('indicator-selected')
					$('#chart-togglebox').togglebox('enable')

					// get charts

					if (
						plugin_settings.charts.enabled == true &&
						plugin_settings.indicator.key !== 'sH_PGA'
					) {
						plugin.get_charts()
					}

				}

	      plugin_settings.aggregation.settings[agg_key].forEach(function (i) {

	        // console.log('checking ' + plugin_settings.map.current_zoom + ' vs ' + i.min + ', ' + i.max )

	        if (
	          plugin_settings.map.current_zoom >= i.min &&
	          plugin_settings.map.current_zoom <= i.max
	        ) {

	          // found the agg settings that match the zoom level

	          if (plugin_settings.aggregation.current.agg != i.agg) {

	            // agg settings doesn't match the plugin's current aggregation

	            plugin_settings.aggregation.current = i

	          }

	        }

	      })

	      // conditions for fetching new data
	      // 1. zoom action changed the aggregation setting
	      // 2. previous aggregation is empty - initial load of scenario
	      // 3. current aggregation uses bbox

				// if (settings.event == 'zoomend') {
				// 	console.log('prev agg', plugin_settings.aggregation.previous)
				// 	console.log('new agg', plugin_settings.aggregation.current.agg)
				// }

	      if (
					settings.event == null ||
	        (
	          plugin_settings.aggregation.previous !== null &&
	          plugin_settings.aggregation.current.agg !== plugin_settings.aggregation.previous
	        ) ||
	        plugin_settings.aggregation.previous == null /*||
	        plugin_settings.aggregation.current.bbox == true*/
	      ) {

					// console.log('fetch')

	        // RESET MAP FEATURES

	        // reset legend max
	        plugin_settings.legend.max = 0

	        // UPDATE PARAMS

	        // fetch new data
	        fetch = true

	      }

	      if (fetch == true) {

					// spinner
					$('body').addClass('spinner-on')

					// console.log('get max vals now')
					plugin.get_max_vals()

	      }

			}



		},

		get_max_vals: function() {

      var plugin = this
      var plugin_settings = plugin.options
			var map = plugin_settings.map.object

			$('#spinner-progress').text('Retrieving scenario data')

			// console.log('get max vals', plugin_settings.indicator.max)

			// set bounds by the scenario meta
      var bounds = L.latLngBounds(L.latLng(
				plugin_settings.scenario.bounds.sw_lat,
				plugin_settings.scenario.bounds.sw_lng
			), L.latLng(
				plugin_settings.scenario.bounds.ne_lat,
				plugin_settings.scenario.bounds.ne_lng
			))

			var pbf_key = 'dsra_'
				+ plugin_settings.scenario.key.toLowerCase() + '_indicators_',
					indicator_key = plugin_settings.indicator.key + '_b0',
					aggregation = plugin_settings.aggregation.current,
					feature_ID_key = aggregation.prop


			if (plugin_settings.indicator.key !== 'sH_PGA') {

				// if max values for this indicator have not been generated
				// OR
				// we're swapping between aggregations

				if (
					plugin_settings.indicator.max.csd == 0 &&
					plugin_settings.indicator.max.s == 0
				) {

					// console.log('maxes are 0, get new ones')

					// get the csd max

					csd_temp = L.vectorGrid.protobuf(
						pbf_url + '/' + pbf_key + 'csd/EPSG_900913/{z}/{x}/{y}.pbf',
						{
							rendererFactory: L.canvas.tile,
							interactive: false,
				      getFeatureId: function(feature) {

								if (feature.properties[indicator_key] > plugin_settings.indicator.max.csd) {
									plugin_settings.indicator.max.csd = feature.properties[indicator_key]
								}

				        return feature.properties[feature_ID_key]
				      },
							bounds: bounds
						}
					).on('load', function() {

						// get the s max

						s_temp = L.vectorGrid.protobuf(
							pbf_url + '/' + pbf_key + 's/EPSG_900913/{z}/{x}/{y}.pbf',
							{
								rendererFactory: L.canvas.tile,
								interactive: false,
					      getFeatureId: function(feature) {

									if (feature.properties[indicator_key] > plugin_settings.indicator.max.s) {
										plugin_settings.indicator.max.s = feature.properties[indicator_key]
									}

					        return feature.properties[feature_ID_key]
					      },
								bounds: bounds
							}
						).on('load', function() {

							console.log('calculated max values', plugin_settings.indicator.max)

							$('#spinner-progress').text('Loading visualization')

							plugin.get_tiles()

						}).addTo(map)

					}).addTo(map)

				} else {

					// console.log('max exists', csd_max, s_max)

					// already have max vals
					plugin.get_tiles()

				}

			} else {

				// console.log('shake, get tiles now')
				plugin.get_tiles()

			}
		},

		get_tiles: function(fn_options) {

			// console.log('get tiles')

      var plugin = this
      var plugin_settings = plugin.options
			var map = plugin_settings.map.object

      var settings = $.extend(true, {}, fn_options)

			// close popups

			plugin_settings.map.object.closePopup()

			// remove existing layers

			if (map.hasLayer(csd_temp)) map.removeLayer(csd_temp)
			if (map.hasLayer(s_temp)) map.removeLayer(s_temp)
			// if (map.hasLayer(plugin_settings.map.layers.tiles)) map.removeLayer(plugin_settings.map.layers.tiles)

			// show the data pane

			plugin_settings.map.panes.data.style.display = ''

			// set bounds by the scenario meta

      var bounds = L.latLngBounds(L.latLng(
				plugin_settings.scenario.bounds.sw_lat,
				plugin_settings.scenario.bounds.sw_lng
			), L.latLng(
				plugin_settings.scenario.bounds.ne_lat,
				plugin_settings.scenario.bounds.ne_lng
			))

			// set tile vars

			var	indicator_key = plugin_settings.indicator.key,
					aggregation = plugin_settings.aggregation.current,
					feature_ID_key

			// get the max val for this aggregation

			var max_val = plugin_settings.indicator.max[aggregation.agg]

			var tile_url = {
				collection: 'dsra_' + plugin_settings.scenario.key.toLowerCase() + '_',
				aggregation: aggregation.agg,
				version: '1.4.0',
				projection: 'EPSG_900913'
			}

			// console.log('getting tiles now at ' + aggregation.agg + ' and max val ' + max_val)

			if (plugin_settings.indicator.key == 'sH_PGA') {

				// SHAKEMAP

				tile_url.collection += 'shakemap_hexbin'

				feature_ID_key = 'gridid_1'

				if (aggregation.agg == '5km') {
					feature_ID_key = 'gridid_5'
				}

				indicator_key += '_max'

			} else {

				// INDICATOR

				tile_url.collection += 'indicators'

				feature_ID_key = aggregation.prop

				indicator_key += ((plugin_settings.indicator.retrofit !== false) ? '_' + plugin_settings.api.retrofit : '')

			}

			z = 0

			// figure out what to do with the color ramp

			plugin_settings.legend.grades = []

			if (plugin_settings.indicator.legend.values) {

				// if the indicator has custom legend scales,
				// use that for the current aggregation

				plugin_settings.legend.grades = plugin_settings.indicator.legend.values[plugin_settings.aggregation.current.agg]

				// console.log('custom grades', plugin_settings.legend.grades)

			} else {

				// use the calculated max value to generate the ramp

				var legend_steps = 20,
						legend_step = 0

				legend_step = max_val / legend_steps

				for (i = 1; i <= legend_steps; i += 1) {
					plugin_settings.legend.grades.unshift(max_val - (legend_step * i))
				}

				// console.log('calculated grades', plugin_settings.legend.grades)

			}

			// get the selected color ramp array

			color_ramp = plugin_settings.legend.colors[plugin_settings.indicator.legend.color]

			// match up the lengths of the grade and color array

			if (color_ramp.length > plugin_settings.legend.grades.length) {

				var new_ramp = [ color_ramp[0] ]

				var length_mismatch = (color_ramp.length - 2) / (plugin_settings.legend.grades.length - 2)

				for (i = 0; i < color_ramp.length - 2; i += length_mismatch) {
					// console.log(i, Math.floor(i + length_mismatch), color_ramp[Math.floor(i + length_mismatch)])
					new_ramp.push(color_ramp[Math.floor(i + length_mismatch)])
				}

				new_ramp.push(color_ramp[color_ramp.length - 1])

				color_ramp = new_ramp

			}

			$(document).profiler('get_tiles', {
				map: map,
				url: tile_url,
				indicator: plugin_settings.indicator,
				aggregation: plugin_settings.aggregation,
				tiles: plugin_settings.map.layers.tiles,
				options: {
					pane: 'data',
		      getFeatureId: function(feature) {
		        return feature.properties[feature_ID_key]
		      },
					bounds: bounds,
		      vectorTileLayerStyles: plugin.choro_style(tile_url.collection + '_' + aggregation.agg, indicator_key)
				},
				functions: {
					add: function(e) {

						// set the tile var to the new layer that was created
						plugin_settings.map.layers.tiles = e.target

						plugin_settings.map.legend.addTo(plugin_settings.map.object)

						$('body').find('.legend-item').tooltip()

						// update breadcrumb

						$('.app-breadcrumb').find('#breadcrumb-scenario-indicator').text(plugin_settings.indicator.label)

					},
					mouseover: function(e) {

						if (!$('.app-main').hasClass('feature-selected')) {

							// set the popup content

							plugin_settings.map.popup.setContent(plugin.popup_content(e.layer.properties, indicator_key))
				        .setLatLng(e.latlng)
				        .openOn(map)

						}

					},
					mouseout: function(e) {

						if (!$('.app-main').hasClass('feature-selected')) {
							map.closePopup()
						}

					},
					click: function(e) {

						L.DomEvent.stop(e)

		        // if we have a selected feature, reset the style
		        if (plugin_settings.map.selected_feature != null) {
		          plugin_settings.map.layers.tiles.resetFeatureStyle(plugin_settings.map.selected_feature)
		        }

						$('.app-main').addClass('feature-selected')

		        // set the selected feature id
		        plugin_settings.map.selected_feature = e.layer.properties[feature_ID_key]

		        // set the selected feature style
		        plugin_settings.map.layers.tiles.setFeatureStyle(plugin_settings.map.selected_feature, {
		          fill: true,
							fillColor: '#9595a0',
							color: '#2b2c42',
		          weight: 0.8,
		          fillOpacity: 0.5
		        })

		        // set the popup content
		        plugin_settings.map.popup.setContent(plugin.popup_content(e.layer.properties, indicator_key))
			        .setLatLng(e.latlng)
			        .openOn(map)

						// update charts if necessary

						if (
							plugin_settings.charts.enabled == true &&
							plugin_settings.indicator.key !== 'sH_PGA'
						) {
							plugin.get_charts()
						}

					}
				}
			})

			$('body').removeClass('spinner-on')

		},

		choro_style: function(pbf_key, indicator_key) {

			var plugin = this
			var plugin_settings = plugin.options

			var layer_style = {},
					fillColor

			layer_style[pbf_key] = function(properties) {

				var rounded_val = plugin._round(properties[indicator_key], plugin_settings.indicator.aggregation[plugin_settings.aggregation.current.agg]['rounding'])

				return {
					fill: true,
					fillColor: plugin._choro_color(rounded_val),
					fillOpacity: 0.9,
					color: '#000000',
					opacity: 0.6,
					weight: (indicator_key == 'sH_PGA_max') ? 0 : 0.2
				}
			}

			return layer_style
		},

		set_epicenter: function() {

      var plugin = this
      var plugin_settings = plugin.options

			var marker_coords = new L.LatLng(plugin_settings.scenario.coords.lat, plugin_settings.scenario.coords.lng)

			plugin_settings.map.epicenter.setLatLng(marker_coords)

			plugin_settings.map.panes.epicenter.style.display = ''

		},

		_choro_color: function(d) {

      var plugin = this
      var plugin_settings = plugin.options

			var rounding = plugin_settings.indicator.aggregation[plugin_settings.aggregation.current.agg]['rounding']

			var grades = plugin_settings.legend.grades

			// default to the lightest color
			var this_color = color_ramp[0]

			// go through each grade
			for (i = 0; i < grades.length; i += 1) {

				// if the value is greater than grade[i],
				// update this_color to the corresponding value in the color_ramp array

				if (d >= grades[i] * Math.pow(10, rounding)) {
					this_color = color_ramp[i]
				}

			}

			return this_color

		},

		popup_content: function(properties, indicator_key) {

      var plugin = this
      var plugin_settings = plugin.options

			var indicator = plugin_settings.indicator,
					current_agg = plugin_settings.aggregation.current.agg,
					aggregation = indicator.aggregation[current_agg]

			var rounded_val

			if (indicator.type == 'dollars') {

				rounded_val = plugin._round_scale(properties[indicator_key])

			} else {

				rounded_val = plugin._round(properties[indicator_key], aggregation['rounding']).toLocaleString(undefined, { maximumFractionDigits: aggregation['decimals'] })

				if (aggregation['rounding'] == -9) {
					rounded_val += ' billion'
				} else if (aggregation['rounding'] == -6) {
					rounded_val += ' million'
				}

			}

			return '<p>'
				+ indicator.legend.prepend
				+ rounded_val
				+ ' '
				+ indicator.legend.append
				+ '</p>'
				// + '<p>Real value: ' + e.layer.properties[indicator_key] + '</p>'

		},

		do_breadcrumb: function(fn_options) {

			var plugin = this
			//var plugin_item = this.item
			var plugin_settings = plugin.options
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

		get_charts: function(fn_options) {

			// console.log('get charts')

			var plugin = this
			var plugin_settings = plugin.options

			var settings = $.extend(true, {
				reset: false
			}, fn_options)

			// each chart

			plugin_settings.charts.elements.forEach(function(request, i) {

				if (
					settings.reset == true &&
					$('#chart-' + request.field).attr('data-series') !== ''
				) {

					// if we're resetting, use the series attribute
					// instead of running the ajax call again

					// console.log('RESET', request.object.series)

					var series = JSON.parse($('#chart-' + request.field).attr('data-series'))

					if (request.object.series.length) {

						request.object.series.forEach(function(existing_col, i) {

							var this_name = existing_col.name,
									this_data = [0]

							if (series[this_name]) {
								this_data = series[this_name]
							}

							existing_col.setData(this_data)

						})

					}

				} else {

					// create new request

					var request_data = {
						"aggs": {
							"0": {
								"terms": {
									"field": 'properties.' + request.field + '.keyword',
									"order": {
										"1": "desc"
									},
									"size": request.size
								},
								"aggs": {
									"1": {
										"sum": {
											"field": "properties." + plugin_settings.indicator.key.replace('t_', '_') + '_' + plugin_settings.api.retrofit
										}
									}
								}
							}
						},
						"size": 0,
						"fields": [],
						"script_fields": {},
						"stored_fields": [
							"*"
						],
						"runtime_mappings": {},
						"_source": {
							"excludes": []
						},
						"query": {
							"bool": {
								"must": [],
								"filter": [],
								"should": [],
								"must_not": []
							}
						}
					}

					if (plugin_settings.map.selected_feature != null) {

						var match_phrase = {}

						match_phrase['properties.' + plugin_settings.aggregation.current.prop + '.keyword'] = plugin_settings.map.selected_feature

						request_data['query'] = {
					    "bool": {
					      "must": [],
					      "filter": [
					        {
					          "bool": {
					            "should": [
					              {
					                "match_phrase": match_phrase
					              }
					            ],
					            "minimum_should_match": 1
					          }
					        }
					      ],
					      "should": [],
					      "must_not": []
					    }
					  }

					}

					if (plugin_settings.api.bbox != null) {

						console.log('add bbox to chart request')

						var b = plugin_settings.map.object.getBounds(),
								b1 = {
									"tllat": b.getNorthWest().lat > 90 ? 90 : b.getNorthWest().lat,
									"tllon": b.getNorthWest().lng < -180 ? -180 : b.getNorthWest().lng,
									"brlat": b.getSouthEast().lat < -90 ? -90 : b.getSouthEast().lat,
									"brlon": b.getSouthEast().lng > 180 ? 180 : b.getSouthEast().lng
								}

						request_data.aggs['my_applicable_filters'] = {
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
							}
						}

					}

					$.ajax({
						method: 'POST',
						tryCount : 0,
						retryLimit : 3,
						crossDomain: true,
						headers: { "content-type": "application/json" },
						url: api_url + '/opendrr_dsra_' + plugin_settings.scenario.key.toLowerCase() + '_indicators_b_v' + plugin_settings.api.version + '/_search',
						data: JSON.stringify(request_data),
						success: function(data) {

							// if (request.field == 'E_BldgTypeG') {
							// 	console.log('request', JSON.stringify(request_data))
							// 	console.log('return', data)
							// }

							request.columns.forEach(function(column) {
								column.value = [0]
							})

							// map the data to its column in the charts object

							data.aggregations[0].buckets.forEach(function(item) {

								request.columns.forEach(function(column) {

									// find the column that matches this item key

									if (column.code == item.key) {
										column.value = [ item[1]['value'] ]
									}

								})

							})

							if (request.object.series.length) {

								// update the existing series

								request.object.series.forEach(function(existing_col, i) {

									var this_name = existing_col.name

									request.columns.every(column => {

										if (column.code == existing_col.name) {

											// console.log(column.code, column.value)

											existing_col.setData(column.value)

											return false

										}

										return true

									})

								})

							}

						}
					})

				} // if reset

			}) // each chart element

		},

		_round: function(num, power) {
			return num * Math.pow(10, power)
		},

		_round_scale: function(num) {

			var plugin = this,
					rounded_num

			// round the number to the given power
			// shorten to 2 decimal places
			// remove decimal places if equal to .00

			if (num >= 1000000000) {
				rounded_num = plugin._round(num, -9).toFixed(2).replace(/[.,]00$/, '') + ' billion'
			} else if (num >= 100000) {
				rounded_num = plugin._round(num, -6).toFixed(2).replace(/[.,]00$/, '') + ' million'
			} else {
				rounded_num = num.toLocaleString('en-CA', {
					maximumFractionDigits: 0
				})
			}

			return rounded_num

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
