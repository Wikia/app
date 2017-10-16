var VisitSource = (function () {
	/**
	 *
	 * @param cookieName - cookie where session referrer is stored
	 * @param cookieDomain - cookie domain parameter - for saving cookies
	 * @param isSession - flag, based on value cookie is stored only for current session or lifetime
	 */
	function VisitSource(cookieName, cookieDomain, isSession) {
		if (isSession === void 0) { isSession = true; }
		// safe max cookie expire date (32bit)
		this.cookieExpireDate = new Date(0x7fffffff * 1e3);
		this.cookieName = cookieName;
		this.cookieDomain = cookieDomain;
		this.isSession = isSession;
	}
	VisitSource.prototype.checkAndStore = function () {
		if (this.getCookieValue(this.cookieName, this.getCookie()) === null) {
			this.store();
		}
	};
	VisitSource.prototype.store = function () {
		var referrer = this.getReferrer(), cookieString;
		cookieString = this.cookieName + '=' + encodeURIComponent(referrer);
		cookieString += !this.isSession ? '; expires=' + this.cookieExpireDate.toUTCString() : '';
		cookieString += '; path=/; domain=' + this.cookieDomain;
		this.setCookie(cookieString);
	};
	VisitSource.prototype.get = function () {
		return this.getCookieValue(this.cookieName, this.getCookie());
	};
	VisitSource.prototype.getCookieValue = function (name, cookieString) {
		var parts = ('; ' + cookieString).split('; ' + name + '=');
		if (parts.length === 2) {
			return parts.pop().split(';').shift();
		}
		return null;
	};
	VisitSource.prototype.getReferrer = function () {
		return document.referrer;
	};
	VisitSource.prototype.setCookie = function (cookieString) {
		document.cookie = cookieString;
	};
	VisitSource.prototype.getCookie = function () {
		return document.cookie;
	};
	return VisitSource;
})();
