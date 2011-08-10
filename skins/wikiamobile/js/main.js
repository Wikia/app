var WikiaMobile = {
	hideURLBar: function() {
		if ( $.os.android || $.os.ios || $.os.webos ) {
				//slide up the addressbar on webkit mobile browsers for maximum reading area
				//setTimeout is necessary to make it work on ios...
				setTimeout( function() { window.scrollTo( 0, 1 ) }, 100 );
		}
	},
	
	wrapArticles: function() {
		
	},

	init: function() {
		$( '#openToggle' ).bind( "tap, click", function() {
			$( '#navigation').toggleClass( 'open' );
		});
		
		if($.os.ios) {
			$( '#navigation' ).addClass( 'ios' );
		};

		$( '#navigationMenu > li' ).bind( "tap, click", function() {
			if ( !( $( this ).hasClass( 'openMenu' ) ) ) {
				
				$( '#navigationMenu > li' ).removeClass( 'openMenu' );
				$( this ).addClass( 'openMenu' );
				
				tab = "#" + $( this ).text().toLowerCase() + "Tab";
				$( '#openNavigationContent > div.navigationTab' ).removeClass( 'openTab' );
				$( tab ).addClass( 'openTab' );
			}
		});
		
		$( '#toctitle' ).bind( 'tap, click', function() {
			$( 'table#toc ul' ).toggleClass( 'visible' );
		});
		
		$( 'table#toc li' ).bind( 'tap, click', function( event ) {
			$( this ).children( 'a' ).trigger( 'click' );
			event.stopPropagation();
		});
	}
}

$( document ).ready( function() {
	WikiaMobile.hideURLBar();
	WikiaMobile.wrapArticles();
	WikiaMobile.init();
});