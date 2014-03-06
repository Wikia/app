/*global WikiaEditor:true */
var UserLogin = {
	forceLoggedIn: false,

	refreshIfAfterForceLogin: function() {
		if (this.forceLoggedIn) {
			Wikia.Querystring().addCb().goTo();
		}
	},

	rteForceLogin: function() {
		'use strict';

		var UserLoginModal = window.UserLoginModal;

		if ( !window.wgComboAjaxLogin ) {
			//prevent onbeforeunload from being called when user is loging in
			window.onbeforeunload = function() {};
			UserLoginModal.show( {
				origin: 'editor',
				persistModal: true,
				callback: function() {
					window.WikiaEditor && WikiaEditor.reloadEditor();
				}
			} );
		} else {
			showComboAjaxForPlaceHolder( '', false, '', false, true );
		}
	},

	isForceLogIn: function() {
		'use strict';

		var UserLoginModal = window.UserLoginModal;

		if ( window.wgUserName == null ) {
			//prevent onbeforeunload from being called when user is loging in
			window.onbeforeunload = function() {};
			if ( !window.wgComboAjaxLogin ) {
				UserLoginModal.show( {
					origin: 'editor'
				} );
				return true;
			} else if ( showComboAjaxForPlaceHolder( '', false, '', false, true ) ) {
				return true;
			}
		}
		return false;
	}
};