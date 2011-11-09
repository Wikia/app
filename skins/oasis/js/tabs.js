
/**
 * @author Sean Colombo
 * @date 20111109
 * Standard functionality for js tab-switching amongst content
 * that is already loaded into the HTML (tab-bodies just get hidden/shown).
 *
 * NOTE: since there is no nesting of tabBodies inside of a wrapper, this does
 * create the limitation at the moment that there can only be one set of tabs per page.
 * If we want to remove that implementation, we can make a performance tradeoff and instead
 * of hiding every .tabBody before switching, we can just get all of the data-tabbody-id's
 * from the clicked UL and hide the elements matching those ids.
 */
$(function(){
	$('ul.tabs li a').click(function(){
		// Before hiding existing body, verify that there is a new body to switch to.
		var tabBodyId = $(this).data('tabbody-id');
		if( $('#'+tabBodyId).length > 0) {
			// Unselect previously-selected tab
			$(this).closest('ul').find('li').removeClass('selected');

			// Select the tab that was clicked
			$(this).closest('li').addClass('selected');

			// Hide the current tab-body and show the next one.
			$('.tabBody').removeClass('selected');
			$('#'+tabBodyId).addClass('selected');
		} else {
			$().log("Tried to switch to tab but could not find its tab-body with id: \""+tabBodyId+"\"");
		}
	});
});
