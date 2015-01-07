/*global WikiaForm:true, wgScriptPath */
(function () {
	'use strict';

	var UserLoginAjaxForm = function (el, options) {
		this.el = $(el);
		this.options = options || {};
		this.init();
	};

	UserLoginAjaxForm.prototype.init = function () {
		this.cacheDOM();
		this.wikiaForm = new WikiaForm(this.form);
		this.setInputs();
		this.retrieveLoginToken();
		this.bindEvents();

		if (!this.options.skipFocus) {
			this.inputs.username.focus();
		}
	};

	/**
	 * Cache DOM selectors
	 */
	UserLoginAjaxForm.prototype.cacheDOM = function () {
		this.form = this.el.find('form');
		this.forgotPasswordLink = this.form.find('.forgot-password');
		this.submitButton = this.el.find('input[type=submit]');
	};

	/**
	 * Bind form events
	 */
	UserLoginAjaxForm.prototype.bindEvents = function () {
		this.form.on('submit', this.submitLogin.bind(this));
		this.forgotPasswordLink.on('click', this.mailPassword.bind(this));
	};

	/**
	 * Cache form inputs
	 */
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

	/**
	 * Handler for login form submit
	 * @param {Object} e jQuery event object
	 */
	UserLoginAjaxForm.prototype.submitLogin = function (e) {
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

	/**
	 * Callback after ajax login
	 * @param {Object} json Response from server after ajax login
	 */
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
				}, this.retrieveTemplateCallback.bind(this));
			}
		} else if (result === 'unconfirm') {
			$.get(wgScriptPath + '/wikia.php', {
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

	UserLoginAjaxForm.prototype.retrieveTemplateCallback = function (html) {
		var content = $('<div>').hide().append(html),
			form = this.form;

		form.slideUp(400, function () {
			form.replaceWith(content);
			content.slideDown(400);
		});
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

	UserLoginAjaxForm.prototype.errorValidation = function (json) {
		if (json.errParam) {
			this.wikiaForm.showInputError(json.errParam, json.msg);
		} else {
			this.wikiaForm.showGenericError(json.msg);
		}
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
			// error validation will show success and error messages in this case
			this.errorValidation.bind(this)
		);
	};

	// Expose global
	window.UserLoginAjaxForm = UserLoginAjaxForm;
})();
