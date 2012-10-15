var UserLogin = UserLogin || {
	isForceLogIn: function(){
		if(!window.wgUserName){
			require('topbar', function(t){
				t.openProfile();
			});
			return true;
		}
		return false;
	}
};