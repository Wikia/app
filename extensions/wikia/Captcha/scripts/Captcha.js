/* global WikiaForm, UserSignupAjaxValidation, UserSignupMixin */
$(function () {
	'use strict';

	/**
	 * JS for signing up with a new account, on BOTH MOBILE and DESKTOP
	 */
	var Captcha = {
		/**
		 * WikiaMobile, Wikia One, and some automated tests do not use captcha
		 */
		useCaptcha: !window.wgUserSignupDisableCaptcha,

		/**
		 * Enable user signup form with ajax validation
		 */
		init: function () {
			this.loadCaptcha();
		},

		loadCaptcha: function () {
			if (this.useCaptcha) {
				$.loadReCaptcha().fail(
					this.handleCaptchaLoadError.bind(this)
				);
			}
		},

		/**
		 * Captcha is required for signup, so if it fails to load (possibly b/c google is blocked in China)
		 * inform the user with a modal. Note, this is different from when a user fails the captcha test itself.
		 */
		handleCaptchaLoadError: function () {
			this.loadAndInsertFancyCaptcha();
			this.trackFailedReCaptcha();
		},

		loadAndInsertFancyCaptcha: function () {
			$.nirvana.sendRequest({
				controller: 'CaptchaController',
				method: 'getFancyCaptcha',
				type: 'GET',
				callback: function (data) {
					this.insertFancyCaptcha(data);
				}.bind(this)
			});
		},

		insertFancyCaptcha: function (data) {
			$('.g-recaptcha').replaceWith(data.form);
		},

		trackFailedReCaptcha: function () {
			Wikia.Tracker.track({
				action: Wikia.Tracker.ACTIONS.ERROR,
				category: 'user-sign-up',
				label: 'captcha-load-fail',
				trackingMethod: 'both',
				country: Wikia.geo.getCountryCode()
			});
		}
	};

	// Temporarily load captcha library on every page until we have on demand loading set up.
	// Remove with https://wikia-inc.atlassian.net/browse/SOC-288
	Captcha.init();
});
