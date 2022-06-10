<?php

	if ( have_posts() ) {

?>

<!-- <div class="sidebar-items p-2 ajax-content"> -->

	<div class="sidebar-items list-group list-group-flush bg-white m-2">

		<?php

			while ( have_posts() ) {

				the_post();

				// $coords = get_field ( 'scenario_coords' );

				$province = get_field ( 'comm_province' );

		?>

		<div id="<?php echo get_the_slug(); ?>"
			class="sidebar-item city list-group-item list-group-item-action p-0"
			data-id="<?php echo get_the_ID(); ?>"
			data-name="<?php the_title(); ?>"
			data-feature="<?php the_field ( 'comm_id' ); ?>"
		>
			<div class="d-flex pt-1">
				<h5 class="sidebar-item-value d-flex align-items-center justify-content-center px-3 mb-0 border-right font-weight-normal text-center text-gray-500"></h5>

				<div class="px-3 py-1">
					<p class="sidebar-item-header mb-0 text-body"><?php the_title(); ?></p>
					<p class="sidebar-item-province mb-0"><?php _e ( $province['label'], 'rp' ); ?></p>
				</div>
			</div>
		</div>

		<?php

			}

		?>

	</div>
<!-- </div> -->

<?php

	} // if posts
