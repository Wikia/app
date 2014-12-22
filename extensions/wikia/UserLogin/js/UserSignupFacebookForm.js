/* global UserLoginAjaxForm */
(function () {
	'use strict';

	var UserSignupFacebookForm = $.createClass(UserLoginAjaxForm, {

		init: function () {
			UserLoginAjaxForm.prototype.init.call(this);
			this.initOptIn();
		},

		/**
		 * Login token is stored in hidden field, no need to send an extra request
		 */
		retrieveLoginToken: function () {},

		/**
		 * Send ajax login request to FB controller. Overrides parent method.
		 */
		ajaxLogin: function () {
			var values = {
				username: this.inputs.username.val(),
				password: this.inputs.password.val(),
				signupToken: this.inputs.logintoken.val()
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
		 */
		initOptIn: function () {
			var self = this;

			require(['usersignup.marketingOptIn'], function (optIn) {
				optIn.init(self.wikiaForm);
			});
		}
	});

	window.UserSignupFacebookForm = UserSignupFacebookForm;
})();
