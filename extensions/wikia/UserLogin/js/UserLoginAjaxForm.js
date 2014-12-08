/*global WikiaForm:true, wgScriptPath */
var UserLoginAjaxForm = function (el, options) {
	'use strict';

	this.el = $(el);
	this.options = options || {};
	this.init();
};

UserLoginAjaxForm.prototype.init = function () {
	'use strict';

	// DOM cache
	this.form = this.el.find('form');
	this.wikiaForm = new WikiaForm(this.form);
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
	this.submitButton = this.form.find('input[type=submit]');
	this.forgotPasswordLink = this.form.find('.forgot-password');

	// get login token
	this.retrieveLoginToken();

	// form submission handler
	this.form.submit(this.submitLogin.bind(this));

	// forgot password handler
	this.forgotPasswordLink.click(this.mailPassword.bind(this));

	if (!this.options.skipFocus) {
		this.inputs.username.focus();
	}
};

UserLoginAjaxForm.prototype.submitLogin = function (e) {
	'use strict';

	$(window).trigger('UserLoginSubmit');

	this.submitButton.attr('disabled', 'disabled');
	if (this.options.ajaxLogin) {
		e.preventDefault();
		this.ajaxLogin();
	}
};

UserLoginAjaxForm.prototype.ajaxLogin = function () {
	'use strict';

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
	'use strict';

	this.form.find('.error-msg').remove();
	this.form.find('.input-group').removeClass('error');
	var result = json.result,
		callback;

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

UserLoginAjaxForm.prototype.retrieveTemplateHandler = function (html) {
	'use strict';

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
	'use strict';

	var location = window.location.href,
		delim = '?';
	if (location.indexOf('?') > 0) {
		delim = '&';
	}
	window.location.href = location.split('#')[0] + delim + 'cb=' + Math.floor(Math.random() * 10000);
};

UserLoginAjaxForm.prototype.errorValidation = function (json) {
	'use strict';

	if (json.errParam) {
		this.wikiaForm.showInputError(json.errParam, json.msg);
	} else {
		this.wikiaForm.showGenericError(json.msg);
	}
};

UserLoginAjaxForm.prototype.retrieveLoginToken = function (params) {
	'use strict';

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
	'use strict';

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
	'use strict';

	if (json.result === 'ok') {
		this.errorValidation(json);
	} else if (json.result === 'error') {
		this.errorValidation(json);
	}
};
