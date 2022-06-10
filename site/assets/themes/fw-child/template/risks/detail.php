<?php

	$parse_uri = explode ( 'assets', $_SERVER['SCRIPT_FILENAME'] );
	require_once ( $parse_uri[0] . 'wp-load.php' );

?>

<div class="sidebar-detail city">
	<div class="container-fluid py-5">
		<div class="row justify-content-center mb-5 text-white">
			<div class="col-8">
				<h4 class="city-name"></h4>
				<p class="city-rank text-gray-200">
					<span class="rp-icon icon-rank text-body mr-2"></span>
					<span data-indicator="eqri_abs_rank">eqri_abs_rank</span>
				</p>
			</div>

			<?php /*<div class="col-2">
				<h6 class="font-size-xs text-gray-200">Rank</h6>
				<p>
					<span class="rp-icon icon-rank text-body mr-2 font-size-lg"></span>
					<span class="city-rank font-size-xl font-weight-bold">1</span>
				</p>
			</div>*/ ?>
		</div>

		<div class="row justify-content-center my-5">
			<div class="col-8">
				<h6 class="text-white mb-0"><?php _e ( 'Integrated Seismic Risk Index', 'rp' ); ?></h6>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-8 mb-2">

				<div class="card mx-n3">
					<div class="card-body row align-items-end p-0">

						<div class="col-6 px-3 pt-3 order-1">
							<div id="abs-score-chart" class="score-chart">
								<div class="range"></div>
								<div class="marker"></div>
								<div class="label" data-indicator="eqri_abs_score" data-decimals="2"></div>
							</div>
						</div>

						<div class="col-6 p-3 order-3">
							<h5 class="mb-0">Absolute Risk Score</h5>
						</div>

						<div class="col-6 px-3 pt-3 border-left order-2">
							<div id="norm-score-chart" class="score-chart">
								<div class="range"></div>
								<div class="marker"></div>
								<div class="label" data-indicator="eqri_norm_score" data-decimals="2"></div>
							</div>
						</div>

						<div class="col-6 p-3 border-left order-4">
							<h5 class="mb-0">Normalized Risk Score</h5>
						</div>

					</div>

				</div>

			</div>
		</div>

		<div class="row justify-content-center my-5">
			<div class="col-8">
				<h6 class="text-white mb-0"><?php _e ( 'Averages', 'rp' ); ?></h6>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-8 mb-2">

				<div class="card mx-n3">

					<div class="card-body row border-bottom">

						<div class="col-8">
							<h6>Average Annual Fatalities</h6>

							<div data-indicator="eC_Fatality">eC_Fatality</div>
						</div>

						<div class="col-4">
							<h6 class="text-gray-400">Ratio</h6>

							<div data-indicator="eCr_Fatality">eCr_Fatality</div>
						</div>
					</div>

					<div class="card-body row border-bottom">
						<div class="col-8">
							<h6>Buildings with Complete Damage</h6>

							<div data-indicator="eDt_Complete">eDt_Complete</div>
						</div>

						<div class="col-4">
							<h6 class="text-gray-400">Ratio</h6>

							<div data-indicator="eDtr_Complete">eDtr_Complete</div>
						</div>
					</div>

					<div class="card-body row">
						<div class="col-8">
							<h6>Building Asset Loss</h6>

							<div data-indicator="eAALt_Bldg">eAALt_Bldg</div>
						</div>

						<div class="col-4">
							<h6 class="text-gray-400">Ratio</h6>

							<div data-indicator="eAALm_Bldg">eAALm_Bldg</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="row justify-content-center my-5">
			<div class="col-8">
				<h6 class="text-white mb-0"><?php _e ( 'Loss Exceedance', 'rp' ); ?></h6>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-8 mb-2">

				<div class="card mx-n3">

					<div class="card-body p-0">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/resources/img/CanadaWide.png">
					</div>
				</div>

			</div>
		</div>


	</div>
</div>
