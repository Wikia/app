/*global WikiaEditor:true */
var UserLogin = {
	rteForceLogin: function() {
		if (!window.wgComboAjaxLogin) {
			UserLoginModal.show({
				callback: function() {
					window.WikiaEditor && WikiaEditor.reloadEditor();
				}
			});
		}
		else showComboAjaxForPlaceHolder("",false, "", false, true);
	},

	isForceLogIn: function() {
		if (wgUserName == null) {
			if (!window.wgComboAjaxLogin) {
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