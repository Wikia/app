/*global WikiaForm */
(function () {
	'use strict';

	/**
	 * Base class for ajaxy forms like user login, user signup, and connecting wikia accounts with facebook
	 * @abstract
	 * @param {HTMLElement|jQuery} el Wrapper element for form
	 * @param {Object} options
	 * @constructor
	 */
	var UserBaseAjaxForm = function (el, options) {
		if (!(el instanceof HTMLElement || el instanceof jQuery || typeof el === 'string')) {
			throw new Error('This module requires an element or selector as its first argument');
		}

		this.el = $(el);
		this.options = options || {};

		this.init();
	};

	/**
	 * Setup functions for this module
	 */
	UserBaseAjaxForm.prototype.init = function () {
		this.wikiaForm = new WikiaForm(this.el.find('form'));
		this.inputs = this.wikiaForm.inputs;
		this.cacheDOM();
		this.bindEvents();

		if (!this.options.skipFocus) {
			this.inputs.username.focus();
		}
	};

	/**
	 * Cache DOM selectors
	 */
	UserBaseAjaxForm.prototype.cacheDOM = function () {
		this.form = this.wikiaForm.form;
		this.forgotPasswordLink = this.form.find('.forgot-password');
		this.submitButton = this.el.find('input[type=submit]');
	};

	/**
	 * Bind form events
	 */
	UserBaseAjaxForm.prototype.bindEvents = function () {
		this.form.on('submit', this.submitLogin.bind(this));
		this.forgotPasswordLink.on('click', this.mailPassword.bind(this));
	};

	/**
	 * Handler for login form submit
	 * @param {Object} e jQuery event object
	 */
	UserBaseAjaxForm.prototype.submitLogin = function (e) {
		$(window).trigger('UserLoginSubmit');

		this.submitButton.attr('disabled', 'disabled');
		if (this.options.ajaxLogin) {
			e.preventDefault();
			this.ajaxLogin();
		}
	};

	/**
	 * Make the call to the back end to log the user in via ajax
	 */
	UserBaseAjaxForm.prototype.ajaxLogin = function () {
		$.nirvana.postJson(
			'UserLoginSpecial',
			'login',
			{
				loginToken: this.loginToken,
				username: this.inputs.username.val(),
				password: this.inputs.password.val(),
				keeploggedin: this.inputs.keeploggedin.is(':checked')
			},
			this.submitLoginHandler.bind(this)
		);
	};

	/**
	 * Callback after ajax login
	 * @param {Object} json Response from server after ajax login
	 */
	UserBaseAjaxForm.prototype.submitLoginHandler = function (json) {
		this.resetValidation();

		// Default okay and error functions. Child classes can add more handling for different response types.
		if (json.result === 'ok') {
			this.onOkayResponse(json);
		} else if (json.result === 'error') {
			this.onErrorResponse(json);
		} else if (json.result === 'unconfirm') {
			this.onUnconfirmedEmailResponse();
		}
	};

	/**
	 * Removes any validation error messages already displayed on the form
	 */
	UserBaseAjaxForm.prototype.resetValidation = function () {
		this.form.find('.error-msg').remove();
		this.form.find('.input-group').removeClass('error');
	};

	/**
	 * Called after a user has submitted the form and the response from the server was 'ok'
	 * @param {Object} json Response data
	 */
	UserBaseAjaxForm.prototype.onOkayResponse = function (json) {
		var callback = this.options.callback || '';
		window.wgUserName = json.wgUserName;
		if (callback && typeof callback === 'function') {
			// call with current context
			callback.bind(this, json)();
		} else {
			// reload page if no callback specified
			this.reloadPage();
		}
	};

	/**
	 * Called after a user has submitted the form and the response from the server was 'error'
	 * @param {Object} json Response data
	 */
	UserBaseAjaxForm.prototype.onErrorResponse = function (json) {
		this.submitButton.removeAttr('disabled');
		this.errorValidation(json);
	};

	/**
	 * User has signed up successfully but they haven't confirmed their email address yet.
	 */
	UserBaseAjaxForm.prototype.onUnconfirmedEmailResponse = function () {
		$.get(window.wgScriptPath + '/wikia.php', {
			controller: 'UserLoginSpecial',
			method: 'getUnconfirmedUserRedirectUrl',
			format: 'json',
			username: this.inputs.username.val()
		}, function (json) {
			window.location = json.redirectUrl;
		});
	};

	/**
	 * Initialize front end validation messages based on error data returns from server.
	 * @param {Object} json
	 */
	UserBaseAjaxForm.prototype.errorValidation = function (json) {
		if (json.errParam) {
			this.wikiaForm.showInputError(json.errParam, json.msg);
		} else {
			this.wikiaForm.showGenericError(json.msg);
		}
	};

	/**
	 * Called when a user clicks the forgot password link in a login form
	 * @param {Event} e Click event
	 */
	UserBaseAjaxForm.prototype.mailPassword = function (e) {
		e.preventDefault();
		this.form.find('.input-group').removeClass('error');
		this.form.find('.error-msg').remove();
		$.nirvana.postJson(
			'UserLoginSpecial',
			'mailPassword',
			{
				username: this.inputs.username.val()
			},
			// error validation will show success and error messages in this case
			this.errorValidation.bind(this)
		);
	};

	/**
	 * Reload the current page with an added "cb" (cachebuster) value, usually after a login.
	 */
	UserBaseAjaxForm.prototype.reloadPage = function () {
		require(['wikia.querystring'], function (QuerySring) {
			var qs = new QuerySring();
			qs.addCb().goTo();
		});
	};

	window.UserBaseAjaxForm = UserBaseAjaxForm;
})();
