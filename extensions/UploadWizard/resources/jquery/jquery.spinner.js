( function( $ ) {
	/**
	 * Set a given selector html to the loading spinner:
	 */
	$.fn.loadingSpinner = function( ) {
		if ( this.length ) {
			this.html(
				$( '<div />' ).addClass( 'loadingSpinner' )
			);
		}
		return this;
	};
	/**
	 * Add an absolute overlay spinner useful for cases where the
	 * element does not display child elements, ( images, video )
	 */
	$.fn.getAbsoluteOverlaySpinner = function(){
		var pos = $( this ).offset();				
		var posLeft = (  $( this ).width() ) ? 
			parseInt( pos.left + ( .4 * $( this ).width() ) ) : 
			pos.left + 30;
			
		var posTop = (  $( this ).height() ) ? 
			parseInt( pos.top + ( .4 * $( this ).height() ) ) : 
			pos.top + 30;
		
		var $spinner = $('<div />')
			.loadingSpinner()				
			.css({
				'width' : 32,
				'height' : 32,
				'position': 'absolute',
				'top' : posTop + 'px',
				'left' : posLeft + 'px'
			});
		$('body').append( $spinner	);
		return $spinner;
	}
} )( jQuery );
