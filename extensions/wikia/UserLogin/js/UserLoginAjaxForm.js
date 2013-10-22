/*global WikiaForm:true */
var UserLoginAjaxForm = function(el, options){
	this.el = $(el);
	this.options = options || {};
	this.init();
};

UserLoginAjaxForm.prototype.init = function() {
	// DOM cache
	this.form = this.el.find("form");
	this.wikiaForm = new WikiaForm(this.form);
	this.inputs = {
		username: this.form.find('input[name=username]'),
		password: this.form.find('input[name=password]'),
		keeploggedin: this.form.find('input[name=keeploggedin]'),
		logintoken: this.form.find('input[name=loginToken]'),
		returnto: this.form.find('input[name=returnto]')
	};
	this.submitButton = this.form.find('input[type=submit]');
	this.forgotPasswordLink = this.form.find('.forgot-password');

	// get login token
	this.retrieveLoginToken();

	// form submission handler
	this.form.submit($.proxy(this.submitLogin, this));

	// forgot password handler
	this.forgotPasswordLink.click($.proxy(this.mailPassword, this));

	this.inputs['username'].focus();
};

UserLoginAjaxForm.prototype.submitLogin = function(e) {
	$(window).trigger('UserLoginSubmit');

	this.submitButton.attr('disabled', 'disabled');
	if(this.options['ajaxLogin']) {
		e.preventDefault();
		this.ajaxLogin();
	}
};

UserLoginAjaxForm.prototype.ajaxLogin = function() {
	// TODO: use $.nirvana.postJson
	$.post(wgScriptPath + '/wikia.php', {
		controller: 'UserLoginSpecial',
		method: 'login',
		format: 'json',
		loginToken: this.loginToken,
		username: this.inputs['username'].val(),
		password: this.inputs['password'].val(),
		keeploggedin: this.inputs['keeploggedin'].is(':checked')
	}, $.proxy(this.submitLoginHandler, this));
};

UserLoginAjaxForm.prototype.submitLoginHandler = function(json) {
	$().log(json);
	this.form.find('.error-msg').remove();
	this.form.find('.input-group').removeClass('error');
	var result = json['result'],
		callback;

	if(result === 'ok') {
		window.wgUserName = json['wgUserName'];
		callback = this.options['callback'] || '';
		if(callback && typeof callback === 'function') {
			callback(json);
		} else {
			// reload page if no callback specified
			this.reloadPage();
		}
	} else if(result === 'resetpass') {
		callback = this.options['resetpasscallback'] || '';
		if(callback && typeof callback === 'function') {
			callback(json);
		} else {
			// default implementation
			$.post(wgScriptPath + '/wikia.php', {
					controller: 'UserLoginSpecial',
					method: 'changePassword',
					format: 'html',
					username: this.inputs['username'].val(),
					password: this.inputs['password'].val(),
					returnto: this.inputs['returnto'].val(),
					fakeGet: 1
				}, $.proxy(this.retrieveTemplateHandler, this)
			);
		}
	} else if(result === 'unconfirm') {
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'UserLoginSpecial',
			method: 'getUnconfirmedUserRedirectUrl',
			format: 'json',
			username: this.inputs['username'].val()
		}, function(json) {
			window.location = json['redirectUrl'];
		});
	} else {
		this.submitButton.removeAttr('disabled');
		this.errorValidation(json);
	}
};

UserLoginAjaxForm.prototype.retrieveTemplateHandler = function(html) {
	var content = $('<div style="display:none" />').append(html);
	var heading = content.find('h1');
	var form = this.form;
	this.form.slideUp(400, function() {
		form.replaceWith(content);
		content.slideDown(400);
	});
};

/* TODO: Generalize this - hyun */
/* It seems like we stuff all utility functions into jQuery namespace.  I'd rather wait until we come to a decision on placement of global utility functions than to further pollute jQuery - hyun */
UserLoginAjaxForm.prototype.reloadPage = function() {
	var location = window.location.href;
	var delim = "?";
	if(location.indexOf("?") > 0){
		delim = "&";
	}
	window.location.href = location.split("#")[0] + delim + "cb=" + Math.floor(Math.random()*10000);
};

UserLoginAjaxForm.prototype.errorValidation = function(json) {
	if(json['errParam']) {
		this.wikiaForm.showInputError(json['errParam'], json['msg']);
	} else {
		this.wikiaForm.showGenericError(json['msg']);
	}
};

UserLoginAjaxForm.prototype.retrieveLoginToken = function(params) {
	params = params || {};
	if(!this.loginToken || params['clearCache']) {
		this.loginToken = 'retrieving';
		// TODO: use $.nirvana.postJson
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'UserLoginSpecial',
			method: 'retrieveLoginToken',
			format: 'json'
		}, $.proxy(function(res) {
			this.loginToken = res.loginToken;
			this.inputs['logintoken'].val(res.loginToken);
		}, this));
	}
};

UserLoginAjaxForm.prototype.mailPassword = function(e) {
	e.preventDefault();
	this.form.find('.input-group').removeClass('error');
	this.form.find('.error-msg').remove();
	$().log('mailing password');
	// TODO: use $.nirvana.postJson
	$.post(wgScriptPath + '/wikia.php', {
		controller: 'UserLoginSpecial',
		method: 'mailPassword',
		format: 'json',
		username: this.inputs['username'].val()
	}, $.proxy(this.mailPasswordHandler, this) );
};

UserLoginAjaxForm.prototype.mailPasswordHandler = function(json) {
	$().log(json);
	if(json['result'] === 'ok') {
		this.errorValidation(json);
	} else if(json['result'] === 'error') {
		this.errorValidation(json);
	}
};
