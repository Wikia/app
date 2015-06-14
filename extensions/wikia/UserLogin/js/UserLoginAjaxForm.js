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
			this.onResetPasswordResponse(json);
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
		$.nirvana.sendRequest({
			controller: 'UserLoginSpecial',
			method: 'changePassword',
			format: 'html',
			data: {
				username: this.inputs.username.val(),
				password: this.inputs.password.val(),
				loginToken: this.inputs.loginToken.val(),
				returnto: this.inputs.returnto.val(),
				fakeGet: 1
			},
			callback: this.setupChangePasswordForm.bind(this)
		});
	};

	/**
	 * Replace form's content based on HTML sent from the server.
	 * @param {string} html
	 */
	UserLoginAjaxForm.prototype.setupChangePasswordForm = function (html) {
		var content, form, heading, modal, contentBlock, duration;

		content = $('<div>').hide().append(html);
		duration = 400;

		// forced login modal needs a new header and some HTML adjustments
		if (this.options.modal) {
			heading = content.find('h1');
			modal = this.options.modal;
			contentBlock = modal.$element.find('.UserLoginModal');

			modal.setTitle(heading.text());
			heading.remove();

			contentBlock.slideUp(duration, function () {
				contentBlock.html('').html(content);
				content.show();
				contentBlock.slideDown(duration);
			});

		// any non-modal change password flow
		} else {
			form = this.form;

			form.slideUp(duration, function () {
				form.replaceWith(content);
				content.slideDown(duration);
			});
		}
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
