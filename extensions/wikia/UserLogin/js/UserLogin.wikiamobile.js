var UserLogin = UserLogin || {
	isForceLogIn: function(){
		if(wgUserName == null){
			WikiaMobile.openProfile();
			return true;
		}
		return false;
	}
};