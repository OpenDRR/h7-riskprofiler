<?php

	// only show indicator data on the risks page

	$show_data = false;

	if ( is_page ( 'risks' ) || is_page ( 'risques' ) ) {
		$show_data = true;
	}

	$ranking = '[]';

	if ( !empty ( get_field ( 'indicator_ranking', $item['id'] ) ) ) {

		$ranking = json_encode ( get_field ( 'indicator_ranking', $item['id'] ) );

	}

?>

<div
	id="risk-var-<?php echo get_field ( 'indicator_key', $item['id'] ); ?>"
	class="risk-var"
	data-type="<?php _e ( get_field ( 'indicator_type', $item['id'] ), 'rp' ); ?>"

	<?php

		if ( $show_data == true ) {

	?>

	data-indicator='{
		"key": "<?php echo get_field ( 'indicator_key', $item['id'] ); ?>",
		"title": "<?php echo $item['title']; ?>",
		"type": "<?php echo get_field ( 'indicator_type', $item['id'] ); ?>",
		"ranking": <?php echo $ranking; ?>,
		"aggregation": <?php

			$legend_steps = 9;

			$agg_fields = get_field ( 'indicator_aggregation', $item['id'] );

			foreach ( $agg_fields as $agg => $settings ) {

				$agg_fields[$agg]['legend'] = array();

				$agg_fields[$agg]['max'] = ( $settings['max'] != '' ) ? $settings['max'] : 100;

				$legend_step = $agg_fields[$agg]['max'] / $legend_steps;

				for ($i = $legend_steps; $i > 0; $i -= 1) {

					$agg_fields[$agg]['legend'][] = $agg_fields[$agg]['max'] - ( $legend_step * $i);

				}

			}
			
			// if custom legend
			
			if ( get_field ( 'indicator_custom', $item['id'] ) == 1 ) {
			
				$new_legend = array (
					'csd' => array(),
					's' => array()
				);
			
				foreach ( get_field ( 'indicator_scale', $item['id'] ) as $key => $group ) {
			
					foreach ( $group as $row ) {
						$new_legend[$key][] = floatval($row['value']);
					}
					
					$agg_fields[$key]['legend'] = $new_legend[$key];
			
				}
				
				// print_r($new_legend);
			
			}

			echo json_encode ( $agg_fields );

		?>,
		"legend": <?php

			$legend_fields = get_field ( 'indicator_label', $item['id'] );

			echo json_encode ( $legend_fields );

		?>
	}'

	<?php

		}

		$risks_path_segment = 'risks';
	        if ( apply_filters ( 'wpml_current_language', NULL ) == 'fr' ) {
			$risks_path_segment = 'risques';
		}

	?>
>
	<a href="<?php echo $GLOBALS['vars']['site_url'] . $risks_path_segment . '/#' . get_field ( 'indicator_key', $item['id'] ); ?>" class="risk-var-link d-block p-2"><span class="item-title"><?php echo $item['title']; ?></span><span class="item-description"><?php the_field ( 'description', $item['id'] ); ?></span></a>
</div>
