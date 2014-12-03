/* global UserLoginAjaxForm */
(function () {
	'use strict';

	var UserSignupFacebookForm = $.createClass(UserLoginAjaxForm, {

		// login token is stored in hidden field, no need to send an extra request
		retrieveLoginToken: function () {},

		/**
		 * Send a request to FB controller
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
		 * @param json string
		 */
		submitFbSignupHandler: function (json) {
			if (json.result === 'ok') {
				window.Wikia.Tracker.track({
					category: 'user-sign-up',
					trackingMethod: 'both',
					action: window.Wikia.Tracker.ACTIONS.SUCCESS,
					label: 'facebook-signup'
				});
			}
			this.submitLoginHandler(json);
		}
	});

	window.UserSignupFacebookForm = UserSignupFacebookForm;
})();
