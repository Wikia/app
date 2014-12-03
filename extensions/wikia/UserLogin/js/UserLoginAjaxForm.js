/*global WikiaForm:true, wgScriptPath */
(function () {
	'use strict';

	var UserLoginAjaxForm = function (el, options) {
		this.el = $(el);
		this.options = options || {};
		this.init();
	};

	UserLoginAjaxForm.prototype.init = function () {
		// DOM cache
		this.form = this.form = this.el.find('form');
		this.wikiaForm = new WikiaForm(this.form);
		this.forgotPasswordLink = this.form.find('.forgot-password');
		this.submitButton = this.el.find('input[type=submit]');
		this.setInputs();

		this.retrieveLoginToken();
		this.form.on('submit', this.submitLogin.bind(this));
		this.forgotPasswordLink.on('click', this.mailPassword.bind(this));

		if (!this.options.skipFocus) {
			this.inputs.username.focus();
		}
	};

	UserLoginAjaxForm.prototype.setInputs = function () {
		this.inputs = {
			username: this.form.find('input[name=username]'),
			password: this.form.find('input[name=password]'),
			keeploggedin: this.form.find('input[name=keeploggedin]'),
			logintoken: this.form.find('input[name=loginToken]'),
			returnto: this.form.find('input[name=returnto]'),
			returntoquery: this.form.find('input[name=returntoquery]'),
			returntourl: this.form.find('input[name=returntourl]'),
			email: this.form.find('input[name=email]')
		};
	};

	UserLoginAjaxForm.prototype.submitLogin = function (e) {
		$(window).trigger('UserLoginSubmit');

		this.submitButton.attr('disabled', 'disabled');
		if (this.options.ajaxLogin) {
			e.preventDefault();
			this.ajaxLogin();
		}
	};

	UserLoginAjaxForm.prototype.ajaxLogin = function () {
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

	UserLoginAjaxForm.prototype.submitLoginHandler = function (json) {
		var result = json.result,
			callback;

		this.form.find('.error-msg').remove();
		this.form.find('.input-group').removeClass('error');

		if (result === 'ok') {
			window.wgUserName = json.wgUserName;
			callback = this.options.callback || '';
			if (callback && typeof callback === 'function') {
				// call with current context
				callback.bind(this, json)();
			} else {
				// reload page if no callback specified
				this.reloadPage();
			}
		} else if (result === 'resetpass') {
			callback = this.options.resetpasscallback || '';
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
				}, this.retrieveTemplateHandler.bind(this));
			}
		} else if (result === 'unconfirm') {
			$.post(wgScriptPath + '/wikia.php', {
				controller: 'UserLoginSpecial',
				method: 'getUnconfirmedUserRedirectUrl',
				format: 'json',
				username: this.inputs.username.val()
			}, function (json) {
				window.location = json.redirectUrl;
			});
		} else if (result === 'closurerequested') {
			$.post(wgScriptPath + '/wikia.php', {
				controller: 'UserLoginSpecial',
				method: 'getCloseAccountRedirectUrl',
				format: 'json'
			}, function (data) {
				window.location = data.redirectUrl;
			});
		} else {
			this.submitButton.removeAttr('disabled');
			this.errorValidation(json);
		}
	};

	UserLoginAjaxForm.prototype.retrieveTemplateHandler = function (html) {
		var content = $('<div style="display:none" />').append(html),
			form = this.form;

		form.slideUp(400, function () {
			form.replaceWith(content);
			content.slideDown(400);
		});
	};

	/**
	 * Reload the current page with an added "cb" (cachebuster) value, usually after a login.
	 * @todo: Use querystring helper for this
	 */
	UserLoginAjaxForm.prototype.reloadPage = function () {
		var location = window.location.href,
			delim = '?';
		if (location.indexOf('?') > 0) {
			delim = '&';
		}
		window.location.href = location.split('#')[0] + delim + 'cb=' + Math.floor(Math.random() * 10000);
	};

	UserLoginAjaxForm.prototype.errorValidation = function (json) {
		if (json.errParam) {
			this.wikiaForm.showInputError(json.errParam, json.msg);
		} else {
			this.wikiaForm.showGenericError(json.msg);
		}
	};

	/**
	 * @TODO: possibly get login token from form field
	 * @param params
	 */
	UserLoginAjaxForm.prototype.retrieveLoginToken = function (params) {
		params = params || {};
		if (!this.loginToken || params.clearCache) {
			this.loginToken = 'retrieving';
			$.nirvana.postJson(
				'UserLoginSpecial',
				'retrieveLoginToken',
				{
					controller: 'UserLoginSpecial',
					method: 'retrieveLoginToken',
					format: 'json'
				},
				function (res) {
					this.loginToken = res.loginToken;
					this.inputs.logintoken.val(res.loginToken);
				}.bind(this)
			);
		}
	};

	UserLoginAjaxForm.prototype.mailPassword = function (e) {
		e.preventDefault();
		this.form.find('.input-group').removeClass('error');
		this.form.find('.error-msg').remove();
		$.nirvana.postJson(
			'UserLoginSpecial',
			'mailPassword',
			{
				username: this.inputs.username.val()
			},
			this.mailPasswordHandler.bind(this)
		);
	};

	UserLoginAjaxForm.prototype.mailPasswordHandler = function (json) {
		if (json.result === 'ok') {
			this.errorValidation(json);
		} else if (json.result === 'error') {
			this.errorValidation(json);
		}
	};

	// Expose global
	window.UserLoginAjaxForm = UserLoginAjaxForm;
})();
