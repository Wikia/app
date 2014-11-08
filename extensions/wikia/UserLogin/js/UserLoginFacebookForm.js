var UserLoginFacebookForm = $.createClass(UserLoginAjaxForm, {

	// login token is stored in hidden field, no need to send an extra request
	retrieveLoginToken: function() {},

	// send a request to FB controller
	ajaxLogin: function() {
		'use strict';
		var inputs = {
			username: this.inputs.username.val(),
			password: this.inputs.password.val(),
			signupToken: this.inputs.logintoken.val(),
			returnto: encodeURIComponent(window.wgPageName),
			returntoquery: encodeURIComponent(window.location.search.substring(1))
		};

		// The email box will only appear if the user has not shared their Facebook email
		if ( this.inputs.email ) {
			inputs.email = this.inputs.email.val();
		}

		$.nirvana.postJson('FacebookSignupController', 'signup', inputs, $.proxy(this.submitFbSignupHandler, this));
	},

	/**
	 * Extends login handler callback for tracking and any additional work
	 * @param json
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
		json.returnto = encodeURIComponent(window.wgPageName);
		json.returntoquery = encodeURIComponent(window.location.search.substring(1));
		this.submitLoginHandler(json);
	}
});
