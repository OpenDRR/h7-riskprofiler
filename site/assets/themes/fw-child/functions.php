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

}

add_action ( 'wp', 'child_global_vars', 20 );

//
// ENQUEUE
//

function child_theme_enqueue() {
  $theme_dir = get_bloginfo ( 'template_directory' ) . '/';
  $bower_dir = $theme_dir . 'resources/bower_components/';
  $js_dir = $theme_dir . 'resources/js/';

  $child_theme_dir = get_stylesheet_directory_uri() . '/';
  $child_bower_dir = $child_theme_dir . 'resources/bower_components/';
  $child_js_dir = $child_theme_dir . 'resources/js/';

	//

  //
  // STYLES
  //

	if ( is_page ( 'scenarios' ) || is_page ( 'risks' ) ) {

		wp_enqueue_style ( 'leaflet', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css', null, '1.7.1', 'all' );

		wp_enqueue_style ( 'leaflet-cluster', $child_theme_dir . 'resources/vendor/Leaflet.markercluster-1.4.1/dist/MarkerCluster.css', null, null, 'all' );

		wp_enqueue_style ( 'leaflet-cluster-default', $child_theme_dir . 'resources/vendor/Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css', null, null, 'all' );

		wp_enqueue_style ( 'leaflet-pulse', $child_theme_dir . 'resources/vendor/leaflet-icon-pulse/dist/L.Icon.Pulse.css', null, null, 'all' );

  }

  wp_enqueue_style ( 'child-style', $child_theme_dir . 'style.css', array ( 'global-style' ), NULL, 'all' );

  //
  // SCRIPTS
  //

	wp_register_script ( 'profiler', $child_js_dir . 'profiler.js', array ( 'leaflet' ), NULL, true );

	wp_register_script ( 'rp-scenarios', $child_js_dir . 'rp_scenarios.js', array ( 'profiler' ), NULL, true );

	wp_register_script ( 'rp-risks', $child_js_dir . 'rp_risks.js', array ( 'profiler' ), NULL, true );

  wp_register_script ( 'child-functions', $child_js_dir . 'child-functions.js', array ( 'jquery', 'global-functions' ), NULL, true );

  // localize admin url

	wp_localize_script ( 'child-functions', 'admin_ajax_data',
    array (
			'url' => admin_url ( 'admin-ajax.php' )
		)
	);

  // VENDOR

  wp_register_script ( 'togglebox', $child_theme_dir . 'resources/vendor/pe-togglebox/togglebox.js', NULL, true );

  wp_enqueue_script ( 'child-functions' );

  // PAGE CONDITIONALS

	if ( is_page ( 'scenarios' ) || is_page ( 'risks' ) ) {

		wp_enqueue_script ( 'leaflet', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', null, '1.7.1', true );

  }

	if ( is_page ( 'scenarios' ) ) {

		wp_enqueue_script ( 'leaflet-cluster', $child_theme_dir . 'resources/vendor/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster.js', array ( 'leaflet' ), '1.4.1', true );

		wp_enqueue_script ( 'leaflet-pulse', $child_theme_dir . 'resources/vendor/leaflet-icon-pulse/dist/L.Icon.Pulse.js', array ( 'leaflet' ), '1.4.1', true );

		wp_enqueue_script ( 'leaflet-heat', $child_theme_dir . 'resources/js/leaflet-heat.js', array ( 'leaflet' ), null, true );

		wp_enqueue_script ( 'spherical-mercator', $child_theme_dir . 'resources/js/sphericalmercator.js', array ( 'leaflet' ), null, true );

		wp_enqueue_script ( 'leaflet-geopackage', 'https://unpkg.com/@ngageoint/leaflet-geopackage@3.0.3/dist/leaflet-geopackage.min.js', array ( 'leaflet' ), null, true );

		wp_enqueue_script ( 'togglebox' );
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

<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon_package_v0.16/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon_package_v0.16/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon_package_v0.16/favicon-16x16.png">
<link rel="manifest" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon_package_v0.16/site.webmanifest">
<link rel="mask-icon" href="<?php echo $GLOBALS['vars']['child_theme_dir']; ?>resources/vendor/favicon_package_v0.16/safari-pinned-tab.svg" color="#0018ff">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<?php

}

// add_action( 'wp_head', 'add_favicon' );

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

//
// WP AJAX
//

// function get_job_post() {
//
// 	$post = $_POST['id'];
//
// 	setup_postdata ( $post );
//
// 	include ( locate_template ( 'single-position.php' ) );
//
// 	wp_reset_postdata();
//
// 	die();
//
// }
//
// add_action ( 'wp_ajax_get_job_post', 'get_job_post' );
// add_action ( 'wp_ajax_nopriv_get_job_post', 'get_job_post' );

//
// SCENARIO JSON
// update scenarios.json whenever a post is created/updated
//
//
// // function to create the JSON file
//
// function create_scenarios_json() {
//
// 	$scenarios = array();
//
// 	$scenario_query = new WP_Query ( array (
// 		'post_type' => 'scenario',
// 		'posts_per_page' => -1
// 	));
//
// 	while ( $scenario_query->have_posts() ) {
// 		$scenario_query->the_post();
//
// 		$scenarios[] = array (
// 			'id' => get_the_ID(),
// 			'title' => get_the_title(),
// 			'description' => get_field ( 'scenario_description' ),
// 			'magnitude' => get_field ( 'scenario_magnitude' ),
// 			'key' => get_field ( 'scenario_key' ),
// 			'coords' => get_field ( 'scenario_coords' ),
// 			'deaths' => get_field ( 'scenario_deaths' ),
// 			'damage' => get_field ( 'scenario_damage' ),
// 			'dollars' => get_field ( 'scenario_dollars' )
// 		);
//
// 	}
//
// 	// wp_reset_postdata();
//
// 	// open the file
//
// 	$path = locate_template ( 'resources/json/scenarios.json' );
// 	$fp = fopen ( $path, 'w' );
//
// 	if ( !$fp ) {
// 		echo 'error';
// 	}
//
// 	// write
// 	fwrite ( $fp, json_encode ( $scenarios, JSON_PRETTY_PRINT ) );
//
// 	// close
// 	fclose ( $fp );
//
// }
//
// // create_scenarios_json();
//
// // UPDATE ON EDIT
//
// function scenario_json ( $post_id, $post, $update ) {
//
// 	echo 'json';
//
// }
//
// // add_action ( 'save_post_scenario', 'scenario_json' );

//
// ACF ADMIN COLUMNS
//

function add_acf_columns ( $columns ) {
  return array_merge ( $columns, array (
		'indicator_key' => __ ( 'Key' )
  ) );
}

add_filter ( 'manage_indicator_posts_columns', 'add_acf_columns' );

function indicator_custom_column ( $column, $post_id ) {
	switch ( $column ) {
		case 'indicator_key':
			echo get_post_meta ( $post_id, 'indicator_key', true );
			break;
	}
}
add_action ( 'manage_indicator_posts_custom_column', 'indicator_custom_column', 10, 2 );
