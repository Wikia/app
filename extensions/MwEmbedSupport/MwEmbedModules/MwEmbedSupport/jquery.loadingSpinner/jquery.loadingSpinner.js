( function( $ ) {
	/**
	 * Set a given selector html to the loading spinner:
	 */
	$.fn.loadingSpinner = function( options ) {
		// empty the target: 
		$(this).empty();
		
		// If we have LoadingSpinner.ImageUrl use that:
		if( mw.getConfig('LoadingSpinner.ImageUrl') ) {
			this.each(function() {
				var $this = $(this).empty();
				var thisSpinner = $this.data('spinner');
				if (thisSpinner) {
					$this.data('spinner', null);
					delete thisSpinner;
				}
				if (opts !== false) {
					var $loadingSpinner = $('<img />').attr("src", mw.getConfig('LoadingSpinner.ImageUrl')).load(function() {
						// Set spinner position based on image dimension
						$( this ).css({
							'margin-top': '-' + (this.height/2) + 'px',
							'margin-left': '-' + (this.width/2) + 'px'
						});
					});
					thisSpinner = $this.append($loadingSpinner);
				}
			});
			return this;
		}
		
		// Else, use Spin.js
		if(!options)
			options = {};
		options = $.extend( {'color' : '#eee', 'shadow': true }, options);
		this.each(function() {
			var $this = $(this).empty();
			var thisSpinner = $this.data('spinner');
			if (thisSpinner) {
				thisSpinner.stop();
				delete thisSpinner;
			}
			if (options !== false) {
				thisSpinner = new Spinner($.extend({color: $this.css('color')}, options)).spin(this);
			}
		});
		// correct the position: 
		return this;
	};
	/**
	 * Add an absolute overlay spinner useful for cases where the
	 * element does not display child elements, ( images, video )
	 */
	$.fn.getAbsoluteOverlaySpinner = function(){
		var pos = $( this ).offset();				
		var posLeft = (  $( this ).width() ) ? 
			parseInt( pos.left + ( .5 * $( this ).width() ) -16 ) : 
			pos.left + 30;
			
		var posTop = (  $( this ).height() ) ? 
			parseInt( pos.top + ( .5 * $( this ).height() ) -16 ) : 
			pos.top + 30;
		
		var $spinner = $('<div />')
			.addClass('absoluteOverlaySpinner')
			.loadingSpinner()				
			.css({
				'position' : 'absolute',
				'top' : posTop + 'px',
				'left' : posLeft + 'px'
			});
		$('body').append( $spinner	);
		return $spinner;
	};	
	
} )( jQuery );

