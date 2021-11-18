scenarioProp = 'sCt_Res90_b0'

function getColor( d ) {
		return d > 300  ? '#ff3b00' :
				d > 100   ? '#ff6500' :
						d > 50   ? '#ff9000' :
								d > 10   ? '#ffba00' :
										'#fff176';
}

function featureStyle( feature ) {
		return {
				fillColor: getColor( feature.properties[ scenarioProp ] ),
				weight: 0.6,
				fillOpacity: 0.7,
				color: '#4b4d4d',
				opacity: 1
		};
}

function selectedStyle( feature ) {
		return {
				fillColor: 'blue',
				color: 'black',
				weight: 1,
				fillOpacity: 0.5
		};
}

// scenario profiler
// v1.0

(function ($) {

  // custom select class

  function rp_scenarios(item, options) {

    // options

    var defaults = {
			api: {
				baseURL: "https://geo-api.stage.riskprofiler.ca/collections/opendrr_dsra_",
				featureProperties: 'csduid,sCt_Res90_b0', // Limit fetched properties for performance
				scenarioProp: 'sCt_Res90_b0', // Property for popup and feature colour
				limit: 10,
				featureURL: null
			},
			map: {
				object: null,
				legend: null,
				offset: $('.app-sidebar').outerWidth(),
				geojson: null,
				markers: null,
				selected_marker: null,
				geojsonLayer: null,
				lastZoom: -1
			},
			colors: {
				shape: '#9595a0',
				shape_hover: '#b6b6bf',
				shape_select: '#2b2c42'
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

	    plugin_settings.map.object = L.map('map', {
				zoomControl: false
			}).setView([55,-105], 4)

			plugin_settings.map.object.on('fullscreenchange', function () {
				plugin_settings.map.object.invalidateSize()
			})

			L.control.zoom({
				position: 'bottomleft'
			}).addTo(plugin_settings.map.object);

			plugin_settings.map.object.createPane('basemap')
			plugin_settings.map.object.getPane('basemap').style.zIndex = 399
			plugin_settings.map.object.getPane('basemap').style.pointerEvents = 'none'

			plugin_settings.map.object.createPane('markers')
			plugin_settings.map.object.getPane('markers').style.zIndex = 600
			plugin_settings.map.object.getPane('markers').style.pointerEvents = 'all'

			// LEGEND

			plugin_settings.map.legend = L.control( { position: 'bottomright' } )

			plugin_settings.map.legend.onAdd = function ( map ) {

					var div = L.DomUtil.create('div', 'info legend'),
							grades = [0, 10, 50, 100, 300],
							label = ' People Displaced';

					div.innerHTML = "<div style=\"padding: 3px;\"><b>People displaced after 90 days</b></div>";

					// loop through our density intervals and generate a label with a colored square for each interval
					for (var i = 0; i < grades.length; i++ ) {
							div.innerHTML +=
									'<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
									grades[i] + ( grades[i + 1] ? '&ndash;' + grades[i + 1] + label + '<br>' : '+' + label);
					}

					return div;
			};

			// BASEMAP

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					pane: 'basemap',
			    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(plugin_settings.map.object)

			// layer for choropleth

			var selection

			plugin_settings.map.geojsonLayer = L.geoJSON([], {
				style: featureStyle,
				onEachFeature: function(feature, layer) {

          layer.bindPopup( function ( e ) {
              return L.Util.template( '<p>Residents displaced after 90 days: <strong>' + e.feature.properties.sCt_Res90_b0.toLocaleString( undefined, { maximumFractionDigits: 0 }) + '</strong></p>' );
          }).on({
              click: function( e ) {
                  if ( selection ) {
                      // reset style of previously selected feature
                      selection.setStyle(featureStyle(selection.feature));
                      $( '#sidebar' ).html( '' );
                  }
                  selection = e.target;
                  selection.setStyle(selectedStyle());

                  // Get geoJSON of selected feature
                  $.ajax({
                      method: "GET",
                      tryCount : 0,
                      retryLimit : 3,
                      crossDomain: true,
                      url: plugin_settings.api.featureURL +  selection.feature.id,
                      headers: { "content-type": "application/json" }
                  })

                      // Displays properties of selection in a table
                      .done( function ( resp ) {

                          let props = resp.properties,
                              string = '<table class="table table-striped table-responsive"><tr>';

                          counter = 1; // Counts number of cells in table row

                          for ( const key in props ) {

                              mod_key = key; // Key with _b0, _r1, _le ending must be modified
                              mod = '';

                              if ( key.slice( -3 ) === '_b0' ) {
                                  mod_key = key.slice( 0, -3 );
                                  mod = ' (Baseline)';
                              }
                              else if ( key.slice( -3 ) === '_r1' ) {
                                  mod_key = key.slice( 0, -3 );
                                  mod = ' (Retrofit)';
                              }
                              else if ( key.slice( -3 ) === '_le' ) {
                                  mod_key = key.slice( 0, -3 );
                                  mod = ' (Seismic Upgrade)';
                              }

                              desc = window[ mod_key + 'Desc' ];
                              detail = window[ mod_key + 'Detail' ];
                              format = window[ mod_key + 'Format' ];
                              value = props[ key ];

                              if ( format && value ) { // Format values with set formatting
                                  if ( format === 444 ) {
                                      value = value.toLocaleString( undefined, {style:'currency', currency:'USD'});
                                  }
                                  else if ( format === 111 ) {
                                      value = value.toLocaleString( undefined, { maximumFractionDigits: 0 })
                                  }
                                  else if ( format === 555 ) {
                                      value *= 100
                                      value = value.toLocaleString( undefined, { maximumFractionDigits: 2 });
                                      value += '%';
                                  }
                                  else if ( format < 0 ) {
                                      mult = Math.abs(format);
                                      rounded = Math.round( value / ( 10 ** mult )) * 10 ** mult;
                                      value = rounded.toLocaleString( undefined);
                                  }
                                  else if ( format > 0 ) {
                                      value = value.toLocaleString( undefined, { maximumFractionDigits: format });
                                  }

                                  string +=
                                      '<td class="attr"><div class="prop" title="' + detail + '">' + desc + mod + '</div><div class="val">' + value + '</div></td>';
                              }
                              // Leaflet info not displayed
                              else if ( key === 'OBJECTID' || key === 'SHAPE_Length' || key === 'SHAPE_Area' || key === 'geom_poly' || key === 'geom' ) {
                              }
                              else if ( desc ) { // For properties with descriptions but null values
                                  string +=
                                      '<td class="attr"><div class="prop" title="' + detail + '">' + desc + mod + '</div><div class="val">' + value + '</div></td>';
                              }
                              else { // Properties with no descriptions
                                  string +=
                                      '<td class="attr"><div class="prop">' + key + '</div><div class="val">' + value + '</div></td>';
                              }
                              if ( counter % 3 === 0 ) {
                                  string += '</tr><tr>';
                              }
                              counter++;
                          }
                          string += '</tr></table>';
                          // Add table to sidebar div
                          $( '#sidebar' ).html( '<h3>Properties of Selected Feature</h3>' + string );
                      })

                      .fail( function ( error ) {
                          this.tryCount++;
                          if ( this.tryCount <= this.retryLimit ) {
                              //try again
                              $.ajax( this );
                              return;
                          }
                          console.log( "Doh! " + error )
                          return;

                      });
              }
          })

        }
			}).addTo( plugin_settings.map.object );

			// CONTROLS



			// CLUSTERS

			plugin_settings.map.clusters = L.markerClusterGroup({
				animateAddingMarkers: true,
				iconCreateFunction: function (cluster) {
					var markers = cluster.getAllChildMarkers();

					var n = 0

					for (var i = 0; i < markers.length; i++) {

						console.log(markers[i])

						n += 1//markers[i].number;
					}

					return L.divIcon({ html: n, className: 'scenario-cluster', iconSize: L.point(40, 40) });
				},
			});

			// GEOJSON

			plugin_settings.map.geojson = [{
		    "type": "FeatureCollection",
		    "features": [
		      {
						"type": "Feature",
            "properties": {
							id: 1,
							name: 'Leech River Full Fault',
							scenario: 'ACM7p3_LeechRiverFullFault'
            },
            "geometry": {
              "type": "Point",
              "coordinates": [-85, 50.2]
            }
					},
					{
						"type": "Feature",
            "properties": {
							id: 2,
							name: 'Sidney',
							scenario: 'IDM7p1_Sidney'
            },
            "geometry": {
              "type": "Point",
              "coordinates": [-94, 57]
            }
					}
				]
			}]

			plugin_settings.map.markers = L.geoJSON(plugin_settings.map.geojson, {
				onEachFeature: function(feature, layer) {

					console.log(feature, layer)

					if (typeof feature !== 'undefined') {

						layer
							.on('mouseover', function(e) {

								if (plugin_settings.map.selected_marker != feature.properties.id) {

									this.setStyle({
										'color': plugin_settings.colors.shape_hover,
										'fillColor': plugin_settings.colors.shape_hover
									})

								}

							})
							.on('mouseout', function() {

								// if already selected, do nothing
								// if another layer is selected, reset this one

								$('.sidebar-item').removeClass('hover')

								if (plugin_settings.map.selected_marker != feature.properties.id) {

									this.setStyle({
										'color': plugin_settings.colors.shape,
										'fillColor': plugin_settings.colors.shape
									})

								}

							})
							.on('click', function(e) {

								plugin_instance.item_select({
									item_id: feature.properties.id,
									scenario: feature.properties.scenario,
									marker: this
								})

							})
					}

				},
				pointToLayer: function (feature, latlng) {

					// console.log(feature, latlng)

					// var marker = L.marker(latlng, { title: 'test' });

					var marker = L.circleMarker(latlng, {
						pane: 'markers',
						radius: 5,
						fillColor: plugin_settings.colors.shape,
						weight: 0,
						opacity: 1,
						fillOpacity: 1
					})

					plugin_settings.map.clusters.addLayer(marker)

					return marker

				}
			}).addTo(plugin_settings.map.object)

			plugin_settings.map.object.addLayer(plugin_settings.map.clusters)

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

			$('body').on('click', '.sidebar-item .sidebar-button', function(e) {
				plugin_instance.item_detail($(this).closest('.sidebar-item').attr('data-scenario'))
			})

			$('body').on('click', '.sidebar-item', function(e) {

				var this_scenario = $(this).attr('data-scenario')

				plugin_settings.map.markers.resetStyle().eachLayer(function(layer) {

					if (this_scenario == layer.feature.properties.scenario) {

						plugin_instance.item_select({
							item_id: layer.feature.properties.id,
							scenario: this_scenario,
							marker: layer
						})

					}

				})
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
				item_id: null,
				scenario: null,
				marker: null,
				event: null
			}

			if (typeof fn_options == 'string') {
				defaults.scenario = fn_options
				fn_options = {}
			}

      var settings = $.extend(true, defaults, fn_options)

			console.log('scenarios', 'select', settings)

			// selected polygon = clicked ID or null
			plugin_settings.map.selected_marker = settings.scenario

			// reset choropleth
			plugin_settings.map.markers.resetStyle()

			// reset sidebar
			$('.sidebar-item').removeClass('selected')

			if (settings.scenario != null) {

				// select the marker

				settings.marker.setStyle({
					color: plugin_settings.colors.shape_select,
					fillColor: plugin_settings.colors.shape_select
				})

				// center the map on the marker

				$('body').profiler('_center_map', {
					map: plugin_settings.map.object,
					coords: settings.marker._latlng,
					offset: plugin_settings.map.offset
				})

				// select the sidebar item

				console.log($('.sidebar-item[data-scenario="' + settings.scenario + '"]'))

				$('.sidebar-item[data-scenario="' + settings.scenario + '"]').addClass('selected')

				// generate the choropleth

				plugin_instance.get_scenario({
					scenario: settings.scenario
				})

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

    get_scenario: function(fn_options) {

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

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

			console.log('scenario', 'get', settings.scenario)

			if (settings.scenario != null) {

				settings.scenario = settings.scenario.toLowerCase(); // API uses lowercase

				geojsonUrl = plugin_settings.api.baseURL + settings.scenario
					+ "_indicators_csd/items?lang=en_US&f=json"
					+ "&limit=" + plugin_settings.api.limit
					+ '&properties=' + plugin_settings.api.featureProperties

				console.log(geojsonUrl)

				plugin_settings.api.featureURL = plugin_settings.api.baseURL + settings.scenario + "_indicators_csd/items/"

				// Turn scenario name into a title
				end = settings.scenario.split( '_' )[ 1 ];
				title = '';

				for ( let char of end ) {
					// Add space before uppercase letters
					if ( char == char.toUpperCase() ) {
						title += ' ' + char;
					}

					// Leave lowercase as is
					else {
						title += char;
					}
				}

				mag = settings.scenario[ 3 ] + '.' + settings.scenario[ 5 ];
				full_name = title + ' - Magnitude ' + mag;

				// Replace generic title with scenario name
				$( '#wb-cont' ).html( full_name );
				console.log(full_name)

				// Add progress modal to map before fetching geoJSON
				// $( '#map' ).before( '<div id="modal"></div>' );

				$('body').addClass('spinner-on')

				plugin_instance.getData( geojsonUrl );

				plugin_settings.map.object.on( 'zoomend dragend', function ( e ) {

						zoom = e.target.getZoom();

						if ( zoom > 10 ) {

								// $( '#sidebar' ).html( '' );
								plugin_settings.map.geojsonLayer.clearLayers();

								var bounds = plugin_settings.map.object.getBounds(),
										bbox = [
												bounds.getSouthWest().lng,
												bounds.getSouthWest().lat,
												bounds.getNorthEast().lng,
												bounds.getNorthEast().lat,
										];

								plugin_settings.api.limit = 500;
								plugin_settings.api.featureProperties = 'Sauid,sCt_Res90_b0';

								geojsonUrl = plugin_settings.api.baseURL + settings.scenario
									+ "_indicators_s/items?"
									+ "&limit=" + plugin_settings.api.limit
									+ '&properties=' + plugin_settings.api.featureProperties
									+ '&bbox=' + bbox

								plugin_settings.api.featureURL = plugin_settings.api.baseURL + settings.scenario + "_indicators_s/items/"

								// $( '#map' ).before( '<div id="modal"></div>' );
								plugin_instance.getData( geojsonUrl );

						} else if ( plugin_settings.map.lastZoom > 10 ) {

								// $( '#sidebar' ).html( '' );
								plugin_settings.map.geojsonLayer.clearLayers();

								plugin_settings.api.limit = 10;
								plugin_settings.api.featureProperties = 'csduid,sCt_Res90_b0';

								geojsonUrl = plugin_settings.api.baseURL + settings.scenario
									+ "_indicators_csd/items?lang=en_US&f=json"
									+ "&limit=" + plugin_settings.api.limit
									+ '&properties=' + plugin_settings.api.featureProperties

								plugin_settings.api.featureURL = plugin_settings.api.baseURL + settings.scenario + "_indicators_csd/items/"

								// $( '#map' ).before( '<div id="modal"></div>' );
								plugin_instance.getData( geojsonUrl );

						}

						plugin_settings.map.lastZoom = zoom;

				});

			}

		},

		getData: function( url ) {

      var plugin_instance = this
      var plugin_item = this.item
      var plugin_settings = plugin_instance.options
      var plugin_elements = plugin_settings.elements

			var nxt_lnk;

			$.getJSON( url, function ( data ) {

				plugin_settings.map.geojsonLayer.addData( data );

				for ( var l in data.links ) {
						lnk = data.links[ l ];
						if ( lnk.rel == 'next' ) {
								nxt_lnk = lnk.href;
								break;
						}
				}

				// if next link continue loading data
				if ( nxt_lnk ) {
					plugin_instance.getData( nxt_lnk );
				} else {
						// set map bounds to frame loaded features on first load
						if ( plugin_settings.map.lastZoom == -1 ) {
								plugin_settings.map.object.fitBounds(plugin_settings.map.geojsonLayer.getBounds());
						}
						// done with paging so remove progress
						// $( '#modal' ).remove();
						$('body').removeClass('spinner-on')
						// Add legend
						plugin_settings.map.legend.addTo( plugin_settings.map.object );
				}
			})
			.fail( function ( jqXHR, error ) {
					$( '#alert' ).show();
					// $( '#modal' ).remove();
					$('body').removeClass('spinner-on')
					// $( '#scenarios' ).show();
			});

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
