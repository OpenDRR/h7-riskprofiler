<div class="app-head container-fluid bg-white">
	<div class="app-head-back"><i class="far fa-long-arrow-left"></i></div>

	<div class="app-controls">
		<div class="app-controls-content">
			<?php

				include ( locate_template ( 'template/risks/control-bar.php' ) );

			?>
		</div>
	</div>

	<div class="app-breadcrumb flex-grow-1">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb border-bottom">
		    <li class="breadcrumb-item persistent"><?php _e ( 'Probabilistic Risks', 'rp' ); ?></li>
				<li id="breadcrumb-indicator" class="breadcrumb-item cancellable">
					<a href="#psra" class="overlay-toggle d-flex align-items-center bg-light py-1 px-2">
						<span class="indicator-title"></span>
						<i class="fas fa-times ml-2"></i>
					</a>
				</li>
		  </ol>
		</nav>
	</div>

	<div id="retrofit-toggle" class="app-retrofit d-flex align-items-center px-2 border-bottom border-left">
		<div id="retrofit-togglebox"></div>
		<h6 class="mb-0"><?php _e ( 'Retrofit', 'rp' ); ?></h6>
	</div>
</div>

<div class="app-container">
	<div class="app-sidebar" data-width="">
		<div class="app-sidebar-controls">

			<div id="app-control-sort" class="app-sidebar-control app-sidebar-sort"><?php

				include ( locate_template ( 'template/risks/control-sort.php' ) );

			?></div>

		</div>

		<?php

			$communities = array();

			$comm_query = get_posts ( array (
				'post_type' => 'community',
				'posts_per_page' => -1,
				'suppress_filters' => false,
				'orderby' => 'rand'
			) );

			if ( $comm_query ) {
				foreach ( $comm_query as $comm ) {

					$province = get_field ( 'comm_province', $comm->ID );

					$communities[] = array (
						'name' => get_the_title( $comm->ID ),
						'pr_val' => $province['value'],
						'pr_name' => __ ( $province['label'], 'rp' ),
						'post_id' => $comm->ID,
						'slug' => get_the_slug ( $comm->ID ),
						'feature' => (int) get_field ( 'comm_id', $comm->ID )
					);

				}
			}

		?>

		<div class="app-sidebar-content" data-items='<?php echo json_encode ( $communities ); ?>'>
			<p class="m-2 alert alert-info"><?php _e ( 'Loading regions', 'rp' ); ?>…</p>
		</div>
	</div>

	<div class="app-map">
		<div id="map"></div>
	</div>
</div>
