/**
 * JS needed for Special:FacebookConnect
 */
$(function () {
	'use strict';

	/**
	 * Controls for Special:FacebookConnect page
	 * @returns {SpecialPage}
	 * @constructor
	 */
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

	/**
	 * Click handler for the form's cancel button
	 * @returns {boolean}
	 */
	SpecialPage.prototype.onCancel = function () {
		var self = this,
			logout;

		// check state
		if (!this.cancelClicked) {

			// confirm that the user actually wants to cancel the connection flow
			logout = window.confirm($.msg('fbconnect-logout-confirm'));
			if (logout) {

				// save state - user has clicked on the cancel button once
				self.cancelClicked = true;

				// check if the user is logged in to facebook
				window.FB.getLoginStatus(function (response) {

					// if we're logged in, log them out and resubmit the form, this time with no confirm modal
					if (response.status === 'connected') {
						self.logOut(function () {
							self.$cancel.click();
							self.cancelClicked = false;
						});

					// resubmit the form
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
	 * @param {function} [callback] Function called after user is logged out of facebook
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
