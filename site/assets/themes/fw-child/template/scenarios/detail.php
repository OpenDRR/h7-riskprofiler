<?php

	if ( isset ( $_GET ) ) {

		$parse_uri = explode ( 'assets', $_SERVER['SCRIPT_FILENAME'] );

		require_once ( $parse_uri[0] . 'wp-load.php' );

		$post_data = $_GET;

?>

<div class="sidebar-detail scenario">
	<div class="container-fluid py-5">
		<div class="row justify-content-center mb-5">
			<div class="col-8">
				<h4 class="text-white mb-0"><?php

					echo $post_data['title'];

				?></h4>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-8">

				<div class="card mx-n3">
					<div class="card-header text-primary border-bottom">Scenario</div>

					<div class="card-body">
						<div class="row row-cols-4 data-cols mb-3">

							<div class="">
								<h6>Magnitude</h6>

								<p class="d-flex align-items-center">
									<span class="rp-icon icon-chart text-primary mr-1"></span>
									<span><?php

										echo number_format ( $post_data['magnitude'], 1 );

									?></span>
								</p>
							</div>

							<div>
								<h6>Deaths</h6>
								<p><?php

									echo number_format ( $post_data['deaths'], 0 );

								?></p>
							</div>

							<div>
								<h6>Damage</h6>
								<p><?php

									echo number_format ( $post_data['damage'], 0 ) . ' buildings';

								?></p>
							</div>

							<div>
								<h6>Dollars</h6>
								<p><?php

									echo '$' . number_format ( $post_data['dollars'], 0 );

								?></p>
							</div>
						</div>

						<div class="data-cols">
							<h6 class="mb-1">Description</h6>
							<p>This is a moment magnitude 9.0 earthquake on the Cascadia Subduction Zone. Earthquakes like this occur about once ever 400–500 years, with the most recent event in January 1700.</p>
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="row justify-content-center my-5">
			<div class="col-8">
				<h6 class="text-white mb-0">Indicators</h6>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-8 accordion" id="scenario-detail-indicators">

				<div class="card mx-n3">
					<div
						id="detail-shake-head"
						class="card-header open border-bottom d-flex align-items-center justify-content-between indicator-item"
						data-toggle="collapse"
						data-target="#detail-shake-collapse"
						aria-expanded="true"
						aria-controls="detail-shake-collapse"
						data-indicator='{
							"key": "shakemap",
							"label": "Shakemap",
							"retrofit": false,
							"legend": "",
							"decimals": 0
						}'
					>
						Shake Map
						<i class="fas fa-caret-down"></i>
					</div>

					<div
						id="detail-shake-collapse"
						class="collapse show border-bottom"
						data-parent="#scenario-detail-indicators"
						aria-labelledby="detail-shake-head"
					>
						<div class="card-body">
							<div class="">
								<p>chart</p>
							</div>
						</div>
					</div>
				</div>

				<?php

					//
					// DEATHS
					//

					$death_query = new WP_Query ( array (
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
								'value' => 'death',
								'compare' => '='
							)
						)
					) );

					if ( $death_query->have_posts() ) {

				?>

				<div class="card mx-n3">
					<div
						id="detail-fatalities-head"
						class="card-header border-bottom d-flex align-items-center justify-content-between"
						data-toggle="collapse"
						data-target="#detail-fatalities-collapse"
						aria-expanded="false"
						aria-controls="detail-fatalities-collapse"
					>
						Fatalities
						<i class="fas fa-caret-down"></i>
					</div>

					<div
						id="detail-fatalities-collapse"
						class="collapse"
						data-parent="#scenario-detail-indicators"
						aria-labelledby="detail-fatalities-head"
					>
						<div class="card-body">
							<ul class="list-unstyled">
								<?php

									while ( $death_query->have_posts() ) {
										$death_query->the_post();

										if ( get_field ( 'indicator_description' ) != '' ) {
											$indicator_title = get_field ( 'indicator_description' );
										} else {
											$indicator_title = get_the_title();
										}

								?>

								<li class="indicator-item" data-indicator='{
									"key": "<?php the_field ( 'indicator_key' ); ?>",
									"label": "<?php echo $indicator_title; ?>",
									"retrofit": <?php

										echo ( get_field ( 'indicator_retrofit' ) == 1 ) ? 'true' : 'false';

									?>,
									"legend": "<?php the_field ( 'indicator_legend' ); ?>",
									"decimals": <?php the_field ( 'indicator_decimals' ); ?>
								}'><?php the_title(); ?></li>

								<?php

									}

								?>
							</ul>

							<div class="">
								<p>chart</p>
							</div>
						</div>
					</div>
				</div>

				<?php

					}

					//
					// DAMAGE
					//

					$damage_query = new WP_Query ( array (
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
								'value' => 'damage',
								'compare' => '='
							)
						)
					) );

					if ( $damage_query->have_posts() ) {

				?>

				<div class="card mx-n3">
					<div
						id="detail-damage-head"
						class="card-header border-bottom border-bottom d-flex align-items-center justify-content-between"
						data-toggle="collapse"
						data-target="#detail-damage-collapse"
						aria-expanded="false"
						aria-controls="detail-damage-collapse"
					>
						Damage
						<i class="fas fa-caret-down"></i>
					</div>

					<div
						id="detail-damage-collapse"
						class="collapse border-bottom"
						data-parent="#scenario-detail-indicators"
						aria-labelledby="detail-damage-head"
					>
						<div class="card-body">
							<ul class="list-unstyled">
								<?php

									while ( $damage_query->have_posts() ) {
										$damage_query->the_post();

										if ( get_field ( 'indicator_description' ) != '' ) {
											$indicator_title = get_field ( 'indicator_description' );
										} else {
											$indicator_title = get_the_title();
										}

								?>

								<li class="indicator-item" data-indicator='{
									"key": "<?php the_field ( 'indicator_key' ); ?>",
									"label": "<?php echo $indicator_title; ?>",
									"retrofit": <?php

										echo ( get_field ( 'indicator_retrofit' ) == 1 ) ? 'true' : 'false';

									?>,
									"legend": "<?php the_field ( 'indicator_legend' ); ?>",
									"decimals": <?php the_field ( 'indicator_decimals' ); ?>
								}'><?php the_title(); ?></li>

								<?php

									}

								?>
							</ul>

							<div class="">
								<p>chart</p>
							</div>
						</div>
					</div>
				</div>

				<?php

					}

					//
					// DOLLARS
					//

					$dollar_query = new WP_Query ( array (
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
								'value' => 'dollars',
								'compare' => '='
							)
						)
					) );

					if ( $dollar_query->have_posts() ) {

				?>

				<div class="card mx-n3">
					<div
						id="detail-dollars-head"
						class="card-header border-bottom border-bottom d-flex align-items-center justify-content-between"
						data-toggle="collapse"
						data-target="#detail-dollars-collapse"
						aria-expanded="false"
						aria-controls="detail-dollars-collapse"
					>
						Dollars
						<i class="fas fa-caret-down"></i>
					</div>

					<div
						id="detail-dollars-collapse"
						class="collapse border-bottom"
						data-parent="#scenario-detail-indicators"
						aria-labelledby="detail-dollars-head"
					>
						<div class="card-body">
							<ul class="list-unstyled">
								<?php

									while ( $dollar_query->have_posts() ) {
										$dollar_query->the_post();

										if ( get_field ( 'indicator_description' ) != '' ) {
											$indicator_title = get_field ( 'indicator_description' );
										} else {
											$indicator_title = get_the_title();
										}

								?>

								<li class="indicator-item" data-indicator='{
									"key": "<?php the_field ( 'indicator_key' ); ?>",
									"label": "<?php echo $indicator_title; ?>",
									"retrofit": <?php

										echo ( get_field ( 'indicator_retrofit' ) == 1 ) ? 'true' : 'false';

									?>,
									"legend": "<?php the_field ( 'indicator_legend' ); ?>",
									"decimals": <?php the_field ( 'indicator_decimals' ); ?>
								}'><?php the_title(); ?></li>

								<?php

									}

								?>
							</ul>

							<div class="">
								<p>chart</p>
							</div>
						</div>
					</div>
				</div>

				<?php

					}

				?>

			</div>
		</div>

	</div>
</div>

<?php

	} else {

?>

<div class="alert alert-danger">Something went wrong.</div>

<?php

	}

?>
