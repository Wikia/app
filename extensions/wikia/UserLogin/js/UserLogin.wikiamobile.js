var UserLogin = UserLogin || {
	isForceLogIn: function(){
		if(wgUserName == null){
			require('topbar', function(t){
				t.openProfile();
			});
			return true;
		}
		return false;
	}
};