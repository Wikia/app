var WikiaMobile = {
	hideURLBar: function() {
		if ( $.os.android || $.os.ios || $.os.webos ) {
			//slide up the addressbar on webkit mobile browsers for maximum reading area
			//setTimeout is necessary to make it work on ios...
			setTimeout( function() { window.scrollTo( 0, 1 ) }, 100 );
		}
	},
	
	init: function() {
		$( '#openToggle' ).bind( "tap, click", function() {
			$( '#navigation, body').toggleClass( 'open' );
		});
		
		if($.os.ios) {
			$( '#navigation' ).addClass( 'ios' );
		};

		$( '#navigationMenu > li' ).bind( "tap, click", function() {

		});
	}
}

$( document ).ready( function() {
	WikiaMobile.hideURLBar();
	WikiaMobile.init();
});