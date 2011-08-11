var WikiaMobile = {
	hideURLBar: function() {
		if ( $.os.android || $.os.ios || $.os.webos ) {
				//slide up the addressbar on webkit mobile browsers for maximum reading area
				//setTimeout is necessary to make it work on ios...
				setTimeout( function() { window.scrollTo( 0, 1 ) }, 100 );
		}
	},
	
	wrapArticles: function() {
		// $( '#WikiaMainContent > h2' ).each( function() {
			// var element = $(this).next(),
			// collection = new Array();
// 			
			// while( !( $( element ).is( 'h2' ) ) || $( element ) != 'undefined'  ) {
// 				
				// collection.push(element);
				// velement = $(element).next();
			// }
// 			
			// alert(collection);
		// });
	},

	init: function() {
		$( '#openToggle' ).bind( "tap, click", function() {
			$( '#navigation').toggleClass( 'open' );
		});

		$( '#navigationMenu > li' ).bind( "tap, click", function() {
			if ( !( $( this ).hasClass( 'openMenu' ) ) ) {
				
				$( '#navigationMenu > li' ).removeClass( 'openMenu' );
				$( this ).addClass( 'openMenu' );
				
				tab = "#" + $( this ).text().toLowerCase() + "Tab";
				$( '#openNavigationContent > div.navigationTab' ).removeClass( 'openTab' );
				$( tab ).addClass( 'openTab' );
			}
		});
		
		$( '#toctitle' ).append( '<span class=\"arrow\"></span>' );
		
		$( '#toctitle' ).bind( 'tap, click', function() {
			$( 'table#toc ul' ).toggleClass( 'visible' );
			$( '#toctitle' ).toggleClass( 'open' );
		});
	}
}

$( document ).ready( function() {
	WikiaMobile.hideURLBar();
	WikiaMobile.wrapArticles();
	WikiaMobile.init();
});