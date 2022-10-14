<p class="text-gray-400"><?php

	_e ( 'RiskProfiler', 'rp' );

	echo ' v' . get_field ( 'version', 'option' );

	echo '<span class="mx-1">•</span>';

	_e ( 'Built with API', 'rp' );

	echo ' v' . get_field ( 'api_version', 'option' );

	echo '<span class="mx-1">•</span>';

?></p>
