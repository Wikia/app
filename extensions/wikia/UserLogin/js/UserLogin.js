/*global WikiaEditor:true */
(function () {
	'use strict';

	var UserLogin = {
		forceLoggedIn: false,

		refreshIfAfterForceLogin: function () {
			if (this.forceLoggedIn) {
				Wikia.Querystring().addCb().goTo();
			}
		},

		rteForceLogin: function () {
			var UserLoginModal = window.UserLoginModal;

			//prevent onbeforeunload from being called when user is loging in
			window.onbeforeunload = function () {};
			UserLoginModal.show({
				origin: 'editor',
				persistModal: true,
				callback: function () {
					if (window.WikiaEditor) {
						WikiaEditor.reloadEditor();
					}
				}
			});
		},

		isForceLogIn: function () {
			var UserLoginModal = window.UserLoginModal;

			if (window.wgUserName === null) {
				//prevent onbeforeunload from being called when user is loging in
				window.onbeforeunload = function () {};
				UserLoginModal.show({
					origin: 'editor'
				});
				return true;
			}
			return false;
		}
	};

	window.UserLogin = UserLogin;
})();
