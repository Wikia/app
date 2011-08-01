var SkeleSkin = {
	hideURLBar: function() {
		if ( $.os.android || $.os.ios || $.os.webos ) {
			//slide up the addressbar on webkit mobile browsers for maximum reading area
			//setTimeout is necessary to make it work on ios...
			setTimeout( function() { window.scrollTo( 0, 1 ) }, 100 );
		}
	},
	
	init: function() {
		
		window.onscroll = function() {
	  		$( '#navigation' ).css( 'top', window.pageYOffset + 'px' );
		};
		
		$( '#openToggle' ).bind( "tap", function( event ) {
			$('#navigation').toggleClass( 'open' );
		});
	}
}

$(document).ready( function() {
	SkeleSkin.init();
	SkeleSkin.hideURLBar();
});