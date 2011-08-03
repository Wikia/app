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

		$( '#openToggle' ).bind( "tap, click", function( event ) {
			$('#navigation').toggleClass( 'open' );
		});
		
		if($.os.ios) {
			$( '#navigation' ).addClass( 'ios' );
		}
		
		$( '#nextHeading' ).live( "tap, click", function( event ) {
			$( 'h3' ).each( function( i, h3 ) {
				offset = $(h3).offset().top - 55;
				if ( offset > window.pageYOffset ) {
					window.scrollTo( 0, offset + 1 );
					$( '#navigation' ).css( 'top', window.pageYOffset + 'px' );

					return false;
				}
			});
      	});
      	
      	$( '#prevHeading' ).live( "tap, click", function( event ) {
			$( 'h3' ).each( function( i, h3 ) {
				offset = $(h3).offset().top - 55;
				if( offset < window.pageYOffset ) {
					window.scrollTo( 0, offset + 1 );
					$( '#navigation' ).css( 'top', window.pageYOffset + 'px' );
					return false;
				}
			});
      	});
	}
}

$( document ).ready( function() {
	SkeleSkin.hideURLBar();
	SkeleSkin.init();
});