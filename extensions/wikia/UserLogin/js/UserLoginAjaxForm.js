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

			form.slideUp(duration, (function () {
				var newForm = content.find('form');
				form.replaceWith(content);
				content.slideDown(duration);
				newForm.on('submit', this.submitLoginAfterResetPass.bind(this));
				this.wikiaForm = new WikiaForm(newForm);
				this.inputs = this.wikiaForm.inputs;
			}).bind(this));
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



	/**
	 * Handler for login form submit
	 * @param {Object} e jQuery event object
	 */
	UserLoginAjaxForm.prototype.submitLoginAfterResetPass = function (e) {
		this.submitButton.attr('disabled', 'disabled');
		if (this.options.ajaxLogin) {
			e.preventDefault();
			this.ajaxLoginAfterResetPass();
		}
	};

	/**
	 * Make the call to the back end to log the user in via ajax
	 */
	UserLoginAjaxForm.prototype.ajaxLoginAfterResetPass = function () {
		$.nirvana.postJson(
			'UserLoginSpecial',
			'loginForm',
			{
				loginToken: this.loginToken,
				username: this.inputs.username.val(),
				password: this.inputs.password.val(),
				newpassword: this.inputs.newpassword.val(),
				retype: this.inputs.retype.val(),
				action: this.inputs.action.val(),
				editToken: this.inputs.editToken.val()
			},
			this.submitLoginHandler.bind(this)
		);
	};

	// Expose global
	window.UserLoginAjaxForm = UserLoginAjaxForm;
})();
