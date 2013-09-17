var SpecialStyleguide = function() {};

SpecialStyleguide.prototype = {
	CLASS_HIDDEN: 'hidden',
	CLASS_SHOWN: 'shown',

	init: function() {
		$( '.toggleParameters' ).click( $.proxy( function( event ) {
			event.preventDefault();

			var $link = $( event.target ),
				$paramsTable = $link.closest('h4').next( '.styleguide-component-params'),
				previousClass = '',
				currentClass = '',
				message = '';

			if( $paramsTable.hasClass( this.CLASS_HIDDEN ) ) {
				currentClass = this.CLASS_SHOWN;
				previousClass = this.CLASS_HIDDEN;
				message = $.msg( 'styleguide-hide-parameters' );
			} else {
				currentClass = this.CLASS_HIDDEN;
				previousClass = this.CLASS_SHOWN;
				message = $.msg( 'styleguide-show-parameters' );
			}

			$link.text( message );
			$paramsTable.removeClass( previousClass );
			$paramsTable.addClass( currentClass );
		}, this) );
	}
};

var SpecialStyleguideInstance = new SpecialStyleguide();
$(function () {
	SpecialStyleguideInstance.init();
});
