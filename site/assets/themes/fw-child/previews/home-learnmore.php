<div class="post-preview card type-home-learnmore h-100">

	<div class="card-body">
		<h4 class="card-title"><a href="<?php echo $item['permalink']; ?>"><?php echo get_field ( 'learnmore_title', $item['id'] ); ?></a></h4>

		<p class="card-text"><?php echo get_field ( 'learnmore_excerpt', $item['id'] ); ?></p>
	</div>
	
	<a href="<?php echo $item['permalink']; ?>" class="full-size z-index-10"></a>
</div>
