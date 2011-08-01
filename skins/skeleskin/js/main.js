var SkeleSkin = {
	hideURLBar: function() {
		if( $.os.android || $.os.ios || $.os.webos ) {
				//slide up the addressbar on webkit mobile browsers for maximum reading area
				//setTimeout is necessary to make it work on ios...
				setTimeout( function() { window.scrollTo( 0, 1 ) }, 10 );
		}
	},
	
	handleOrientation: function() {
		if ( Orientation.getOrientation() === "portrait" ) {
			$( '#navigation' ).removeClass( 'side' ).addClass( 'top' );
			$( 'body' ).css( 'margin', '55px 0 0 0' );
			if( $( '#navigation' ).hasClass( 'open' ) ) {
				$( '#arrow' ).removeClass( 'down right left' ).addClass( 'up' );
			} else {
				$( '#arrow' ).removeClass( 'up left right' ).addClass( 'down' );
			};		
		} else {
			$( '#navigation' ).removeClass( 'top' ).addClass( 'side' );
			$( 'body' ).css( 'margin', '0 0 0 55px' );
			if( $( '#navigation' ).hasClass( 'open' ) ) {
				$( '#arrow' ).removeClass( 'down right up' ).addClass( 'left' );
			} else {
				$( '#arrow' ).removeClass( 'up down left' ).addClass( 'right' );
			};
		}
	},
	
	init: function() {
		
		if( Orientation.getOrientation() === "portrait" ) {
			$( '#navigation' ).addClass( 'top' );
			$('body').css( 'margin', '55px 0 0 0' );
			$( '#arrow' ).removeClass( 'up right left' ).addClass( 'down' );
		} else {
			$( '#navigation' ).addClass( 'side' );
			$('body').css( 'margin', '0 0 0 55px' );
			$( '#arrow' ).removeClass( 'up down left' ).addClass( 'right' );
		}
		
		window.onscroll = function() {
	  		$( '#navigation' ).css( 'top', window.pageYOffset + 'px' );
		};
		
		$( '#navigation' ).bind( 'touchmove', function( event ) {
			event.preventDefault();
		});
		
		$( '#openToggle' ).bind( "tap", function() {
			if( $( '#navigation' ).hasClass( 'open' ) ) {
				$( '#navigation' ).removeClass( 'open' );
				$( '#openNavigationContent' ).hide();
				$( '#closeNavigationContent' ).show();
				
				if( $( '#navigation' ).hasClass( 'top' ) ) {
					$( '#arrow' ).removeClass( 'up right left' ).addClass( 'down' );
				} else {
					$( '#arrow' ).removeClass( 'up down left' ).addClass( 'right' );
				}
			} else {
				$( '#navigation').addClass( 'open' );
				$( '#closeNavigationContent' ).hide();
				$( '#openNavigationContent' ).show();
				
				if( $( '#navigation' ).hasClass( 'top' ) ) {
					$( '#arrow' ).removeClass( 'down right left' ).addClass( 'up' );
				} else {
					$( '#arrow' ).removeClass( 'up down right' ).addClass( 'left' );
				}
			}
		});
	}
}

$(document).ready( function() {
	SkeleSkin.init();
	Orientation.bindEventListener( SkeleSkin.handleOrientation() );
});