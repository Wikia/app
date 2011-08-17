$(document).ready(function() {
	iPadImprovements.init();
});

iPadImprovements = {
	
	setViewPort: function() {
		var content = 'width=1024, initial-scale=1.0';
		if ( Orientation.getOrientation() == 'portrait' ) {
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
		$( '#WikiaHeader #GlobalNavigation > li > a' ).live( 'click', function( event ) {
			if ( !$( this ).next().hasClass( 'show' ) ) {
				$( this ).next().addClass( 'show' );
				event.preventDefault();
			};
		});

		//wiki nav fix: first click opens nav, second redirects to a desired page
		$( '#WikiHeader nav > ul > li > a' ).live( 'click', function() {
			subnav = $( this ).next( 'ul.subnav' );
			if ( $( subnav ).length ) {
				if ( $( subnav ).css( 'display' ) != 'block' ) {
					$( subnav ).css( 'display', 'block' );
					event.preventDefault();
				};
			};
		});
	}
};
