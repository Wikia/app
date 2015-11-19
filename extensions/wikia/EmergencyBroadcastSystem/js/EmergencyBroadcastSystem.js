(function ($) {
	'use strict';

	function init() {
		$('.ebs-primary-action').click(function(){ handleClick( 1 ); });
		$('.ebs-secondary-action').click(function(){ handleClick( 0 ); });
	}

	function handleClick( val ) {
		$.nirvana.postJson('EmergencyBroadcastSystemController', 'saveUserResponse', val,
			function( response ) {
				console.log('Successfully saved user EBS response.');
			},
			function( response ) {
				console.error('Error saving user EBS response.');
			});
		hideEBS();
	}

	function hideEBS() {
		$('.ebs-container').hide();
	}

	init();
})(jQuery);
