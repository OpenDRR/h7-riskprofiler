<?php

	$dl_URL = 'https://github.com/OpenDRR/earthquake-scenarios/releases/latest/download/dsra_';

	$scenario_key = get_field ( 'scenario_key', $item['id'] );

?>

<div class="post-preview type-download py-6">
	<div class="row">

		<div class="col-12 mb-4 d-flex justify-content-between align-items-center">
			<h4 class="mb-0 mr-4"><?php echo $item['title']; ?></h4>

			<div>
				<a href="<?php echo $GLOBALS['vars']['site_url'] . 'scenarios/#' . $scenario_key; ?>" class="btn btn-sm btn-outline-primary rounded-pill mr-2"><i class="fas fa-map-marked mr-1"></i>View Scenario</a>

				<a href="https://github.com/OpenDRR/earthquake-scenarios/blob/master/FINISHED/<?php echo $scenario_key; ?>.md" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill"><i class="fab fa-github mr-1"></i>View Repository</a>
			</div>

		</div>

	</div>

	<div class="row bg-light p-3">

		<div class="col-2-of-10">
			<p>Shake Map</p>
			<a href="<?php echo $dl_URL . $scenario_key; ?>_shakemap.zip"><i class="fas fa-file-archive"></i> Geopackage</a>
		</div>

		<div class="col-2-of-10">
			<p>Aggregated Buildings</p>
			<a href="<?php echo $dl_URL . $scenario_key; ?>_indicators_b.zip"><i class="fas fa-file-archive"></i> Geopackage</a>
		</div>

		<div class="col-2-of-10">
			<p>Settlement Area</p>
			<a href="<?php echo $dl_URL . $scenario_key; ?>_indicators_s.zip"><i class="fas fa-file-archive"></i> Geopackage</a>
		</div>

		<div class="col-2-of-10">
			<p>Census Subdivision</p>
			<a href="<?php echo $dl_URL . $scenario_key; ?>_indicators_csd.zip"><i class="fas fa-file-archive"></i> Geopackage</a>
		</div>

	</div>
</div>
