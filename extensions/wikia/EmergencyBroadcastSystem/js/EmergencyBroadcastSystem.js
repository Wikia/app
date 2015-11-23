(function ($) {
	'use strict';

	function handleClick( val ) {
		$.nirvana.postJson('EmergencyBroadcastSystemController', 'saveUserResponse', { val: val });
		$('.ebs-container').hide();
	}

	$('.ebs-primary-action').click(function(){ handleClick( 1 ); return false; });
	$('.ebs-secondary-action').click(function(){ handleClick( 0 ); return false; });
})(jQuery);
