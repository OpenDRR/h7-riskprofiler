<?php

// $parse_uri = explode ( 'assets', $_SERVER['SCRIPT_FILENAME'] );
//
// require_once ( $parse_uri[0] . 'wp-load.php' );
//
// global $sitepress;
// $sitepress->switch_lang($_GET['lang']);
//
// echo apply_filters( 'wpml_current_language', null );

?>

<div class="px-2 pt-2 pb-1 d-flex flex-wrap">
	<div class="sort-item d-flex mr-1 mb-1 rounded-pill selected" data-sort-key="name" data-sort-order="asc">
		<h6 class="mb-0 mr-2"><?php _e ( 'Name', 'rp' ); ?></h6>
		<span class=""><i class="fas fa-caret-up"></i></span>
	</div>

	<div class="sort-item d-flex mr-1 mb-1 rounded-pill" data-sort-key="magnitude" data-sort-order="asc">
		<h6 class="mb-0 mr-2"><?php _e ( 'Magnitude', 'rp' ); ?></h6>
		<span class=""><i class="fas fa-caret-up"></i></span>
	</div>

	<div class="sort-item d-flex mr-1 mb-1 rounded-pill" data-sort-key="deaths" data-sort-order="asc">
		<h6 class="mb-0 mr-2"><?php _e ( 'Deaths', 'rp' ); ?></h6>
		<span class=""><i class="fas fa-caret-up"></i></span>
	</div>

	<div class="sort-item d-flex mr-1 mb-1 rounded-pill" data-sort-key="damage" data-sort-order="asc">
		<h6 class="mb-0 mr-2"><?php _e ( 'Damage', 'rp' ); ?></h6>
		<span class=""><i class="fas fa-caret-up"></i></span>
	</div>

	<div class="sort-item d-flex mr-1 mb-1 rounded-pill" data-sort-key="dollars" data-sort-order="asc">
		<h6 class="mb-0 mr-2"><?php _e ( 'Dollars', 'rp' ); ?></h6>
		<span class=""><i class="fas fa-caret-up"></i></span>
	</div>
</div>
