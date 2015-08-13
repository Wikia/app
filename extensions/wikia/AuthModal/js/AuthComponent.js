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

	AuthComponent.prototype.open = function (page, callback) {
		if (this.rootElement instanceof HTMLElement) {
			var authIframe = document.createElement('iframe');
			authIframe.src = window.location.origin + '/' + page;
			authIframe.onload = function () {
				if (typeof callback === 'function') {
					callback();
				}
			};
			this.rootElement.appendChild(authIframe);
		}
	};

	AuthComponent.prototype.login = function (callback) {
		this.open(this.pages.login, callback);
	};

	AuthComponent.prototype.facebookConnect = function (callback) {
		this.open(this.pages.facebookConnect, callback);
	};

	AuthComponent.prototype.register = function (callback) {
		this.open(this.pages.register, callback);
	};

	AuthComponent.prototype.facebookRegister = function (callback) {
		this.open(this.pages.facebookRegister, callback);
	};

	return AuthComponent;
});
