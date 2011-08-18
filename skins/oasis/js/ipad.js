$(document).ready(function() {
	iPadImprovements.init();
});

iPadImprovements = {
	
	setViewPort: function() {
		var content = 'width=1024, initial-scale=1.0';

		if ( window.orientation == 0  || window.orientation == 180 ) {
			if( sassParams.hd ) {
				content = 'width=1024, initial-scale=0.87';
			} else {
				content = 'width=1024, initial-scale=1.09';
			}
		}
		$( 'meta[name=viewport]' ).attr( 'content', content );
	},
	
	init: function() {
		
		//onload add proper viewport
		iPadImprovements.setViewPort();
		
		//onload scroll to main content
		wikiaMainContent = $( '#WikiaMainContent' ).offset();
		window.scrollTo( 0, wikiaMainContent.top );

		//global nav fix: first click opens nav,  second redirects to a hub
		$( '#GlobalNavigation' ).delegate( 'li > a', 'click', function( event ) {
			var next = $( this ).next();
			if ( next.hasClass( 'subnav' ) && !next.hasClass( 'show' ) ) {
				event.preventDefault();
				next.addClass( 'show' );

			};
		});

		//wiki nav fix: first click opens nav, second redirects to a desired page
		$( '#WikiHeader' ).delegate( 'nav > ul > li > a', 'click', function() {
			subnav = $( this ).next( 'ul.subnav' );
			if ( subnav.length ) {
				if ( subnav.css( 'display' ) != 'block' ) {
					event.preventDefault();
					subnav.css( 'display', 'block' );
				};
			};
		});
	}
};
