/**
 * JS needed for Special:FacebookConnect
 */
$(function () {
	'use strict';

	function SpecialPage() {
		this.$cancel = $('#wpCancel');
		this.cancelClicked = false;
		return this;
	}

	SpecialPage.prototype.init = function () {
		this.bindEvents();
	};

	SpecialPage.prototype.bindEvents = function () {
		this.$cancel.on('click', this.onCancel.bind(this));
	};

	SpecialPage.prototype.onCancel = function () {
		var self = this,
			logout;

		if (!this.cancelClicked) {
			logout = window.confirm($.msg('fbconnect-logout-confirm'));
			if (logout) {
				self.cancelClicked = true;
				window.FB.getLoginStatus(function (response) {
					if (response.status === 'connected') {
						self.logOut(function () {
							self.$cancel.click();
							self.cancelClicked = false;
						});
					} else {
						self.$cancel.click();
						self.cancelClicked = false;
					}
				});
			}
			return false;
		} else {
			return true;
		}
	};

	/**
	 * Wrapper for Facebook Logout so we can add tracking and a callback function
	 * @param {function} [callback]
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
});
