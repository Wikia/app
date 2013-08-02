/**
 * Set up the style guide dropdown to toggle sorting of videos
 */

define( 'lvs.dropdown', ['wikia.querystring'], function( QueryString ) {
	"use strict";

	function init() {
		$( '.WikiaDropdown' ).wikiaDropdown({
			onChange: function( e, $target ) {
				var sort = $target.data( 'sort' ),
					qs = new QueryString();
				qs.setVal( 'sort', sort ).goTo();
			}
		});
	}

	return {
		init: init
	};
});