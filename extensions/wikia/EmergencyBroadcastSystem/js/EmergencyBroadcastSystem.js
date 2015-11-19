(function ($) {
	'use strict';

	function init() {
		$('.ebs-primary-action').click(onClickYes);
		$('.ebs-secondary-action').click(onClickNo);
	}

	function onClickYes() {
		$.nirvana.postJson('EmergencyBroadcastSystemController', 'saveUserResponse', 1, function(response){ alert('success yes'); }, function(response){ alert('error yes'); });
		hideEBS();
	}

	function onClickNo() {
		$.nirvana.postJson('EmergencyBroadcastSystemController', 'saveUserResponse', 0, function(response){ alert('success no'); }, function(response){ alert('error no'); });
		hideEBS();
	}

	function hideEBS() {
		$('.ebs-container').hide();
	}

	init();
})(jQuery);
