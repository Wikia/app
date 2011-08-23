$(document).ready(function() {
	iPadImprovements.init();
});

iPadImprovements = {
	
	init: function() {
		
		//onload scroll to main content
		wikiaMainContent = $( '#WikiaMainContent' ).offset();
		window.scrollTo( 0, wikiaMainContent.top );

		//global nav fix: first click opens nav,  second redirects to a hub
		$( '#GlobalNavigation' ).delegate( 'li > a', 'click', function( event ) {
			var next = $( this ).next();
			if ( next.hasClass( 'subnav' ) && !next.hasClass( 'show' ) ) {
				event.preventDefault();
			};
		});

		//wiki nav fix: first click opens nav, second redirects to a desired page
		$( '#WikiHeader' ).delegate( 'nav > ul > li > a', 'click', function() {
			subnav = $( this ).next( 'ul.subnav' );
			if ( subnav.length && subnav.css( 'display' ) != 'block') {
				event.preventDefault();
			};
		});
		
		//user menu fix:
		$( '#AccountNavigation' ).delegate( 'a', 'click', function( event ) {
			var next = $( this ).next();
			if ( next.hasClass( 'subnav' ) && !next.hasClass( 'show' ) ) {
				event.preventDefault();
			};
		});
	}
};
