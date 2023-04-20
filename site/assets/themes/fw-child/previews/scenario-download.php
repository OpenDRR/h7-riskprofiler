<?php

	$dl_URL = 'https://github.com/OpenDRR/earthquake-scenarios/releases/latest/download/dsra_';

	$scenario_key = get_field ( 'scenario_key', $item['id'] );

?>

<div class="post-preview type-download py-6">
	<div class="row">

		<div class="col-12 mb-4 d-md-flex justify-content-between align-items-center">
			<h4 class="mb-5 mb-md-0 mr-4"><?php echo $item['title']; ?></h4>

			<div>
				<a href="<?php echo $GLOBALS['vars']['site_url'] . 'scenarios/#' . $scenario_key; ?>" class="btn btn-sm btn-outline-primary rounded-pill mr-2"><i class="fas fa-map-marked mr-1"></i><?php _e ( 'View Scenario', 'rp' ); ?></a>

				<a href="https://github.com/OpenDRR/earthquake-scenarios/blob/master/FINISHED/<?php echo $scenario_key; ?>.md" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill"><i class="fab fa-github mr-1"></i><?php _e ( 'View Repository', 'rp' ); ?></a>
			</div>

		</div>

	</div>

	<div class="row bg-light p-3 flex-column flex-sm-row">

		<div class="col-sm-6 col-md-3 mb-3 mb-md-0">
			<p><?php _e ( 'Shake Map', 'rp' ); ?></p>
			<a href="<?php echo $dl_URL . $scenario_key; ?>_shakemap.zip"><i class="fas fa-file-archive"></i> Geopackage</a>
		</div>

		<div class="col-sm-6 col-md-3 mb-3 mb-md-0">
			<p><?php _e ( 'Aggregated Buildings', 'rp' ); ?></p>
			<a href="<?php echo $dl_URL . $scenario_key; ?>_indicators_b.zip"><i class="fas fa-file-archive"></i> Geopackage</a>
		</div>

		<div class="col-sm-6 col-md-3 mb-3 mb-md-0">
			<p><?php _e ( 'Settlement Area', 'rp' ); ?></p>
			<a href="<?php echo $dl_URL . $scenario_key; ?>_indicators_s.zip"><i class="fas fa-file-archive"></i> Geopackage</a>
		</div>

		<div class="col-sm-6 col-md-3 mb-3 mb-md-0">
			<p><?php _e ( 'Census Subdivision', 'rp' ); ?></p>
			<a href="<?php echo $dl_URL . $scenario_key; ?>_indicators_csd.zip"><i class="fas fa-file-archive"></i> Geopackage</a>
		</div>

	</div>
</div>
