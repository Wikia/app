iPadImprovements = {
	init: function() {
		if (  ) {
			if( navigator.platform.indexOf("iPad") != -1 ) {
				
				//handle zoom and scroll to #WikiaMainContent
				$("meta[name=viewport]").attr('content', 'width=device-width, height=device-height, initial-scale=1.0, maximum-scale=4.0, min-scale=1.2');
				wikiaMainContentOffset = $('#WikiaMainContent' ).offset();
				window.scrollTo( wikiaMainContentOffset.left , wikiaMainContentOffset.top );
				
				//Iterates through global nav and add links to subnav and move spotlights into right position
				$( "#WikiaHeader #GlobalNavigation > li" ).each( function( i ) {
					hub = $(this).find( 'a' ).first().text();
					$( this ).find( '#SPOTLIGHT_GLOBALNAV_' + (++i) ).remove();
					$( this ).find( '.subnav' ).prepend( '<li><a href="http://www.wikia.com/' + hub + '">Top ' + hub + ' Wikis</a><ul class="catnav"><li id="SPOTLIGHT_GLOBALNAV_' + i + '" class="SPOTLIGHT_GLOBALNAV"></li></ul></li>' );
				});
	
				$( "#WikiaHeader #GlobalNavigation > li > a" ).live( 'click', function( event ) {
					event.preventDefault();
					$( this ).next().toggleClass( 'show' );
				});
			}
		}
	}
}

$(document).ready(function() {
	iPadImprovements.init();
});
