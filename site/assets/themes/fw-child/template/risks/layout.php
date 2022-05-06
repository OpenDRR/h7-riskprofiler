<div class="app-head container-fluid bg-white">
	<div class="app-head-back"><i class="far fa-long-arrow-left"></i></div>

	<div class="app-controls">
		<div class="app-controls-content">
			<div class="alert alert-info"><?php _e ( 'Loading controls', 'rp' ); ?>…</div>
		</div>
	</div>

	<div class="app-breadcrumb flex-grow-1">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb border-bottom">
		    <li class="breadcrumb-item persistent"><?php _e ( 'Probabilistic Risks', 'rp' ); ?></li>
				<li class="breadcrumb-item tip">Fatalities</li>
		  </ol>
		</nav>
	</div>

	<div id="retrofit-toggle" class="app-retrofit d-flex align-items-center px-2 border-bottom border-left">
		<div id="retrofit-togglebox" class="disabled"></div>
		<h6 class="mb-0"><?php _e ( 'Retrofit', 'rp' ); ?></h6>
	</div>
</div>

<div class="app-container">
	<div class="app-sidebar" data-width="">
		<div class="app-sidebar-controls">
			<div id="app-control-sort" class="app-sidebar-control app-sidebar-sort"></div>
			<?php /*<div id="app-control-filter" class="app-sidebar-control app-sidebar-filter"></div>*/ ?>
		</div>

		<div class="app-sidebar-content">
			<p class="m-2 alert alert-info"><?php _e ( 'Loading regions', 'rp' ); ?>…</p>
		</div>
	</div>

	<div class="app-map">
		<div id="map"></div>
	</div>
</div>
