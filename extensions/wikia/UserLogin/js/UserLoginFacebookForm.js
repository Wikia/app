/* global UserLoginAjaxForm */
(function () {
	'use strict';

	var UserLoginFacebookForm = $.createClass(UserLoginAjaxForm, {
		init: function () {
			// this.loginForm needs to be set before calling the super class method
			this.loginForm = this.el.find('.UserLoginFacebookRight form');
			this.loginForm.submit(this.submitLoginExisting.bind(this));

			UserLoginAjaxForm.prototype.init.call(this);
		},

		setInputs: function () {
			UserLoginAjaxForm.prototype.setInputs.call(this);

			this.inputs.loginUsername = this.loginForm.find('input[name=login_username]');
			this.inputs.loginPassword = this.loginForm.find('input[name=login_password]');
		},

		// login token is stored in hidden field, no need to send an extra request
		retrieveLoginToken: function () {},

		submitLoginExisting: function (e) {
			e.preventDefault();
			this.submitButtons.attr('disabled', 'disabled');
			this.loginExisting();
		},

		// Handles existing user login via modal
		loginExisting: function () {
			var values = {
				username: this.inputs.loginUsername.val(),
				password: this.inputs.loginPassword.val(),
				signupToken: this.inputs.logintoken.val()
			};

			// cache redirect url for after form is complete
			this.returnToUrl = this.inputs.returntourl.val();

			$.nirvana.postJson(
				'FacebookSignupController',
				'login',
				values,
				this.submitFbLoginHandler.bind(this)
			);
		},

		submitFbLoginHandler: function (json) {
			this.form.find('.error-msg').remove();
			this.form.find('.input-group').removeClass('error');
			var result = json.result,
				callback;

			if (result === 'ok') {
				window.wgUserName = json.wgUserName;
				callback = this.options.callback || '';
				if (callback && typeof callback === 'function') {
					// call with current context
					callback.bind(this, json)();
				} else {
					window.location.reload();
				}
			} else if (result === 'error') {
				window.GlobalNotification.show(json.message || $.msg('oasis-generic-error'), 'error');
			} else {
				this.submitButtons.removeAttr('disabled');
				this.errorValidation(json);
			}
		},

		// send a request to FB controller
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
		 * @param {string} json
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

	// Expose global
	window.UserLoginFacebookForm = UserLoginFacebookForm;
})();
