define('AuthComponent', function () {
	'use strict';

	function AuthComponent (rootElement) {
		this.pages = {
				login: {
					path: '/signin'
				},
				facebookConnect: {
					path: '/signin',
					search: 'method=facebook'
				},
				register: {
					path: '/register'
				},
				facebookRegister: {
					path: '/register',
					search: 'method=facebook'
				}
			};
		this.rootElement = rootElement;
	}

	AuthComponent.prototype.getUselangParam = function (language) {
		if (typeof language !== 'string') {
			return '';
		}
		return 'uselang=' + language;
	};

	AuthComponent.prototype.getPageUrl = function (page, language) {
		var url = window.location.origin + page.path,
			search = '?modal=1',
			uselang = this.getUselangParam(language),
			pageSearch = page.search;
		if (pageSearch) {
			search += '&' + pageSearch;
		}
		if (uselang) {
			search += '&' + uselang;
		}

		return url + search;
	};

	AuthComponent.prototype.open = function (page, callback, language) {
		if (this.rootElement instanceof HTMLElement) {
			var authIframe = document.createElement('iframe');
			authIframe.src = this.getPageUrl(page, language);
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
