$(function () {
	'use strict';

	/**
	 * JS for handling captchas. We default to using reCaptcha, however if we encounter any problems, will
	 * fall back to using Fancy Captcha instead.
	 */
	var Captcha = {
		/**
		 * WikiaMobile, Wikia One, and some automated tests do not use captcha. This is specific to the
		 * user signup extension.
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
		 * If the user is performing an action where captcha is required (eg registerinn, including an external link
		 * when editing as anon, etc) and it fails to load (possibly b/c google is blocked in China), fall back
		 * to Fancy Captcha. Note, this is different from when a user fails the captcha test itself.
		 */
		handleCaptchaLoadError: function () {
			this.loadAndInsertFancyCaptcha();
			this.trackFailedReCaptcha();
		},

		loadAndInsertFancyCaptcha: function () {
			$.when(
				$.getResources([
					$.getSassCommonURL('extensions/wikia/Captcha/styles/FancyCaptcha.scss')
				])
			).done(
				$.nirvana.sendRequest({
					controller: 'CaptchaController',
					method: 'getFancyCaptcha',
					type: 'GET',
					callback: function (data) {
						this.insertFancyCaptcha(data);
					}.bind(this)
				})
			);
		},

		insertFancyCaptcha: function (data) {
			$('.g-recaptcha').replaceWith(data.form);
		},

		trackFailedReCaptcha: function () {
			Wikia.Tracker.track({
				action: Wikia.Tracker.ACTIONS.ERROR,
				category: 'captcha',
				label: 'captcha-load-fail',
				trackingMethod: 'analytics',
				country: Wikia.geo.getCountryCode()
			});
		}
	};

	Captcha.init();
});
