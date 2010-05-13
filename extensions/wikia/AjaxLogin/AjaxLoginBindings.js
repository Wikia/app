// This file is included right away on every page if the extension is enabled.

/* ComboAjaxLogin */

// AjaxLogin
// If ComboAjaxLogin is disabled, will return true so that the link to the login page is followed.
function openLogin(event) {
	if( (typeof wgComboAjaxLogin == 'undefined') || (!wgComboAjaxLogin) ) {
		return true;
	} else {
		showComboAjaxForPlaceHolder(false, "");
		return false;
	}
}

// Open the same dialog as openLogin, but activate the registration tab
// If ComboAjaxLogin is disabled, will return true so that the link to the registration page is followed.
function openRegister(event) {
	if( (typeof wgComboAjaxLogin == 'undefined') || (!wgComboAjaxLogin) ) {
		return true;
	} else {
		showComboAjaxForPlaceHolder(false, "", "", true);
		return false;
	}
}

// Combo login WikiaImagePlaceholder
// Returns true if/when the login dialog is showing.
// Returns false if the user is logged in or ComboAjaxLogin is not enabled.
function showComboAjaxForPlaceHolder(element, isPlaceholder, callback, showRegisterTabFirst, showLoginRequiredMessage) {
	if ( typeof showComboAjaxForPlaceHolder.statusAjaxLogin == 'undefined' ) { // java script static var
		showComboAjaxForPlaceHolder.statusAjaxLogin = false;
	}

	if ( (typeof wgIsLogin == 'undefined') || (wgIsLogin)
		|| (typeof wgComboAjaxLogin == 'undefined') || (!wgComboAjaxLogin) ) {
		return false;
	}

	if ((typeof  AjaxLogin != 'undefined') && AjaxLogin.showComboFromDOM()) {
		// show ajax login dialog if already in DOM
		if (isPlaceholder) AjaxLogin.setPlaceHolder(element);
		WET.byStr('signupActions/signup/open');

		// Show the tab that was configured to be shown first (defaults to login).
		if((typeof showRegisterTabFirst != 'undefined') && showRegisterTabFirst){
			AjaxLogin.showRegister($('#wpGoRegister'));
		} else {
			AjaxLogin.showLogin($('#wpGoLogin'));
		}

		return true;
	}

	if (showComboAjaxForPlaceHolder.statusAjaxLogin){
		return true;
	}

/*   	$("#positioned_elements").append('<div id="loadmask" class="blackout"></div>');
   	$(".blackout:last")
   		.height($(document).height())
		.css({zIndex: 9999}).fadeTo("fast", 0.65); */
	showComboAjaxForPlaceHolder.statusAjaxLogin = true;

	// scroll top
	window.scrollTo(0,0);

	$().getModal(window.wgScript + '?action=ajax&rs=GetComboAjaxLogin&uselang=' + window.wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion,  false, {
			callback: function() {
				$.getScript(window.wgScript + '?action=ajax&rs=getRegisterJS&uselang=' + window.wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion, function() {
						//$("#loadmask").remove();
						if (isPlaceholder) AjaxLogin.setPlaceHolder(element);
						AjaxLogin.init( $('#AjaxLoginLoginForm form:first') );
						AjaxLogin.show();
						showComboAjaxForPlaceHolder.statusAjaxLogin = false;

						// Show the tab that was configured to be shown first (defaults to login).
						if((typeof showRegisterTabFirst != 'undefined') && showRegisterTabFirst){
							AjaxLogin.showRegister($('#wpGoRegister'));
						} else {
							AjaxLogin.showLogin($('#wpGoLogin'));
						}

						if(typeof FB != 'undefined'){
							window.fbAsyncInit(); // re-initialize FB JS SDK - will parse and activate the FBML login button.
						}

						if((typeof showLoginRequiredMessage != 'undefined') && (showLoginRequiredMessage)){
							$('#comboajaxlogin-actionmsg').show();
						}

						if (typeof callback == 'function'){
							callback();
						}
					});
				}
	});
	return true;
}
//Open image place holder if pass in get
$(function(){
	if ((typeof wgComboAjaxLogin != 'undefined') && wgComboAjaxLogin ) {
		if (wgIsLogin) {
			if (window.location.href.indexOf("placeholder=") > 0) {
				element = window.location.href.split("placeholder=")[1].split("&")[0];
				if ($("#"+element).parent().parent().hasClass("wikiaPlaceholder")){
					$("#"+element).trigger("click");
				}
			}
		}
	}
});
