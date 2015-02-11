/*global wgScriptPath, UserBaseAjaxForm */
(function () {
	'use strict';

	/**
	 * Handle any login forms that are shown dynamically with JS
	 * @param {jQuery} el Wrapping element for the form
	 * @param {Object} options Configuration options for the module
	 * @constructor
	 * @extends UserBaseAjaxForm
	 */
	var UserLoginAjaxForm = function (el, options) {
		UserBaseAjaxForm.call(this, el, options);
	};

	/**
	 * Pull in the base class's functionality
	 * @type {UserBaseAjaxForm.prototype}
	 */
	UserLoginAjaxForm.prototype = Object.create(UserBaseAjaxForm.prototype);

	/**
	 * Set up module functionality
	 */
	UserLoginAjaxForm.prototype.init = function () {
		UserBaseAjaxForm.prototype.init.call(this);
		this.retrieveLoginToken();
	};

	/**
	 * Make the call to the back end to log the user in via ajax
	 */
	UserLoginAjaxForm.prototype.ajaxLogin = function () {
		$.nirvana.postJson(
			'UserLoginSpecial',
			'login',
			{
				loginToken: this.loginToken,
				username: this.inputs[this.usernameInputName].val(),
				password: this.inputs[this.passwordInputName].val(),
				keeploggedin: this.inputs.keeploggedin.is(':checked')
			},
			this.submitLoginHandler.bind(this)
		);
	};

	/**
	 * Callback after ajax login
	 * @param {Object} json Response from server after ajax login
	 */
	UserLoginAjaxForm.prototype.submitLoginHandler = function (json) {
		var result = json.result;

		UserBaseAjaxForm.prototype.submitLoginHandler.call(this, json);

		if (result === 'resetpass') {
			this.onResetPasswordResponse();
		} else if (result === 'closurerequested') {
			this.onAccountClosureRequestResponse();
		} else {
			this.onErrorResponse();
		}
	};

	/**
	 * Called when a user has requested a password change
	 */
	UserLoginAjaxForm.prototype.onResetPasswordResponse = function () {
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'UserLoginSpecial',
			method: 'changePassword',
			format: 'html',
			username: this.inputs[this.usernameInputName].val(),
			password: this.inputs[this.passwordInputName].val(),
			loginToken: this.inputs.loginToken.val(),
			returnto: this.inputs.returnto.val(),
			fakeGet: 1
		}, this.retrieveTemplateCallback.bind(this));
	};

	/**
	 * Called after a user has requested an account closer and then tries to log in with that same account.
	 */
	UserLoginAjaxForm.prototype.onAccountClosureRequestResponse = function () {
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'UserLoginSpecial',
			method: 'getCloseAccountRedirectUrl',
			format: 'json'
		}, function (data) {
			window.location = data.redirectUrl;
		});
	};

	/**
	 * Replace modal's content based on HTML sent from the server.
	 * @param {string} html
	 */
	UserLoginAjaxForm.prototype.retrieveTemplateCallback = function (html) {
		var content, form;

		if (typeof this.options.retrieveTemplateCallback === 'function') {
			this.options.retrieveTemplateCallback(html);
			return;
		}

		content = $('<div>').hide().append(html);
		form = this.form;

		form.slideUp(400, function () {
			form.replaceWith(content);
			content.slideDown(400);
		});
	};

	/**
	 * Get login token from back end and update the form field value
	 * @param {Object} [params]
	 */
	UserLoginAjaxForm.prototype.retrieveLoginToken = function (params) {
		params = params || {};
		if (!this.loginToken || params.clearCache) {
			this.loginToken = 'retrieving';
			$.nirvana.postJson(
				'UserLoginSpecial',
				'retrieveLoginToken',
				function (res) {
					this.loginToken = res.loginToken;
					this.inputs.loginToken.val(res.loginToken);
				}.bind(this)
			);
		}
	};

	// Expose global
	window.UserLoginAjaxForm = UserLoginAjaxForm;
})();
