jQuery(function($) {
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
			callback: function(html) {

				var parent, container, railWidth;

				$(window.skin === 'oasis' ? '#WikiaMainContent' : '#bodyContent').before($(html));

				container = $('#ContentWarning' );

				parent = container.parent();

				railWidth = ($('#WikiaRail').width() || 0) + 50;

				container.width(parent.width() - railWidth);
				// User acknowledges the content warning message and wishes to proceed
				container.on('click', '#ContentWarningApprove', function() {

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

					// Anonymous user
					} else {
						afterApproved();
					}

					$.cookies.set('ContentWarningApproved', '1', {
						hoursToLive: 24,
						domain: wgServer.split('/')[2]
					});
				});
			}
		});
	}
});
