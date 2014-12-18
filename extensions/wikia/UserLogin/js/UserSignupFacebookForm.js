/* global UserLoginAjaxForm */
(function () {
	'use strict';

	// TODO: Base this off of UserSignupAjaxForm UC-200
	var UserSignupFacebookForm = $.createClass(UserLoginAjaxForm, {

		init: function () {
			UserLoginAjaxForm.prototype.init.call(this);
			this.initOptIn();
			this.setCountryValue();
		},

		/**
		 * Login token is stored in hidden field, no need to send an extra request
		 */
		retrieveLoginToken: function () {},

		/**
		 * Send ajax login request to FB controller. Overrides parent method.
		 */
		ajaxLogin: function () {
			// TODO: jquery has a form serialization method we can use
			// so we don't have to list every input here
			// note: we'd have to update logintoken to signuptoken

			var values = {
				username: this.inputs.username.val(),
				password: this.inputs.password.val(),
				signupToken: this.inputs.logintoken.val(),
				wpRegistrationCountry: Wikia.geo.getCountryCode()
			};

			// cache redirect url for after form is complete
			this.returnToUrl = this.inputs.returntourl.val();

			// The email box will only appear if the user has not shared their Facebook email
			if (this.inputs.email) {
				values.email = this.inputs.email.val();
			}


			$.nirvana.postJson(
				'FacebookSignupController',
				'signup',
				values,
				this.submitFbSignupHandler.bind(this)
			);
		},

		/**
		 * Extends login handler callback for tracking and any additional work
		 * @param {Object} response Response object from FacebookSignupController::signup
		 */
		submitFbSignupHandler: function (response) {
			if (response.result === 'ok') {
				window.Wikia.Tracker.track({
					category: 'user-sign-up',
					trackingMethod: 'both',
					action: window.Wikia.Tracker.ACTIONS.SUCCESS,
					label: 'facebook-signup'
				});
			}
			this.submitLoginHandler(response);
		},

		/**
		 * Handle marketing email opt-in for different locales
		 * @todo: Once this is based off of UserSignupAjaxForm.js, but this in the base class (UC-200)
		 */
		initOptIn: function () {
			var self = this;

			require(['usersignup.marketingOptIn'], function (optIn) {
				optIn.init(self.wikiaForm);
			});
		},
		/**
		 * Send country code upon signup
		 * @todo: Once this is based off of UserSignupAjaxForm.js, but this in the base class (UC-200)
		 */
		setCountryValue: function () {
			var country = Wikia.geo.getCountryCode();
			this.wikiaForm.inputs.wpRegistrationCountry.val(country);
		}

	});

	window.UserSignupFacebookForm = UserSignupFacebookForm;
})();
