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

		// BOOTSTRAP

		// STICKY KIT

		// $('#topic-sidebar-inner').stick_in_parent({
		// 	offset_top: sticky_offset
		// })

		if ($('body').attr('id') == 'page-scenarios') {

			$(document).profiler({
				app: 'scenarios'
			})

		} else if ($('body').attr('id') == 'page-risks') {

			$(document).profiler({
				app: 'risks'
			})

		}


    if (child_logging == true) {
      console.log('end of child-functions.js')
      console.log('- - - - -')
    }

  });
})(jQuery);
