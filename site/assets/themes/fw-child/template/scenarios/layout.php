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

	<div id="chart-toggle" class="app-retrofit d-flex align-items-center px-2 border-bottom border-left">
		<div id="chart-togglebox" class="checked disabled"></div>
		<h6 class="mb-0">Charts</h6>
	</div>

	<div id="retrofit-toggle" class="app-retrofit d-flex align-items-center px-2 border-bottom border-left">
		<div id="retrofit-togglebox" class="disabled"></div>
		<h6 class="mb-0">Retrofit</h6>
	</div>
</div>

<div class="app-container">
	<div class="app-sidebar" data-width="">
		<div class="app-sidebar-controls">
			<div id="app-control-sort" class="app-sidebar-control app-sidebar-sort"></div>
			<?php /*<div id="app-control-filter" class="app-sidebar-control app-sidebar-filter"></div>*/ ?>
		</div>

		<div class="app-sidebar-content">
			<p class="m-2 alert alert-info">Loading scenarios…</p>
		</div>
	</div>

	<div class="app-charts">

		<div class="chart-section has-tabs">
			<div class="sticky-top p-2 bg-white border-bottom d-flex justify-content-between">
				<h5 class="mb-0">By Building Type</h5>

				<ul class="nav nav-pills chart-tabs" id="tabs-building-type" role="tablist">
				  <li class="nav-item" role="presentation">
				    <a
							href="#tab-E_BldgTypeG"
							id="tab-link-E_BldgTypeG"
							class="nav-link active"
							data-toggle="pill"
							role="tab"
							aria-controls="tab-E_BldgTypeG"
							aria-selected="true"
						>General</a>
				  </li>

					<li class="nav-item" role="presentation">
				    <a
							href="#tab-E_BldgTypeS"
							id="tab-link-E_BldgTypeS"
							class="nav-link"
							data-toggle="pill"
							role="tab"
							aria-controls="tab-E_BldgTypeS"
							aria-selected="false"
						>Specific</a>
				  </li>
				</ul>

				<!-- <div>
					<ul class="list-unstyled d-flex mb-0 chart-tabs" id="tabs-building-type" role="tablist">
						<li class="ml-1 px-1 active" data-toggle="list" href="#tab-E_BldgTypeG" role="tab">General</li>
						<li class="ml-1 px-1" data-toggle="list" href="#tab-E_BldgTypeS" role="tab">Specific</li>
					</ul>
				</div> -->
			</div>

			<div id="charts-building-type" class="chart-tab-content tab-content">

				<div id="tab-E_BldgTypeG" class="chart-tab tab-pane fade show active" role="tabpanel" aria-labelledby="tab-link-E_BldgTypeG">
					<div id="chart-E_BldgTypeG" class="chart-container"></div>
					<div id="legend-E_BldgTypeG" class="chart-legend"></div>
				</div>

				<div id="tab-E_BldgTypeS" class="chart-tab tab-pane fade" role="tabpanel" aria-labelledby="tab-link-E_BldgTypeS">
					<div id="chart-E_BldgTypeS" class="chart-container"></div>
					<div id="legend-E_BldgTypeS" class="chart-legend"></div>
				</div>
			</div>
		</div>

		<div class="sticky-top p-2 bg-white border-bottom">
			<h5 class="mb-0">By Design Level</h5>
		</div>

		<div id="charts-design-level" class="chart-tab-content">
			<div id="chart-E_BldgDesLev" class="chart-container"></div>
			<div id="legend-E_BldgDesLev" class="chart-legend"></div>
		</div>

		<div class="chart-section has-tabs">
			<div class="sticky-top p-2 bg-white border-bottom d-flex justify-content-between">
				<h5 class="mb-0">By Occupancy Class</h5>

				<ul class="nav nav-pills chart-tabs" id="tabs-building-type" role="tablist">
				  <li class="nav-item" role="presentation">
				    <a
							href="#tab-E_BldgOccG"
							id="tab-link-E_BldgOccG"
							class="nav-link active"
							data-toggle="pill"
							role="tab"
							aria-controls="tab-E_BldgOccG"
							aria-selected="true"
						>General</a>
				  </li>

					<li class="nav-item" role="presentation">
				    <a
							href="#tab-E_BldgOccS1"
							id="tab-link-E_BldgOccS1"
							class="nav-link"
							data-toggle="pill"
							role="tab"
							aria-controls="tab-E_BldgOccS1"
							aria-selected="false"
						>Specific</a>
				  </li>
				</ul>
			</div>

			<div id="charts-building-type" class="chart-tab-content tab-content">

				<div id="tab-E_BldgOccG" class="chart-tab tab-pane fade show active" role="tabpanel" aria-labelledby="tab-link-E_BldgOccG">
					<div id="chart-E_BldgOccG" class="chart-container"></div>
					<div id="legend-E_BldgOccG" class="chart-legend"></div>
				</div>

				<div id="tab-E_BldgOccS1" class="chart-tab tab-pane fade" role="tabpanel" aria-labelledby="tab-link-E_BldgTypeS">
					<div id="chart-E_BldgOccS1" class="chart-container"></div>
					<div id="legend-E_BldgOccS1" class="chart-legend"></div>
				</div>
			</div>
		</div>

		<!-- <div class="sticky-top p-2 bg-white border-bottom d-flex justify-content-between">
			<h5 class="mb-0">By Occupancy Class</h5>

			<div>
				<ul class="list-unstyled d-flex mb-0">
					<li class="ml-1 px-1"><a href="#tab-chart-E_BldgOccG">General</a></li>
					<li class="ml-1 px-1"><a href="#tab-chart-E_BldgOccS">Specific</a></li>
				</ul>
			</div>
		</div>

		<div id="charts-occupancy" class="chart-tab-content">
			<div class="chart-tab">
				<div id="chart-E_BldgOccG" class="chart-container"></div>
				<div id="legend-E_BldgOccG" class="chart-legend"></div>
			</div>

			<div class="chart-tab">
				<div id="chart-E_BldgOccS1" class="chart-container"></div>
				<div id="legend-E_BldgOccS1" class="chart-legend"></div>
			</div>
		</div> -->
	</div>

	<div class="app-map">
		<div id="map"></div>
	</div>
</div>


<div id="data-modal" class="modal" tabindex="-1" style="display: none;">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="chart-data-placeholder"></div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
