/**
 * JS needed for Special:FacebookConnect
 */
(function () {
	'use strict';

	function SpecialPage() {
		this.$cancel = $('#wpCancel');
		return this;
	}

	SpecialPage.prototype.init = function () {
		this.bindEvents();
	};

	SpecialPage.prototype.bindEvents = function () {
		var self = this,
			wpCancelClicked = false;

		this.$cancel.click(function(){
			if (!wpCancelClicked) {
				var logout = window.confirm($.msg('fbconnect-logout-confirm'));
				if (logout) {
					wpCancelClicked = true;
					window.FB.getLoginStatus(function(response){
						if (response.status === 'connected' ) {
							self.logOut(function (){
								self.$cancel.click();
							});
						} else {
							self.$cancel.click();
						}
					});
				}
				return false;
			} else {
				return true;
			}
		});
	};

	/**
	 * Wrapper for Facebook Logout
	 * @see UC-18
	 * @param callback
	 */
	SpecialPage.prototype.logOut = function (callback) {
		if (!window.FB) {
			return;
		}

		window.FB.logout(function () {
			window.Wikia.Tracker.track({
				category: 'user-sign-up',
				trackingMethod: 'both',
				action: window.Wikia.Tracker.ACTIONS.SUCCESS,
				label: 'facebook-logout'
			});

			if (typeof callback === 'function') {
				callback();
			}
		});
	};

	// loads the SDK and calls facebook init functions
	$.loadFacebookAPI(function () {
		new SpecialPage().init();
	});
})();
