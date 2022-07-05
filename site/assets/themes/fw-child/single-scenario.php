<?php

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();

			$scenario_key = get_field ( 'scenario_key' );

?>

<div class="sidebar-detail scenario">

	<div class="container-fluid py-5">
		<div class="row justify-content-center mb-5">
			<div class="col-10">
				<h4 class="text-white mb-0"><?php the_title(); ?></h4>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-10">

				<div class="card mx-n3">
					<div class="card-header text-primary border-bottom"><?php _e ( 'Scenario', 'rp' ); ?></div>

					<div class="card-body">
						<div class="row row-cols-2 data-cols">

							<div class="mb-3">
								<h6><?php _e ( 'Magnitude', 'rp' ); ?></h6>

								<p class="d-flex align-items-center">
									<span class="rp-icon icon-chart text-primary mr-1"></span>
									<span><?php

										echo number_format ( get_field ( 'scenario_magnitude' ), 1 );

									?></span>
								</p>
							</div>

							<div class="mb-3">
								<h6><?php _e ( 'Deaths', 'rp' ); ?></h6>
								<p><?php

									echo number_format ( get_field ( 'scenario_deaths' ), 0 );

								?></p>
							</div>

							<div class="mb-3">
								<h6><?php _e ( 'Damage', 'rp' ); ?></h6>
								<p><?php

									echo number_format ( get_field ( 'scenario_damage' ), 0 ) . ' ';

									_e ( 'buildings', 'rp' );

								?></p>
							</div>

							<div class="mb-3">
								<h6><?php _e ( 'Dollars', 'rp' ); ?></h6>
								<p><?php

									$dollars = (int) get_field ( 'scenario_dollars' );

									$dollars = $dollars * pow ( 10, -9 );

									printf ( __ ( '$%s billion', 'rp' ), number_format ( $dollars, 1 ) );

								?></p>
							</div>
						</div>

						<div class="data-cols">
							<h6 class="mb-1"><?php _e ( 'Description', 'rp' ); ?></h6>
							<p><?php the_field ( 'scenario_description' ); ?></p>
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="row justify-content-center my-5">
			<div class="col-10">
				<h6 class="text-white mb-0"><?php _e ( 'Indicators', 'rp' ); ?></h6>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-10 accordion" id="scenario-detail-indicators">

				<div class="card mx-n3">
					<div
						id="detail-shake-head"
						class="card-header open border-bottom d-flex align-items-center justify-content-between indicator-item"
						data-toggle="collapse"
						data-target="#detail-shake-collapse"
						aria-expanded="true"
						aria-controls="detail-shake-collapse"
						data-indicator='{
							"key": "sH_PGA",
							"label": "Peak Ground Acceleration, in units of g",
							"retrofit": false,
							"aggregation": {
								"1km": { "rounding": 2, "decimals": 2 },
								"5km": { "rounding": 2, "decimals": 2 },
								"10km": { "rounding": 2, "decimals": 2 },
								"25km": { "rounding": 2, "decimals": 2 },
								"50km": { "rounding": 2, "decimals": 2 }
							},
							"legend": {
								"prepend": "",
								"append": "%g",
								"values": [ 0, 0.0017, 0.014, 0.039, 0.092, 0.18, 0.24, 0.65, 1.24 ],
								"color": "default"
							}
						}'
					>
						<?php _e ( 'Shake Map', 'rp' ); ?>
						<i class="fas fa-caret-down"></i>
					</div>

					<div
						id="detail-shake-collapse"
						class="collapse show border-bottom"
						data-parent="#scenario-detail-indicators"
						aria-labelledby="detail-shake-head"
					>
					</div>
				</div>

				<?php

					$query_cats = array (
						array (
							'title' => __( 'Injuries', 'rp' ),
							'key' => 'death'
						),
						array (
							'title' => __( 'Damage', 'rp' ),
							'key' => 'damage'
						),
						array (
							'title' => __( 'Dollars', 'rp' ),
							'key' => 'dollars'
						)
					);

					foreach ( $query_cats as $cat ) {

						$cat_query = new WP_Query ( array (
							'post_type' => 'indicator',
							'posts_per_page' => -1,
							'orderby' => 'menu_order',
							'order' => 'asc',
							'tax_query' => array (
								array (
									'taxonomy' => 'location',
									'field' => 'slug',
									'terms' => 'scenarios'
								)
							),
							'meta_query' => array (
								array (
									'key' => 'indicator_type',
									'value' => $cat['key'],
									'compare' => '='
								)
							)
						) );

						if ( $cat_query->have_posts() ) {

				?>

				<div class="card mx-n3">
					<div
						id="detail-<?php echo $cat['key']; ?>-head"
						class="card-header border-bottom d-flex align-items-center justify-content-between"
						data-toggle="collapse"
						data-target="#detail-<?php echo $cat['key']; ?>-collapse"
						aria-expanded="false"
						aria-controls="detail-<?php echo $cat['key']; ?>-collapse"
					>
						<?php echo $cat['title']; ?>
						<i class="fas fa-caret-down"></i>
					</div>

					<div
						id="detail-<?php echo $cat['key']; ?>-collapse"
						class="collapse"
						data-parent="#scenario-detail-indicators"
						aria-labelledby="detail-<?php echo $cat['key']; ?>-head"
					>
						<div class="card-body p-0">
							<ul class="list-unstyled">
								<?php

									while ( $cat_query->have_posts() ) {
										$cat_query->the_post();

										// title

										if ( get_field ( 'indicator_description' ) != '' ) {
											$indicator_title = get_field ( 'indicator_description' );
										} else {
											$indicator_title = get_the_title();
										}

										// aggregation settings

										$agg_settings = get_field ( 'indicator_aggregation' );

								?>

								<li class="indicator-item border-bottom" data-indicator='{
									"key": "<?php the_field ( 'indicator_key' ); ?>",
									"label": "<?php echo $indicator_title; ?>",
									"type": "<?php echo $cat['key']; ?>",
									"retrofit": <?php

										echo ( get_field ( 'indicator_retrofit' ) == 1 ) ? 'true' : 'false';

									?>,
									"aggregation": {
										"csd": {
											"rounding": <?php echo $agg_settings['csd']['rounding']; ?>,
											"decimals": <?php echo $agg_settings['csd']['decimals']; ?>
										},
										"s": {
											"rounding": <?php echo $agg_settings['s']['rounding']; ?>,
											"decimals": <?php echo $agg_settings['s']['decimals']; ?>
										}
									},
									"legend": <?php

										$legend_fields = get_field ( 'indicator_label' );

										$legend_fields['values'] = array();

										// max val

										// find the row in 'indicator_max' with this scenario's key and use its value

										$maxes = get_field ( 'indicator_max' );
										$legend_max = 100;

										if ( is_array ( $maxes ) && !empty ( $maxes ) ) {
											foreach ( $maxes as $max ) {
												if ( $max['scenario'] == $scenario_key ) {
													$legend_max = $max['value'];
													break;
												}
											}
										}

										// steps

										$legend_steps = 9;

										$legend_step = $legend_max / $legend_steps;

										for ($i = $legend_steps; $i > 0; $i -= 1) {

											$legend_fields['values'][] = $legend_max - ( $legend_step * $i);

										}

										// colors

										if ( get_field ( 'indicator_color' ) == '' ) {
											update_field ( 'indicator_color', 'default' );
										}

										$legend_fields['color'] = get_field ( 'indicator_color' );

										echo json_encode ( $legend_fields );

									?>
								}'>
									<span class="d-block px-3 py-1"><?php the_title(); ?></span>
								</li>

								<?php

									} // while posts

								?>
							</ul>
						</div>
					</div>
				</div>

				<?php

						} // if posts

						wp_reset_postdata();

					} // foreach

				?>

			</div>
		</div>

	</div>
</div>

<?php

		}


	} else {

?>

<div class="alert alert-danger"><?php _e ( 'Something went wrong.', 'rp' ); ?></div>

<?php

	}

?>
