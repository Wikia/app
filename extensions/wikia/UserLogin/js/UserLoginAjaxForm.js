/*global wgScriptPath, UserBaseAjaxForm */
(function () {
	'use strict';

	var UserLoginAjaxForm = function (el, options) {
		UserBaseAjaxForm.call(this, el, options);
	};

	UserLoginAjaxForm.prototype = Object.create(UserBaseAjaxForm.prototype);

	/**
	 * Callback after ajax login
	 * @param {Object} json Response from server after ajax login
	 */
	UserLoginAjaxForm.prototype.submitLoginHandler = function (json) {
		var result = json.result;

		this.resetValidation();

		if (result === 'ok') {
			this.onOkayResponse();
		} else if (result === 'resetpass') {
			this.onResetPasswordResponse();
		} else if (result === 'unconfirm') {
			this.onUnconfirmedEmailResponse();
		} else if (result === 'closurerequested') {
			this.onAccountClosureReqestResponse();
		} else {
			this.onErrorResponse();
		}
	};

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

	UserLoginAjaxForm.prototype.onAccountClosureReqestResponse = function () {
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'UserLoginSpecial',
			method: 'getCloseAccountRedirectUrl',
			format: 'json'
		}, function (data) {
			window.location = data.redirectUrl;
		});
	};

	UserLoginAjaxForm.prototype.retrieveTemplateCallback = function (html) {
		var content = $('<div>').hide().append(html),
			form = this.form;

		form.slideUp(400, function () {
			form.replaceWith(content);
			content.slideDown(400);
		});
	};

	/**
	 * Get login token from back end
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
