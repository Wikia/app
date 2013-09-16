var SpecialStyleguide = function() {};

SpecialStyleguide.prototype = {
	init: function() {
		$( ".toggleParameters").toggle(
			function() {
				var $link = $(this);
				$link.text( $.msg( 'styleguide-hide-parameters' ) );
				$link.parent().next( '.styleguide-component-params' ).show();
			},
			function() {
				var $link = $(this);
				$link.text( $.msg( 'styleguide-show-parameters' ) );
				$link.parent().next( '.styleguide-component-params' ).hide();
			}
		);
	}
};

var SpecialStyleguideInstance = new SpecialStyleguide();
$(function () {
	SpecialStyleguideInstance.init();
});