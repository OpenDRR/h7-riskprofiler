<?php

/**
* Plugin Name: [fw] Page Tour
* Plugin URI: http://github.com/phil-evans
* Description: Adds page tour functionality
* Version: 1.1
* Author: Phil Evans
* Author URI: http://github.com/phil-evans/
*/

//
// FIELDS
// first add the IDs field to the component settings page.
// then, if the field has a value, register the page tour field group
// and set the location to the appropriate IDs
//

add_action ( 'acf/init', function() {
		
	if ( function_exists ( 'acf_add_local_field_group' ) ) {
		
		// add 'tour settings' field group to the theme options page
		
		$tour_settings_args = array(
			'key' => 'tour_settings',
			'title' => 'Page Tour Settings',
			'fields' => array(
				array(
					'key' => 'tour_settings_ids',
					'label' => 'Pages',
					'name' => 'tour_ids',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 1,
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				
			),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options-component-settings',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
			'show_in_rest' => 0,
		);
		
		// if the IDs field has a value,
		// include the options group field
		// before registering
		
		if ( get_field ( 'tour_ids', 'option' ) != '' ) {
			
			$tour_settings_args['fields'][] = array(
				'key' => 'tour_settings_options',
				'label' => 'Options',
				'name' => 'tour_options',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'wpml_cf_preferences' => 1,
				'sub_fields' => array(
					array(
						'key' => 'tour_options_open',
						'label' => 'Open by Default',
						'name' => 'default_open',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => '',
						'default_value' => 1,
						'ui' => 0,
						'wpml_cf_preferences' => 1,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array(
						'key' => 'tour_options_cookie',
						'label' => 'Cookie Settings',
						'name' => 'cookie',
						'type' => 'group',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'layout' => 'block',
						'wpml_cf_preferences' => 1,
						'sub_fields' => array(
							array(
								'key' => 'tour_options_cookie_name',
								'label' => 'Name',
								'name' => 'name',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => '',
								'default_value' => 'pe-page-tour',
								'placeholder' => 'pe-page-tour',
							),
							array(
								'key' => 'tour_options_cookie_expires',
								'label' => 'Expiration',
								'name' => 'expires',
								'type' => 'number',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'default_value' => 30,
								'placeholder' => '30'
							),
						),
					),
					array(
						'key' => 'tour_options_labels',
						'label' => 'Labels',
						'name' => 'labels',
						'type' => 'group',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'layout' => 'block',
						'wpml_cf_preferences' => 1,
						'sub_fields' => array(
							array(
								'key' => 'tour_options_labels_start_over',
								'label' => 'Start Over',
								'name' => 'start_over',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => '',
								'default_value' => 'Start Over',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'tour_options_labels_close',
								'label' => 'Close',
								'name' => 'close',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => '',
								'default_value' => 'Close',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'tour_options_labels_dont_show',
								'label' => 'Don’t show again',
								'name' => 'dont_show',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => '',
								'default_value' => 'Don’t show again',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'tour_options_labels_next',
								'label' => 'Next',
								'name' => 'next',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => '',
								'default_value' => 'Next',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
					array(
						'key' => 'tour_options_classes',
						'label' => 'Classes',
						'name' => 'classes',
						'type' => 'group',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'layout' => 'block',
						'wpml_cf_preferences' => 1,
						'sub_fields' => array(
							array(
								'key' => 'tour_options_classes_content',
								'label' => 'Content',
								'name' => 'content',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 1,
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'tour_options_classes_footer',
								'label' => 'Footer',
								'name' => 'footer',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 1,
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'tour_options_classes_close',
								'label' => 'Close',
								'name' => 'close',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 1,
								'default_value' => 'btn-sm btn-outline-secondary',
								'placeholder' => 'btn-sm btn-outline-secondary',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'tour_options_classes_dont_show',
								'label' => 'Don’t show again',
								'name' => 'dont_show',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 1,
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'tour_options_classes_next',
								'label' => 'Next',
								'name' => 'next',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '50',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 1,
								'default_value' => 'btn-sm btn-outline-primary',
								'placeholder' => 'btn-sm btn-outline-primary',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
				),
			);
			
		}
		
		acf_add_local_field_group ( $tour_settings_args );
		
		// after registering the settings group,
		// get the IDs that are set and register the
		// 'tour' field to those objects
		
		if ( get_field ( 'tour_ids', 'option' ) != '' ) {
			
			$tour_IDs = explode ( ',', get_field ( 'tour_ids', 'option' ) );
			$tour_locations = array();
			
			foreach ( $tour_IDs as $id ) {
				
				if ( get_post_type ( $id ) != 'page' ) {
					$this_type = 'post';
				} else {
					$this_type = 'page';
				}
				
				$tour_locations[] = array (
					array(
						'param' => $this_type,
						'operator' => '==',
						'value' => $id,
					)
				);
				
			}
			
			$tour_field_group_args = array (
				'key' => 'page_tour',
				'title' => 'Tour',
				'fields' => array(
					array(
						'key' => 'page_tour_slides',
						'label' => 'Tour',
						'name' => 'tour',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'block',
						'button_label' => 'Add Slide',
						'wpml_cf_preferences' => 0,
						'sub_fields' => array(
							array(
								'key' => 'page_tour_slides_text',
								'label' => 'Text',
								'name' => 'text',
								'type' => 'wysiwyg',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 0,
								'default_value' => '',
								'tabs' => 'visual',
								'toolbar' => 'basic',
								'media_upload' => 1,
								'delay' => 0,
							),
							array(
								'key' => 'page_tour_slides_position',
								'label' => 'Position',
								'name' => 'position',
								'type' => 'group',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 0,
								'layout' => 'table',
								'sub_fields' => array(
									array(
										'key' => 'page_tour_slides_position_my',
										'label' => 'My',
										'name' => 'my',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'wpml_cf_preferences' => 0,
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									),
									array(
										'key' => 'page_tour_slides_position_at',
										'label' => 'At',
										'name' => 'at',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'wpml_cf_preferences' => 0,
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									),
									array(
										'key' => 'page_tour_slides_position_of',
										'label' => 'Of',
										'name' => 'of',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'wpml_cf_preferences' => 0,
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									),
									array(
										'key' => 'page_tour_slides_position_bubble',
										'label' => 'Bubble',
										'name' => 'bubble',
										'type' => 'select',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'wpml_cf_preferences' => 0,
										'choices' => array(
											'top left' => 'top left',
											'top center' => 'top center',
											'top right' => 'top right',
											'right top' => 'right top',
											'right center' => 'right center',
											'right bottom' => 'right bottom',
											'bottom left' => 'bottom left',
											'bottom center' => 'bottom center',
											'bottom right' => 'bottom right',
											'left top' => 'left top',
											'left center' => 'left center',
											'left bottom' => 'left bottom',
										),
										'default_value' => array(
										),
										'allow_null' => 1,
										'multiple' => 0,
										'ui' => 0,
										'return_format' => 'value',
										'ajax' => 0,
										'placeholder' => '',
									),
								),
							),
						),
					),
				),
				'location' => $tour_locations,
				'menu_order' => 39,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			);
			
			acf_add_local_field_group ( $tour_field_group_args );
		
		}
	
	}
	
});

//
// FRONT-END
//

add_action ( 'wp_enqueue_scripts', function() {
	
	wp_enqueue_script ( 'jquery-ui-core' );
		
	wp_enqueue_style ( 'page-tour', plugin_dir_url ( __FILE__ ) . 'page-tour.css', null, '1.0', 'all' );
	
	wp_enqueue_script ( 'page-tour', plugin_dir_url ( __FILE__ ) . 'page-tour.js', array ( 'jquery', 'fw-cookie' ), '1.0', true );
	
}, 50 );

add_action ( 'fw_after_content_loop', function() {
	
	if ( have_rows ( 'tour', $GLOBALS['vars']['current_query']->ID ) ) {
		
?>

	<div class="page-tour" id="page-tour" data-steps='<?php echo json_encode ( get_field ( 'tour', $GLOBALS['vars']['current_query']->ID ) ); ?>'></div>
	
<?php

	}
	
});

add_action ( 'fw_body_close', function() {
	
	$js_options = '{}';
	$options_field = get_field ( 'tour_options', 'option' );
	
	if ( 
		is_array ( $options_field ) &&
		!empty ( $options_field )
	) {
		
		$options_field['cookie']['expires'] = (int) $options_field['cookie']['expires'];
		
		$js_options = json_encode ( $options_field );
		
	}
	
?>

<script>
	(function ($) {
		$(function() {
			$('#page-tour').page_tour(<?php echo $js_options; ?>)
		});
	}(jQuery));
	
</script>

<?php
	
});