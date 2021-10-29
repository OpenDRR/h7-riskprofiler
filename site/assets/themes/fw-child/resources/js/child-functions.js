var current_script = document.currentScript.src
var filename = current_script.split('/').pop()
var child_theme_dir = current_script.replace('/resources/js/' + filename, '') + '/'

var child_logging = true

;(function($) {
  $(function() {

    //
    // CHILD THEME URL
    //

    $(document).data('child_theme_dir', child_theme_dir)

    //
    // VENDOR
    //

		if ($('body').attr('id') == 'page-scenarios') {

			$(document).scenario_profiler({

			})

		} else if ($('body').attr('id') == 'page-risks') {

			$(document).risk_profiler({

			})

		}

    if (child_logging == true) {
      console.log('end of child-functions.js')
      console.log('- - - - -')
    }

  });
})(jQuery);
