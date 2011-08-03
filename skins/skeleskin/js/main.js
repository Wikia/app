var SkeleSkin = {
	hideURLBar: function() {
		if ( $.os.android || $.os.ios || $.os.webos ) {
			//slide up the addressbar on webkit mobile browsers for maximum reading area
			//setTimeout is necessary to make it work on ios...
			setTimeout( function() { window.scrollTo( 0, 1 ) }, 100 );
		}
	},
	
	init: function() {
		
		if( localStorage['open'] === 'true' ) {
			$('#navigation').addClass( 'open' );
		}
		
		
		window.onscroll = function() {
	  		$( '#navigation' ).css( 'top', window.pageYOffset + 'px' );
		};

		$( '#openToggle' ).bind( "tap, click", function( event ) {
			$('#navigation').toggleClass( 'open' );
			if( $('#navigation').hasClass( 'open' ) ) {
				localStorage['open'] = 'true';
			} else {
				localStorage['open'] = 'false';
			}
			$( '#loginForm, #searchForm').hide();
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
      	
      	$( '#refreshMe' ).live( "tap, click", function() {
			location.reload(true);
      	});
      	
       	$( '#login' ).live( "tap, click", function() {
			$( '#navigation' ).addClass( 'open' );
			$( '#searchForm').hide();
			$( '#loginForm').show();
      	});
      	
      	$( '#search' ).live( "tap, click", function() {
			$( '#navigation' ).addClass( 'open' );
			$( '#loginForm').hide();
			$( '#searchForm').show();
      	});
	},
	
	handleOrientation: function() {
		if( $.os.android ) {
			width = Orientation.getWidth();
			if ( Orientation.getOrientation() == 'portrait' ) {
				$( '#navigation' ).css( { 'min-width': '100px', 'min-height': '50px' } );
			} else {
				if ( width < 320 ) {
					$( '#navigation' ).css( { 'min-height': ( width - 20 ) + 'px', 'min-width': '50px' } );
				} else if ( width == 320 ) {
					$( '#navigation' ).css( { 'min-height': ( width - 25 ) + 'px', 'min-width': '50px' } );
				} else {
					$( '#navigation' ).css( { 'min-height': ( width - 38 ) + 'px', 'min-width': '50px' } );
				}
			}
		}
	}
}

$( document ).ready( function() {
	SkeleSkin.hideURLBar();
	SkeleSkin.init();
	Orientation.bindEventListener( SkeleSkin.handleOrientation );
});