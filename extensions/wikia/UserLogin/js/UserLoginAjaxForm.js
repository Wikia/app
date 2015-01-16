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
	 * Callback after ajax login
	 * @param {Object} json Response from server after ajax login
	 */
	UserLoginAjaxForm.prototype.submitLoginHandler = function (json) {
		var result = json.result;

		UserBaseAjaxForm.prototype.submitLoginHandler.call(this, json);

		if (result === 'resetpass') {
			this.onResetPasswordResponse();
		} else if (result === 'unconfirm') {
			this.onUnconfirmedEmailResponse();
		} else if (result === 'closurerequested') {
			this.onAccountClosureReqestResponse();
		} else {
			this.onErrorResponse();
		}
	};

	/**
	 * Called when a user has requested a password change
	 * @param {Object} json Response from server
	 */
	UserLoginAjaxForm.prototype.onResetPasswordResponse = function (json) {
		var callback = this.options.resetpasscallback || '';
		if (callback && typeof callback === 'function') {
			// call with current context
			callback.bind(this, json)();
		} else {
			// default implementation
			$.post(wgScriptPath + '/wikia.php', {
				controller: 'UserLoginSpecial',
				method: 'changePassword',
				format: 'html',
				username: this.inputs.username.val(),
				password: this.inputs.password.val(),
				returnto: this.inputs.returnto.val(),
				fakeGet: 1
			}, this.retrieveTemplateCallback.bind(this));
		}
	};

	UserLoginAjaxForm.prototype.onUnconfirmedEmailResponse = function () {
		$.get(wgScriptPath + '/wikia.php', {
			controller: 'UserLoginSpecial',
			method: 'getUnconfirmedUserRedirectUrl',
			format: 'json',
			username: this.inputs.username.val()
		}, function (json) {
			window.location = json.redirectUrl;
		});
	};

	/**
	 * Called after a user has requested an account closer.
	 * @TODO: Not sure what user actions are taken for this to be called.
	 */
	UserLoginAjaxForm.prototype.onAccountClosureReqestResponse = function () {
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
		var content = $('<div>').hide().append(html),
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
