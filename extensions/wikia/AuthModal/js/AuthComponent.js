define('AuthComponent', function () {
	'use strict';

	function AuthComponent (rootElement) {
		this.pages = {
				login: 'signin?modal=1',
				facebookConnect: 'signin?method=facebook&modal=1',
				register: 'register?modal=1',
				facebookRegister: 'register?method=facebook&modal=1'
			};
		this.rootElement = rootElement;
	}

	AuthComponent.prototype.getUselangParam  = function (language) {
		if (typeof language !== 'string') {
			return '';
		}
		return '&uselang=' + language;
	};

	AuthComponent.prototype.open = function (page, callback, language) {
		if (this.rootElement instanceof HTMLElement) {
			var authIframe = document.createElement('iframe');
			authIframe.src = window.location.origin + '/' + page + this.getUselangParam(language);
			authIframe.onload = function () {
				if (typeof callback === 'function') {
					callback();
				}
			};
			this.rootElement.appendChild(authIframe);
		}
	};

	AuthComponent.prototype.login = function (callback, language) {
		this.open(this.pages.login, callback, language);
	};

	AuthComponent.prototype.facebookConnect = function (callback, language) {
		this.open(this.pages.facebookConnect, callback, language);
	};

	AuthComponent.prototype.register = function (callback, language) {
		this.open(this.pages.register, callback, language);
	};

	AuthComponent.prototype.facebookRegister = function (callback, language) {
		this.open(this.pages.facebookRegister, callback, language);
	};

	return AuthComponent;
});
