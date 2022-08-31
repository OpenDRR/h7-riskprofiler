var current_script = document.currentScript.src
var filename = current_script.split('/').pop()
var child_theme_dir = current_script.replace('/resources/js/' + filename, '') + '/'

var child_logging = true

;(function($) {
  $(function() {
		
		var nav_items = $('#header-primary .fw-menu-item')

    //
    // CHILD THEME URL
    //

    $(document).data('child_theme_dir', child_theme_dir)

		//
		// HEADER
		//

		$('#menu-icon i').click(function() {

			if ($('body').hasClass('nav-open')) {
				$('body').removeClass('nav-open')
				$(this).removeClass('fa-times').addClass('fa-bars')
			} else {
				$('body').addClass('nav-open')
				$(this).removeClass('fa-bars').addClass('fa-times')
			}

		})

    //
    // APP
    //

		if ($('body').hasClass('app-page')) {

			$(document).profiler()

			if ($('body').attr('id') == 'page-scenarios') {

				// fire scenarios app
				$(document).rp_scenarios()
				
			} else if ($('body').attr('id') == 'page-risks') {
				
				// force current classes on nav item
				// (url doesn't match button href because it's a overlay toggle)
				
				$('#header-primary .fw-menu-item').last().addClass('current-nav-item').find('a').addClass('.current-nav-link')
				
				// fire risks app
				$(document).rp_risks()
				

			}

			$('body').on('click', '.overlay-content #psra-items .query-item', function(e) {

				if ($(e.target).is('div')) {
					$(this).find('a').trigger('click')
				}

			})

		}
		
		var current_nav_item = $('#header-primary').find('.current-nav-item')
		
		// filter toggles in risks overlay

		$('body').on('click', '.overlay-content #psra-items-filter .item', function() {

			var item_list = $('body').find('.overlay-content #psra-items .list-group')

			if ($(this).hasClass('selected')) {

				$(this).removeClass('selected')
				item_list.find('.query-item').slideDown(250)

			} else {

				var selected_filter = $(this).text().toLowerCase()

				console.log(selected_filter)

				$(this).addClass('selected').siblings().removeClass('selected')

				item_list.find('.risk-var:not([data-type="' + selected_filter + '"])').closest('.query-item').slideUp(250)

				item_list.find('[data-type="' + selected_filter + '"]').closest('.query-item').slideDown(250)
			}

		})
		
		// overlay show/hide events
		
		$(document).on('overlay_show', function() {
			$('body').removeClass('nav-open')
			$('#menu-icon i').removeClass('fa-times').addClass('fa-bars')
			
			$(nav_items[0]).removeClass('current-nav-item').find('a').removeClass('current-nav-link')
			
			$(nav_items[1]).addClass('current-nav-item').find('a').addClass('current-nav-link')
			
		}).on('overlay_hide', function() {
			
			$(nav_items[1]).removeClass('current-nav-item').find('a').removeClass('current-nav-link')
			
			console.log(current_nav_item)
			if (current_nav_item.length) {
				current_nav_item.addClass('current-nav-item').find('a').addClass('current-nav-link')
			}
			
		})

		//
		// BOOTSTRAP
		//

		$('.accordion').on('hidden.bs.collapse', function (e) {

			console.log(e)

			console.log($(this))

		})

    if (child_logging == true) {
      console.log('end of child-functions.js')
      console.log('- - - - -')
    }

  });
})(jQuery);
