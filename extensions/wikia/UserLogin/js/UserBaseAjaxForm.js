/*global WikiaForm */
(function () {
	'use strict';

	/**
	 * Base class for ajaxy forms like user login, user signup, and connecting wikia accounts with facebook
	 * @abstract
	 * @param el
	 * @param options
	 * @constructor
	 */
	var UserBaseAjaxForm = function (el, options) {
		this.el = $(el);
		this.options = options || {};
		this.init();
	};

	UserBaseAjaxForm.prototype.init = function () {
		this.wikiaForm = new WikiaForm(this.el.find('form'));
		this.inputs = this.wikiaForm.inputs;
		this.cacheDOM();
		this.retrieveLoginToken();
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

		if (json.response === 'ok') {
			this.onOkayResponse();
		} else if (json.response === 'error') {
			this.onErrorResponse();
		}
	};

	UserBaseAjaxForm.prototype.resetValidation = function () {
		this.form.find('.error-msg').remove();
		this.form.find('.input-group').removeClass('error');
	};

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

	UserBaseAjaxForm.prototype.onErrorResponse = function () {
		this.submitButton.removeAttr('disabled');
		this.errorValidation(json);
	};

	UserBaseAjaxForm.prototype.errorValidation = function (json) {
		if (json.errParam) {
			this.wikiaForm.showInputError(json.errParam, json.msg);
		} else {
			this.wikiaForm.showGenericError(json.msg);
		}
	};

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
	UserLoginAjaxForm.prototype.reloadPage = function () {
		require(['wikia.querystring'], function (QuerySring) {
			var qs = new QuerySring();
			qs.addCb().goTo();
		});
	};

	window.UserBaseAjaxForm = UserBaseAjaxForm;
})();