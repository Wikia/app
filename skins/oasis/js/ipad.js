iPadImprovements = {
	
	init: function() {
		$("meta[name=viewport]").attr('content', 'width=1200, maximum-scale=1.0');

		//global nav fix: first click opens nav, second redirects to a hub
		$( "#WikiaHeader #GlobalNavigation > li > a" ).live( 'click', function( event ) {
			if ( !$( this ).next().hasClass( 'show' ) ) {
				event.preventDefault();
				$( this ).next().addClass( 'show' );
			}
		});
		
		//wikia nav fix: first click opens nav, second redirects to a desired page
		$('#WikiHeader nav > ul > li > a').live('click', function() {
			if ( $( this ).next( '.subnav' ).css( 'display' ) != 'block' ) {
				event.preventDefault();
				$( this ).next().css( 'display', 'block' );
			}
		});
	}
	
}

$(document).ready(function() {
	iPadImprovements.init();
});
