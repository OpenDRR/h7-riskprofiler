<?php

	$parse_uri = explode ( 'assets', $_SERVER['SCRIPT_FILENAME'] );
	require_once ( $parse_uri[0] . 'wp-load.php' );

?>

<div class="sidebar-items p-2">
	<?php

		$item_query = new WP_Query ( array (
			'post_type' => 'scenario',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'asc'
		) );

		if ( $item_query->have_posts() ) {
			while ( $item_query->have_posts() ) {
				$item_query->the_post();

				$coords = get_field ( 'scenario_coords' );

	?>

	<div
		id="<?php the_field ( 'scenario_key' ); ?>"
		class="sidebar-item scenario bg-white mb-2"
		data-id="<?php echo get_the_ID(); ?>"
		data-name="<?php the_title(); ?>"
		data-magnitude="<?php the_field ( 'scenario_magnitude' ); ?>"
		data-deaths="<?php the_field ( 'scenario_deaths' ); ?>"
		data-damage="<?php the_field ( 'scenario_damage' ); ?>"
		data-dollars="<?php the_field ( 'scenario_dollars' ); ?>"
		data-scenario='<?php

			echo json_encode ( array (
				'id' => get_the_ID(),
				'url' => get_the_permalink(),
				'title' => get_the_title(),
				'description' => get_field ( 'scenario_description' ),
				'magnitude' => get_field ( 'scenario_magnitude' ),
				'key' => get_field ( 'scenario_key' ),
				'coords' => get_field ( 'scenario_coords' ),
				'deaths' => get_field ( 'scenario_deaths' ),
				'damage' => get_field ( 'scenario_damage' ),
				'dollars' => get_field ( 'scenario_dollars' )
			) );

		?>'
	>
		<div class="sidebar-item-header d-flex">
			<h5 class="sidebar-item-title flex-grow-1 p-3 mb-0"><?php the_title(); ?></h5>

			<h5 class="sidebar-item-magnitude d-flex align-items-center mb-0 p-2 border-left">
				<span class="rp-icon icon-chart text-primary mr-1"></span>
				<span><?php echo number_format_i18n ( get_field ( 'scenario_magnitude' ), 1 ); ?></span>
			</h5>
		</div>

		<div class="sidebar-item-body data-cols row row-cols-3 bg-light p-2">
			<div>
				<h6>Deaths</h6>
				<p><?php

					echo number_format_i18n ( get_field ( 'scenario_deaths' ), 0 );

				?></p>
			</div>

			<div>
				<h6>Damage</h6>
				<p><?php

					echo number_format_i18n ( get_field ( 'scenario_damage' ), 0 );

				?> buildings</p>
			</div>

			<div>
				<h6>Dollars</h6>
				<p>$<?php

					echo number_format_i18n ( get_field ( 'scenario_dollars' ), 0 );

				?></p>
			</div>
		</div>

		<div class="sidebar-button">Explore Scenario</div>
	</div>

	<?php

			}
		}

	?>

</div>
