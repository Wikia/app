/*global jQuery, window*/
jQuery(function ($) {
	'use strict';
	// Hide content warning, show content
	function afterApproved() {
		$('body').removeClass('ShowContentWarning');
	}

	// This variable is injected into the page via a hook script.
	// @see ContentWarningHooks.class.php
	if (!window.wgContentWarningApproved) {

		// Get the template for the content warning message
		$.nirvana.sendRequest({
			controller: 'ContentWarningController',
			method: 'index',
			format: 'html',
			type: 'GET',
			callback: function (html) {
				$(window.skin === 'oasis' ? '#WikiaMainContent' : '#bodyContent').before($(html));

				// User acknowledges the content warning message and wishes to proceed
				$('#ContentWarning').on('click', '#ContentWarningApprove', function () {
					// Logged in user
					if (window.wgUserName) {
						$.nirvana.sendRequest({
							controller: 'ContentWarningController',
							method: 'approveContentWarning',
							data: {},
							type: 'POST',
							format: 'json',
							callback: afterApproved
						});
					} else {
						// Anonymous user
						afterApproved();
					}

					$.cookies.set('ContentWarningApproved', '1', {
						hoursToLive: 24
					});
				});
			}
		});
	}
});
