/**
 * Set up the style guide dropdown to toggle sorting of videos
 */

define( 'lvs.dropdown', [], function() {
	"use strict";

	return function() {
		$( '.WikiaDropdown' ).wikiaDropdown({
			onChange: function( e, $target ) {
				var sort = $target.data( 'sort' ),
					qs = new QueryString();
				qs.setVal( 'sort', sort ).goTo();
			}
		});
	};
});