<p class="text-gray-400"><?php

	_e ( 'RiskProfiler', 'rp' );

	echo ' v' . get_field ( 'version', 'option' );

	echo '<span class="mx-1">•</span>';

	_e ( 'Built with API', 'rp' );

	echo ' v' . get_field ( 'api_version', 'option' );

	echo '<span class="mx-1">•</span>';

	if ($git_describe = get_option ( 'options_git_describe' )) {
		list($version, $api_version, $release_date, $commits_since, $commit_hash) = explode("-", $git_describe);

		if ($commits_since == 0) {
			$git_describe = implode('-', [$version, $api_version, $release_date]);
		}

		$build_number = sprintf("%04d", $release_date - 20220000);
		if ($commits_since > 0) {
			$build_number = implode('-', [$build_number, $commits_since, $commit_hash]);
		}

		echo '(<a href="https://github.com/OpenDRR/riskprofiler/tree/' . $git_describe . '" class="text-gray-400">' . $build_number . '</a>)';

		echo '<span class="mx-1">•</span>';
	}

?></p>
