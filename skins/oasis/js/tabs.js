
/**
 * @author Sean Colombo, Christian Williams
 * @date 20111109
 * Standard functionality for js tab-switching amongst content
 * that is already loaded into the HTML (tab-bodies just get hidden/shown).
 */
jQuery(function($){
	$('body').on('click','.tabs a',function( evt ){
		// if Tab is disabled do nothing
		if( $(this).parent().hasClass('disabled'))  {
			return;
		}
		// Before hiding existing body, verify that there is a new body to switch to
		var newTabName = $(this).parent().data('tab');
		if( $('[data-tab-body="'+newTabName+'"]').length > 0) {
			// Don't follow href
			evt.preventDefault();

			// Store the name of the previously-selected tab and remove its selected class
			var previousTabName = $(this).closest('ul').find('.selected').removeClass('selected').data('tab');

			// Select the tab that was clicked
			$(this).closest('li').addClass('selected');

			// Hide the previous tab-body and show the new one
			$('[data-tab-body="'+previousTabName+'"]').removeClass('selected');
			$('[data-tab-body="'+newTabName+'"]').addClass('selected');

		} else {
			$().log("Tried to switch to tab but could not find data-tab-body: \""+newTabName+"\"");
		}
	});
});
