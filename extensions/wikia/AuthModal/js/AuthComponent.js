define('AuthComponent', function () {
	'use strict';

	function AuthComponent (rootElement) {
		this.pages = {
				login: 'login',
				facebookConnect: 'login?method=facebook',
				register: 'register',
				facebookRegister: 'register?method=facebook'
			};
		this.rootElement = rootElement;
	}

	AuthComponent.prototype.open = function (page) {
		if (this.rootElement instanceof HTMLElement) {
			var authIframe = document.createElement('iframe');
			authIframe.src = window.location.origin + '/' + page;
			this.rootElement.appendChild(authIframe);
		}
	};

	AuthComponent.prototype.login = function () {
		this.open(this.pages.login);
	};

	AuthComponent.prototype.facebookConnect = function () {
		this.open(this.pages.facebookConnect);
	};

	AuthComponent.prototype.register = function () {
		this.open(this.pages.register);
	};

	AuthComponent.prototype.facebookRegister = function () {
		this.open(this.pages.facebookRegister);
	};

	return AuthComponent;
});
