var UserLoginFacebookForm = $.createClass(UserLoginAjaxForm, {

	// extend this.inputs storing form fields
	init: function() {
		UserLoginFacebookForm.superclass.init.call(this);

		// FB feed options
		var feedForm = this.form.parent().children('.FacebookSignupConfig');
		this.feedCheckboxes = feedForm.find('input[type="checkbox"]');
	},

	// get selected FB feed options
	getFeedOptions: function() {
		var ret = [],
			feedName,
			feedOptions = this.feedCheckboxes.serializeArray();

		for (var i=0, len = feedOptions.length; i<len; i++) {
			feedName = feedOptions[i].name.split('-').pop();
			ret.push(feedName);
		}

		return ret;
	},

	// login token is stored in hidden field, no need to send an extra request
	retrieveLoginToken: function() {},

	// send a request to FB controller
	ajaxLogin: function() {
		$.nirvana.postJson('FacebookSignupController', 'signup', {
			username: this.inputs.username.val(),
			password: this.inputs.password.val(),
			signupToken: this.inputs.logintoken.val(),
			fbfeedoptions: this.getFeedOptions().join(',')
		},
		$.proxy(this.submitLoginHandler, this));
	}
});
