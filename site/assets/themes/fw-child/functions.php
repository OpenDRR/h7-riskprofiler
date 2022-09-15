<?php

//
// GLOBALS
//

function child_global_vars() {

	global $vars;
	global $classes;

  $query_string = $_GET;

  $vars['user_id'] = '';

  if ( is_user_logged_in() ) {

    $vars['user_id'] = get_current_user_id();

  }

	if ( is_page ( 'scenarios' ) || is_page ( 'risks' ) ) {

		$classes['body'][] = 'app-page';

	}

	$classes['body'][] = 'lang-' . apply_filters ( 'wpml_current_language', NULL );

}

add_action ( 'wp', 'child_global_vars', 20 );

//
// ENQUEUE
//

function child_theme_enqueue() {
	
  $theme_dir = get_bloginfo ( 'template_directory' ) . '/';
  $vendor_dir = $theme_dir . 'resources/vendor/';
  $js_dir = $theme_dir . 'resources/js/';

  $child_theme_dir = get_stylesheet_directory_uri() . '/';
  $child_vendor_dir = $child_theme_dir . 'resources/vendor/';
  $child_js_dir = $child_theme_dir . 'resources/js/';

  //
  // STYLES
  //
	
	// dequeue global CSS
	
	wp_dequeue_style ( 'global-styles' );
	
	wp_dequeue_style ( 'global-style' );
	
	if ( is_page ( 'scenarios' ) || is_page ( 'risks' ) ) {
	
		wp_enqueue_style ( 'leaflet', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css', null, '1.7.1', 'all' );
	
		wp_enqueue_style ( 'leaflet-cluster', $child_theme_dir . 'resources/vendor/Leaflet.markercluster-1.4.1/dist/MarkerCluster.css', null, null, 'all' );
	
		wp_enqueue_style ( 'leaflet-cluster-default', $child_theme_dir . 'resources/vendor/Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css', null, null, 'all' );
	
		wp_enqueue_style ( 'leaflet-pulse', $child_theme_dir . 'resources/vendor/leaflet-icon-pulse/dist/L.Icon.Pulse.css', null, null, 'all' );
	
		wp_enqueue_style ( 'highcharts', $child_theme_dir . 'resources/css/highcharts.css', null, null, 'all' );
	
	}
	
	wp_enqueue_style ( 'child-style', $child_theme_dir . 'style.css', null, null, 'all' );

  //
  // SCRIPTS
  //

  wp_register_script ( 'profiler', $child_js_dir . 'profiler.js', array ( 'leaflet' ), NULL, true );
	
	wp_register_script ( 'rp-scenarios', $child_js_dir . 'rp_scenarios.js', array ( 'profiler', 'highcharts', 'leaflet', 'leaflet-vector' ), NULL, true );
	
	$scenarios_translations = array (
		'by' => __( 'by', 'rp' ),
		'in' => __( 'in', 'rp' ),
		'building_type' => __( 'Building Type', 'rp' ),
		'design_level' => __( 'Design Level', 'rp' ),
		'occupancy_class' => __( 'Occupancy Class', 'rp' ),
		'crumb_select_marker' => __( 'Select a marker to retrieve data', 'rp' ),
		'crumb_scenario' => __( 'Scenario', 'rp' ),
		'crumb_scenario_detail' => __( 'Scenario Detail', 'rp' ),
	);
	
	wp_localize_script ( 'rp-scenarios', 'rp', $scenarios_translations );
	
	wp_register_script ( 'rp-risks', $child_js_dir . 'rp_risks.js', array ( 'profiler', 'highcharts', 'leaflet', 'leaflet-vector' ), NULL, true );
	
	wp_register_script ( 'child-functions', $child_js_dir . 'child-functions.js', array ( 'jquery', 'global-functions' ), NULL, true );
	
	// localize admin url
	
	wp_localize_script ( 'child-functions', 'admin_ajax_data',
		array (
			'url' => admin_url ( 'admin-ajax.php' )
		)
	);

  // VENDOR
	
	wp_register_script ( 'togglebox', $child_theme_dir . 'resources/vendor/pe-togglebox/togglebox.js', array ( 'jquery' ), true );

  wp_enqueue_script ( 'child-functions' );

  // PAGE CONDITIONALS
	
	if ( is_page ( 'scenarios' ) || is_page ( 'risks' ) ) {
	
		wp_enqueue_script ( 'leaflet', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', null, '1.7.1', true );
	
		wp_enqueue_script ( 'leaflet-vector', 'https://unpkg.com/leaflet.vectorgrid@latest/dist/Leaflet.VectorGrid.bundled.js', array ( 'leaflet' ), null, true );
	
		wp_enqueue_script ( 'togglebox' );
	
		wp_enqueue_script ( 'highcharts', $child_theme_dir . 'resources/vendor/Highcharts-9.3.3/code/highcharts.js',  null, null, true );
	
		wp_enqueue_script ( 'highcharts-export', $child_theme_dir . 'resources/vendor/Highcharts-9.3.3/code/modules/exporting.js',  null, null, true );
	
		wp_enqueue_script ( 'highcharts-export-data', $child_theme_dir . 'resources/vendor/Highcharts-9.3.3/code/modules/export-data.js',  null, null, true );
	
	}
	
	if ( is_page ( 'scenarios' ) ) {
	
		wp_enqueue_script ( 'leaflet-cluster', $child_theme_dir . 'resources/vendor/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster.js', array ( 'leaflet' ), '1.4.1', true );
	
		wp_enqueue_script ( 'leaflet-pulse', $child_theme_dir . 'resources/vendor/leaflet-icon-pulse/dist/L.Icon.Pulse.js', array ( 'leaflet' ), '1.4.1', true );
	
		wp_enqueue_script ( 'leaflet-heat', $child_theme_dir . 'resources/js/leaflet-heat.js', array ( 'leaflet' ), null, true );
	
		wp_enqueue_script ( 'spherical-mercator', $child_theme_dir . 'resources/js/sphericalmercator.js', array ( 'leaflet' ), null, true );
	
		wp_enqueue_script ( 'leaflet-geopackage', 'https://unpkg.com/@ngageoint/leaflet-geopackage@3.0.3/dist/leaflet-geopackage.min.js', array ( 'leaflet' ), null, true );
	
		wp_enqueue_script ( 'leaflet-vector', 'https://unpkg.com/leaflet.vectorgrid@latest/dist/Leaflet.VectorGrid.bundled.js', array ( 'leaflet' ), null, true );
	
		wp_enqueue_script ( 'rp-scenarios' );
	
	} elseif ( is_page ( 'risks' ) ) {
	
		wp_enqueue_script ( 'rp-risks' );
	
	}

}

add_action ( 'wp_enqueue_scripts', 'child_theme_enqueue', 50 );

//
// INCLUDES
//

$includes = array (
  'resources/functions/taxonomies.php',
  'resources/functions/post-types.php',
  'resources/functions/shortcodes.php'
);

foreach ( $includes as $include ) {

  if ( locate_template ( $include ) != '' ) {
    include_once ( locate_template ( $include ) );
  }

}

//
// THEME SETUP
//

function custom_theme_setup() {

	// DOCUMENT TITLE

	add_theme_support ( 'title-tag' );

	// PAGE EXCERPTS

	add_post_type_support ( 'page', 'excerpt' );

	// UNCROPPED IMAGE SIZE FOR CARD BLOCKS

	add_image_size ( 'card-img-no-crop', '600', '380', false );

	// MENUS

}

add_action ( 'after_setup_theme', 'custom_theme_setup', 0 );

//
// TEMPLATE HOOKS
//

function add_favicon() {

?>

<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/favicon-16x16.png">
<link rel="manifest" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<?php

}

add_action ( 'wp_head', 'add_favicon' );

//
// ADMIN STUFF
//

// DISABLE EDITOR

function remove_default_editor() {
	remove_post_type_support ( 'page', 'editor' );
}

add_action ( 'init', 'remove_default_editor' );

// DISABLE COMMENTS

add_action ( 'admin_menu', function() {
	remove_menu_page ( 'edit-comments.php' );
} );

add_action ( 'init', function() {

	remove_post_type_support ( 'post', 'comments' );
	remove_post_type_support ( 'page', 'comments' );

}, 100);

add_action ( 'wp_before_admin_bar_render', function() {

	global $wp_admin_bar;
	$wp_admin_bar->remove_menu ( 'comments' );

} );

add_action ( 'pre_get_posts', 'alter_query' );

function alter_query($query) {

	global $wp_query;

	if ( !$query->is_main_query() )
		return;

	if ( is_post_type_archive ( 'scenario' ) ) {

		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'asc' );

	} elseif ( is_post_type_archive ( 'community' ) ) {

		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'asc' );
		$query->set( 'posts_per_page', -1 );

	}

	remove_all_actions ( '__after_loop' );

}


//
// ACF ADMIN COLUMNS
//

function add_acf_columns ( $columns ) {
	return array_merge ( $columns, array (
		'indicator_key' => __ ( 'Key' ),
		'indicator_type' => __ ( 'Type' )
	) );
}

add_filter ( 'manage_indicator_posts_columns', 'add_acf_columns' );

function indicator_custom_column ( $column, $post_id ) {
	switch ( $column ) {

		case 'indicator_key':
			echo get_post_meta ( $post_id, 'indicator_key', true );
			break;

		case 'indicator_type':
			echo get_post_meta ( $post_id, 'indicator_type', true );
			break;

	}
}
add_action ( 'manage_indicator_posts_custom_column', 'indicator_custom_column', 10, 2 );

function update_max_vals() {

	if ( is_page ( 'contact-us' ) ) {

		$maxes = array (

			'sH_' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 9
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 7
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 7.3
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 7.1
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 7.5
	),
),

'sH_Hypo' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 48.25
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 49.2428
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 48.405
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 48.62
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 45.904
	),
),

'sH_HypoDe' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 15
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 3
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 7.5
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 60
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 21
	),
),

'sH_V' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 900
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 900
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 900
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 900
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 900
	),
),

'sH_z' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 507.797676
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 507.797676
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 507.797676
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 507.797676
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 495.900789
	),
),

'sH_Sa' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 1.162057
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 1.053204
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 1.40767
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 0.575957
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 3.280751
	),
),

'sDt_None' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 81492.189331
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 87010.496875
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 93759.839375
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 83784.18125
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 405392.561683
	),
),

'sDtr_None' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 1
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 1
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 1
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 1
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 1
	),
),

'sDt_Slight' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 12882.500514
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 23595.751875
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 10481.2225
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 11462.2175
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 49654.586759
	),
),

'sDtr_Slight' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 0.422289
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 0.400313
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 0.390625
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 0.389375
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 0.404954
	),
),

'sDt_Moderate' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 2452.530703
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 4526.644375
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 2385.89875
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 1438.009375
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 12635.859578
	),
),

'sDtr_Moderate' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 0.18515
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 0.123963
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 0.201354
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 0.135625
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 0.15894
	),
),

'sDt_Extensive' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 1001.1057
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 1664.49625
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 825.751875
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 478.653125
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 5430.5759
	),
),

'sDtr_Extensive' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 0.141313
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 0.062586
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 0.131354
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 0.055
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 0.075865
	),
),

'sDt_Complete' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 1949.713179
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 2932.320625
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 1218.328125
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 637.64125
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 11435.39599
	),
),

'sDtr_Complete' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 0.314377
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 0.186026
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 0.346458
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 0.107756
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 0.172089
	),
),

'sDt_Collapse' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 174.075087
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 238.373089
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 100.92452
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 50.449238
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 1037.010512
	),
),

'sDtr_Collapse' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 0.02515
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 0.018751
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 0.030886
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 0.0078
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 0.017645
	),
),

'sCm_Interruption' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 197.4
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 86.489314
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 164.022311
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 33.07694
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 104.164596
	),
),

'sCm_Repair' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 93.1
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 51.472425
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 106.941667
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 28.3
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 44.988312
	),
),

'SCm_Recovery' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 208.1
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 138.454208
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 231.808892
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 65.625
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 121.811854
	),
),

'sCt_DebrisTotal' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 3222031.25
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 4170205.4
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 1601290.075
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 1020915.1
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 9123328.743572
	),
),

'sCt_DebrisBW' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 842742.1
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 1119215.5
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 437207.75
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 280702.5
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 2865318.427216
	),
),

'sCt_DebrisCS' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 2379289.15
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 3050989.9
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 1164082.325
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 740212.6
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 6258010.316356
	),
),

'sCt_CasDayL1' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 5891.945
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 7668.89
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 1998.7125
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 1697.09
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 18720.441115
	),
),

'sCt_CasDayL2' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 1808.8125
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 2363.66
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 628.21
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 503.57
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 5891.987067
	),
),

'sCt_CasDayL3' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 273.195
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 360.53
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 99.745
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 69.25
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 920.406195
	),
),

'sCt_CasDayL4' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 546.99
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 716.71
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 198.5
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 143.78
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 1828.82096
	),
),

'sCt_CasNightL1' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 2258.845
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 2947.37
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 1236.085
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 567.02
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 8518.518913
	),
),

'sCt_CasNightL2' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 611.4825
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 793.69
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 347.925
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 140.25
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 2453.893214
	),
),

'sCt_CasNightL3' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 76.0525
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 98.46
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 44.9575
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 15.66
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 319.017978
	),
),

'sCt_CasNightL4' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 151.225
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 196.53
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 88.7025
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 33.33
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 631.464866
	),
),

'sCt_CasTransitL1' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 4111.0725
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 5359.51
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 1635.2175
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 1139.93
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 13354.20387
	),
),

'sCt_CasTransitL2' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 1220.5125
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 1594.8
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 489.495
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 323.87
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 4082.841891
	),
),

'sCt_CasTransitL3' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 173.8675
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 229.47
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 71.095
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 40.28
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 600.961528
	),
),

'sCt_CasTransitL4' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 350.985
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 460.75
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 141.225
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 87.16
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 1197.471252
	),
),

'sCt_Shelter' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 10122.676113
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 13611.309145
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 4503.175528
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 3229.200657
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 29345.340473
	),
),

'sCt_Res3' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 450685.45
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 567883.7
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 166178.25
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 416651.5
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 1077958.941489
	),
),

'sCt_Res30' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 220681.35
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 285058.5
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 65240.5
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 134292.3
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 510047.206897
	),
),

'sCt_Res90' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 137052.85
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 169929.7
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 49607.7
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 19668.6
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 290137.70663
	),
),

'sCt_Res180' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 80042.6
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 109121.9
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 42330.575
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 2501.7
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 188275.984252
	),
),

'sCt_Res360' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 9282.85
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 15316.3
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 16946.075
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 227
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 102583.583506
	),
),

'sCt_Hshld' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 23666.56113
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 33020.344986
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 16408.755583
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 7468.870083
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 74860.538416
	),
),

'sCt_Empl30' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 383866.1
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 457198.9
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 77996.8
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 193060.3
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 663321.180627
	),
),

'sCt_Empl90' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 203622.875
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 274935
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 63378.55
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 31347.7
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 465242.82088
	),
),

'sCr_Empl90' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 0.99902
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 0.629557
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 0.966165
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 0.491448
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 0.626559
	),
),

'sCt_Empl180' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 65596.4
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 98359
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 44420.7
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 1544.725
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 285595.418233
	),
),

'sCt_Empl360' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 3839.775
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 10161.3
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 5975.375
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 70.55
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 90687.299232
	),
),

'sLt_Asset' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 5284065562.293439
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 11023225892.323982
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 4816792999.06925
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 3284616039.310423
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 22565566242.394806
	),
),

'sLm_Asset' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 0.216471
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 0.156429
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 0.249421
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 0.079271
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 0.353369
	),
),

'sLt_Bldg' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 4687462811.6113
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 9715158108.66775
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 4246595204.4825
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 2917179659.0204
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 19824943927.894596
	),
),

'sLmr_Bldg' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 0.220714
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 0.156644
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 0.251645
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 0.080767
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 0.355467
	),
),

'sLt_Str' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 1974475661.312925
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 3960599715.45275
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 1594084767.795
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 1294418894.930275
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 6922875695.575326
	),
),

'sLt_NStr' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 2712987150.298375
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 5754558393.215
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 2652510436.6875
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 1622760764.090125
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 12902068232.31927
	),
),

'sLt_Cont' => array (
	array (
		'scenario' => 'SIM9p0_CascadiaInterfaceBestFault',
		'value' => 596602750.682139
	),
	array (
		'scenario' => 'ACM7p0_GeorgiaStraitFault',
		'value' => 1308067783.656233
	),
	array (
		'scenario' => 'ACM7p3_LeechRiverFullFault',
		'value' => 570197794.58675
	),
	array (
		'scenario' => 'IDM7p1_Sidney',
		'value' => 367436380.290023
	),
	array (
		'scenario' => 'SCM7p5_valdesbois',
		'value' => 2740622314.500211
	),
),



		);

		foreach ( $maxes as $key => $max ) {

			// echo 'find indicator with key <b>' . $key . '</b><br>';

			$max_query = new WP_Query ( array (
				'post_type' => 'indicator',
				'posts_per_page' => 1,
				'meta_query' => array (
					array (
						'key' => 'indicator_key',
						'value' => $key,
						'compare' => '='
					)
				)
			) );

			if ( $max_query->have_posts() ) {
				while ( $max_query->have_posts() ) {
					$max_query->the_post();

					$this_ID = get_the_ID();

					echo 'updating ' . get_the_title() . ' (' . $key . ')<br>';

					print_r($max);
					//' to ' . $max . '<br>';

					update_field ( 'indicator_max', $max, $this_ID );

				}
			}

		}

	}
}

// add_action ( 'wp_body_open', 'update_max_vals' );

add_action ( 'fw_body_close', function() {
	
?>

<div id="cookie-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header bg-light">
				<h5 class="modal-title">Disclaimer</h5>
			</div>
			
			<div class="modal-body">
				Terms and conditions go here.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Agree and continue</button>
			</div>
		</div>
	</div>
</div>

<?php

});