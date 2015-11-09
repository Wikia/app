(function () {
	'use strict';

	window.UserLogin = window.UserLogin || {
		isForceLogIn: function () {
			if (!window.wgUserName) {
				require('topbar').openProfile();

				return true;
			}
			return false;
		}
	};
})();
