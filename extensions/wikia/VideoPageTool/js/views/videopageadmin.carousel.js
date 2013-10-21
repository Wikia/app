$(function() {
	'use strict';

	$('#latest-videos-form' ).on( 'click', '.search-button', function( e ) {
		e.preventDefault();

		$.nirvana.sendRequest({
			controller: 'VideoPageAdminSpecial',
			method: 'getCategoryData',
			data: {
				categoryName: $( this ).closest( '.form-box' ).find( '.category-name' ).val()
			},
			callback: function( data ) {
				console.log( data );
			}
		});
	});
});