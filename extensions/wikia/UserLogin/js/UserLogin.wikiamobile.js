var UserLogin = UserLogin || {
	isForceLogIn: function(){
		if(wgUserName == null){
			WikiaMobile.openLogin();
			return true;
		}
		return false;
	}
};