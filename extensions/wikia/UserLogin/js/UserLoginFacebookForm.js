var UserLoginFacebookForm = $.createClass(UserLoginAjaxForm, {

	// login token is stored in hidden field, no need to send an extra request
	retrieveLoginToken: function () {},

	submitLoginExisting: function () {
		'use strict';

		$(window).trigger('loginExistingSubmit');

		this.submitButton.attr('disabled', 'disabled');
		this.loginExisting();
	},

	// Handles existing user login via modal
	loginExisting: function () {
		'use strict';
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
		'use strict';

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
			}
		} else {
			this.submitButton.removeAttr('disabled');
			this.errorValidation(json);
		}
	},

	// send a request to FB controller
	ajaxLogin: function () {
		'use strict';
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
		'use strict';
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
