/*global WikiaEditor:true */
var UserLogin = {
	rteForceLogin: function() {
		UserLoginModal.show({
			callback: function() {
				WikiaEditor.reloadEditor();
			}
		});
	},

	isForceLogIn: function() {
		if (wgUserName == null) {
			if (!window.wgEnableAjaxLogin) {
				UserLoginModal.show();
				return true;
			}
			else if (showComboAjaxForPlaceHolder("",false, "", false, true)) {
				return true;
			}
		}
		return false;
	}
};