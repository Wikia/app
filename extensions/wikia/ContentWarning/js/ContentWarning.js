(function(window) {

	// This variable is injected into the page via a hook script.
	// @see ContentWarningHooks.class.php
	if (!window.wgContentWarningApproved) {

		// Hide content warning, show content
		function afterApproved() {
			$('body').removeClass('ShowContentWarning');
		}

		// Get the template for the content warning message
		$.nirvana.sendRequest({
			controller: 'ContentWarningController',
			method: 'index',
			format: 'html',
			callback: function(html) {
				$(window.skin == 'monobook' ? '#bodyContent' : '#WikiaMainContent').before($(html));

				// User acknowledges the content warning message and wishes to proceed
				$('#ContentWarningApprove').click(function() {

					// Logged in user
					if (window.wgUserName) {
						$.nirvana.sendRequest({
							controller: 'ContentWarningController',
							method: 'approveContentWarning',
							data: {},
							type: "POST",
							format: 'json',
							callback: afterApproved
						});

					// Anonymous user
					} else {
						$.cookies.set('ContentWarningApproved', '1', {
							hoursToLive: 24,		
							domain: wgServer.split('/')[2]
						});

						afterApproved();
					}
				});

				// User does not wish to proceed, send them back to the home page
				$('#ContentWarningCancel').click(function() {
					window.location = 'http://www.wikia.com';
				});
			}
		});
	}
})(this);