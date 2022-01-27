<?php

function taxonomy_location() {

	$labels = array(
		'name'                       => _x( 'Locations', 'Taxonomy General Name', 'rp-taxonomies' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'rp-taxonomies' ),
		'menu_name'                  => __( 'Locations', 'rp-taxonomies' ),
		'all_items'                  => __( 'All Locations', 'rp-taxonomies' ),
		'parent_item'                => __( 'Parent Location', 'rp-taxonomies' ),
		'parent_item_colon'          => __( 'Parent Location:', 'rp-taxonomies' ),
		'new_item_name'              => __( 'New Location Name', 'rp-taxonomies' ),
		'add_new_item'               => __( 'Add New Location', 'rp-taxonomies' ),
		'edit_item'                  => __( 'Edit Location', 'rp-taxonomies' ),
		'update_item'                => __( 'Update Location', 'rp-taxonomies' ),
		'view_item'                  => __( 'View Location', 'rp-taxonomies' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rp-taxonomies' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rp-taxonomies' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rp-taxonomies' ),
		'popular_items'              => __( 'Popular Items', 'rp-taxonomies' ),
		'search_items'               => __( 'Search Items', 'rp-taxonomies' ),
		'not_found'                  => __( 'Not Found', 'rp-taxonomies' ),
		'no_terms'                   => __( 'No items', 'rp-taxonomies' ),
		'items_list'                 => __( 'Items list', 'rp-taxonomies' ),
		'items_list_navigation'      => __( 'Items list navigation', 'rp-taxonomies' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'location', array( 'indicator' ), $args );

}
add_action( 'init', 'taxonomy_location', 0 );
