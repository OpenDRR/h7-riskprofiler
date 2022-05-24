<div
	id="risk-var-<?php echo get_field ( 'indicator_key', $item['id'] ); ?>"
	class="risk-var"
	data-indicator='{
		"key": "<?php echo get_field ( 'indicator_key', $item['id'] ); ?>"
	}'
>
	<a href="<?php echo $GLOBALS['vars']['site_url']; ?>risks/#<?php echo get_field ( 'indicator_key', $item['id'] ); ?>"><?php echo $item['title']; ?></a>
</div>
