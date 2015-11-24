(function ($) {
	'use strict';

	function handleClick( val ) {
		$('.ebs-container').hide();
		return $.nirvana.postJson('EmergencyBroadcastSystemController', 'saveUserResponse', { val: val });
	}

	$('.ebs-primary-action').click(function( e ){
		var href = this.href;
		var request = handleClick( 1 );
		request.success( function() {
			window.location = href;
		});
		return false;
	});
	$('.ebs-secondary-action').click(function(){ handleClick( 0 ); return false; });
})(jQuery);
