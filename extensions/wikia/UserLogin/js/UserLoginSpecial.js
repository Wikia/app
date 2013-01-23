$(function() {
	if( (typeof window.wgEnableUserLoginExt != 'undefined') && wgEnableUserLoginExt ) {
		new UserLoginAjaxForm($('.UserLogin'));
	}
});