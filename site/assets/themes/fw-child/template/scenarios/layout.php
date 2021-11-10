<div class="app-head container-fluid bg-white">
	<div class="app-head-back"><i class="far fa-long-arrow-left"></i></div>

	<div class="app-filter">
		<div class="app-filter-content">
			<div class="alert alert-info">Loading</div>
		</div>
	</div>

	<div class="app-breadcrumb flex-grow-1">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb border-bottom">
		    <li class="breadcrumb-item active"><?php _e ( 'Scenario Catalogue', 'rp' ); ?></li>
				<li class="breadcrumb-item tip"><?php _e ( 'Select a marker to retrieve data', 'rp' ); ?></li>
		  </ol>
		</nav>
	</div>
</div>


<div class="app-container">
	<div class="app-sidebar" data-width="">
		<div class="app-sidebar-content">
			<p class="m-2 alert alert-info">Loading scenarios…</p>
		</div>
	</div>

	<div class="app-map">
		<div id="map"></div>
	</div>
</div>
