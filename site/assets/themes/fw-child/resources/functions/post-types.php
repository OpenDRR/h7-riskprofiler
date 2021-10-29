<?php

//
// TRAINING
//

function pt_training() {

	$labels = array(
		'name'                  => _x( 'Training Resources', 'Post Type General Name', 'rp-post-types' ),
		'singular_name'         => _x( 'Training Resource', 'Post Type Singular Name', 'rp-post-types' ),
		'menu_name'             => __( 'Training', 'rp-post-types' ),
		'name_admin_bar'        => __( 'Resource', 'rp-post-types' ),
		'archives'              => __( 'Resource Archives', 'rp-post-types' ),
		'attributes'            => __( 'Resource Attributes', 'rp-post-types' ),
		'parent_item_colon'     => __( 'Parent Resource:', 'rp-post-types' ),
		'all_items'             => __( 'All Resources', 'rp-post-types' ),
		'add_new_item'          => __( 'Add New Resource', 'rp-post-types' ),
		'add_new'               => __( 'Add New', 'rp-post-types' ),
		'new_item'              => __( 'New Resource', 'rp-post-types' ),
		'edit_item'             => __( 'Edit Resource', 'rp-post-types' ),
		'update_item'           => __( 'Update Resource', 'rp-post-types' ),
		'view_item'             => __( 'View Resource', 'rp-post-types' ),
		'view_items'            => __( 'View Resources', 'rp-post-types' ),
		'search_items'          => __( 'Search Resource', 'rp-post-types' ),
		'not_found'             => __( 'Not found', 'rp-post-types' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rp-post-types' ),
		'featured_image'        => __( 'Featured Image', 'rp-post-types' ),
		'set_featured_image'    => __( 'Set featured image', 'rp-post-types' ),
		'remove_featured_image' => __( 'Remove featured image', 'rp-post-types' ),
		'use_featured_image'    => __( 'Use as featured image', 'rp-post-types' ),
		'insert_into_item'      => __( 'Insert into item', 'rp-post-types' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'rp-post-types' ),
		'items_list'            => __( 'Items list', 'rp-post-types' ),
		'items_list_navigation' => __( 'Items list navigation', 'rp-post-types' ),
		'filter_items_list'     => __( 'Filter items list', 'rp-post-types' ),
	);
	$args = array(
		'label'                 => __( 'Training Resource', 'rp-post-types' ),
		'description'           => __( 'Post Type Description', 'rp-post-types' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'revisions', 'page-attributes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-book-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'training', $args );

}
add_action( 'init', 'pt_training', 0 );
