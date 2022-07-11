<?php

	// only show indicator data on the risks page

	$show_data = false;

	if ( is_page ( 'risks' ) ) {
		$show_data = true;
	}

	$ranking = array();

	if ( !empty ( get_field ( 'indicator_ranking', $item['id'] ) ) ) {

		$ranking = get_field ( 'indicator_ranking', $item['id'] );

	}

?>

<div
	id="risk-var-<?php echo get_field ( 'indicator_key', $item['id'] ); ?>"
	class="risk-var"
	data-type="<?php echo _e ( get_field ( 'indicator_type', $item['id'] ), 'rp' ); ?>"

	<?php

		if ( $show_data == true ) {

	?>

	data-indicator='{
		"key": "<?php echo get_field ( 'indicator_key', $item['id'] ); ?>",
		"title": "<?php echo $item['title']; ?>",
		"ranking": <?php echo json_encode ( $ranking ); ?>,
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

			echo json_encode ( $agg_fields );

		?>,
		"legend": <?php

			$legend_fields = get_field ( 'indicator_label', $item['id'] );

			echo json_encode ( $legend_fields );

		?>
	}'

	<?php

		}

	?>
>
	<a href="<?php echo $GLOBALS['vars']['site_url']; ?>risks/#<?php echo get_field ( 'indicator_key', $item['id'] ); ?>" class="risk-var-link d-block p-2"><?php echo $item['title']; ?></a>
</div>
