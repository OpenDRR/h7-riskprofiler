<?php

	if ( have_posts() ) {

?>

<div class="sidebar-items p-2 ajax-content">
	<?php

		while ( have_posts() ) {

			the_post();

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
				'description' => esc_attr ( get_field ( 'scenario_description' ) ),
				'magnitude' => get_field ( 'scenario_magnitude' ),
				'key' => get_field ( 'scenario_key' ),
				'coords' => get_field ( 'scenario_coords' ),
				'deaths' => get_field ( 'scenario_deaths' ),
				'damage' => get_field ( 'scenario_damage' ),
				'dollars' => get_field ( 'scenario_dollars' ),
				'bounds' => get_field ( 'scenario_bounds' )
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
				<h6><?php _e ( 'Deaths', 'rp' ); ?></h6>
				<p><?php

					$deaths = get_field ( 'scenario_deaths' );
					
					if ( $deaths < 1 ) {
						
						_e ( '0 people', 'rp' );
						
					} else if ( $deaths < 10 ) {
						
						printf ( __ ( 'Less than %s people', 'rp' ), 10 );
						
					} else {
						
						$deaths = significant_figs ( $deaths );
						
						printf ( __ ( '%s people', 'rp' ), $deaths );
						
					}

				?></p>
			</div>

			<div>
				<h6><?php _e ( 'Damage', 'rp' ); ?></h6>
				<p><?php
				
					$damage = get_field ( 'scenario_damage' );
					
					if ( $damage == 0 ) {
						
						_e ( '0 buildings', 'rp' );
						
					} elseif ( $damage <= 1 ) {
						
						_e ( '1 or less', 'rp' );
						echo ' ';
						_e ( 'buildings', 'rp' );
						
					} else if ( $damage <= 10 ) {
						
						_e ( '10 buildings', 'rp' ); 
						
					} else if ( $damage <= 100 ) {
						
						echo number_format ( $damage * pow ( 10, -1 ), 0 ) * 10;
						echo ' ';
						_e ( 'buildings', 'rp' );
						
					} else {
						
						$damage = significant_figs ( $damage );
						
						printf ( __ ( '%s buildings', 'rp' ), $damage );
						
					}

				?></p>
			</div>

			<div>
				<h6><?php _e ( 'Dollars', 'rp' ); ?></h6>
				<p><?php

					$dollars = (int) get_field ( 'scenario_dollars' );
					
					if ($dollars == 0) {
						
						echo '$0 CAD';
						
					} elseif ($dollars < 1000) {
						
						_e ( 'Less than', 'rp' );
						echo '$1000 CAD';
						
					} else {
						
						$dollars = significant_figs ( $dollars );
						
						echo '$' . $dollars;
						
					}

				?></p>
			</div>
		</div>

		<div class="sidebar-button"><?php _e ( 'Explore Scenario', 'rp' ); ?></div>
	</div>

	<?php

		}

	?>

</div>

<?php

	} // if posts
