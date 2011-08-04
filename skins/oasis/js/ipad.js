iPadImprovements = {
	
	WikiaMainContentWidth: 800,
	
	handleZoom: function() {
		if( Orientation.getOrientation() == "portrait" ) {
			$("meta[name=viewport]").attr('content', 'width=device-width');
			WikiaMainContentWidth = $( '#WikiaMainContent' ).width();
			$( '#WikiaMainContent' ).width( Orientation.getWidth() - 50 );
			
			$( '#WikiaRail' ).hide();
		} else {
			$("meta[name=viewport]").attr('content', 'width=device-width');
			$( '#WikiaMainContent' ).width( WikiaMainContentWidth );
			$( '#WikiaRail' ).show();
		}
	},
	
	init: function() {

		iPadImprovements.handleZoom();
		Orientation.bindEventListener( iPadImprovements.handleZoom );
	
		//handle  scroll to #WikiaMainContent
		wikiaMainContentOffset = $('#WikiaMainContent' ).offset();
		window.scrollTo( wikiaMainContentOffset.left , wikiaMainContentOffset.top );
	
		//global nav fix first click opens nav second goes to hub
		$( "#WikiaHeader #GlobalNavigation > li > a" ).live( 'click', function( event ) {
			if ( !$( this ).next().hasClass( 'show' ) ) {
				event.preventDefault();
				$( this ).next().addClass( 'show' );
			}
		});
		
		$('#WikiHeader nav > ul > li > a').live('click', function() {
			if ( $( this ).next( '.subnav' ).css( 'display' ) != 'block' ) {
				event.preventDefault();
				$( this ).next().css( 'display', 'block' );
			}
		});
		}
	}
}

$(document).ready(function() {
	iPadImprovements.init();
});
