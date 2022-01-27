<div class="app-head container-fluid bg-white">
	<div class="app-head-back"><i class="far fa-long-arrow-left"></i></div>

	<div class="app-controls">
		<div class="app-controls-content">
			<div class="alert alert-info">Loading controls…</div>
		</div>
	</div>

	<div class="app-breadcrumb flex-grow-1">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb border-bottom">
		    <li class="breadcrumb-item persistent"><?php _e ( 'Scenario Catalogue', 'rp' ); ?></li>
				<li class="breadcrumb-item tip"><?php _e ( 'Select a marker to retrieve data', 'rp' ); ?></li>
		  </ol>
		</nav>
	</div>

	<div id="retrofit" class="app-retrofit d-flex align-items-center px-2 border-bottom border-left">
		<div id="retrofit-toggle" class="disabled"></div>
		<h6 class="mb-0">Toggle Retrofit</h6>
	</div>
</div>

<div class="app-container">
	<div class="app-sidebar" data-width="">
		<div class="app-sidebar-controls">
			<div id="app-control-sort" class="app-sidebar-sort collapse"></div>
			<div id="app-control-filter" class="app-sidebar-filter collapse"></div>
		</div>

		<div class="app-sidebar-content">
			<p class="m-2 alert alert-info">Loading scenarios…</p>
		</div>
	</div>

	<div class="app-map">
		<div id="map"></div>
	</div>
</div>
