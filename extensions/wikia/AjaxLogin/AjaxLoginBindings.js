// This file is included right away on every page if the extension is enabled.

/* ComboAjaxLogin */

// AjaxLogin
// If ComboAjaxLogin is disabled, will return true so that the link to the login page is followed.
function openLogin(event) {
	if( (typeof wgComboAjaxLogin == 'undefined') || (!wgComboAjaxLogin) ) {
		return true;
	} else {
		showComboAjaxForPlaceHolder(false, "");
		event.preventDefault();
	}
}
function openLoginAndConnect(event) {
	if( (typeof wgComboAjaxLogin == 'undefined') || (!wgComboAjaxLogin) ) {
		return true;
	} else {
		// If this was called from somewhere other than the login form, first load the AjaxLogin code.
		if(typeof AjaxLogin == 'undefined'){
			$.getScript(window.wgScript + '?action=ajax&rs=getRegisterJS&uselang=' + window.wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion, function() {
				openLoginAndConnect();
			});
		} else {
			showComboAjaxForPlaceHolder(false, "", AjaxLogin.slideToLoginAndConnect);
		}
		event.preventDefault();
	}
}


// Open the same dialog as openLogin, but activate the registration tab
// If ComboAjaxLogin is disabled, will return true so that the link to the registration page is followed.
function openRegister(event) {
	if( (typeof wgComboAjaxLogin == 'undefined') || (!wgComboAjaxLogin) ) {
		return true;
	} else {
		showComboAjaxForPlaceHolder(false, "", "", true);
		event.preventDefault();
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

	$().getModal(window.wgScript + '?action=ajax&rs=GetComboAjaxLogin&uselang=' + window.wgUserLanguage + "&returnto=" + wgPageName + "&returntoquery=" + wgPageQuery + '&cb=' + wgMWrevId + '-' + wgStyleVersion,  false, {
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
							if (showLoginRequiredMessage == true) {
								$('#comboajaxlogin-actionmsg').show();
							}
							else if (showLoginRequiredMessage == 'protected') {
								$('#comboajaxlogin-actionmsg-protected').show();
							}
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

//Attach DOM-Ready handlers
$(function() {
	$('.ajaxLogin').click(openLogin);
	$('.ajaxRegister').click(openRegister);

	if(!((typeof wgIsLogin == 'undefined') || (wgIsLogin) || (typeof wgComboAjaxLogin == 'undefined') || (!wgComboAjaxLogin) )) {
		$(".wikiaPlaceholder .wikia-button").removeAttr("onclick");
		$(".wikiaPlaceholder .wikia-button").click(function(e){
			if( e.target.nodeName == "SPAN" ){
				showComboAjaxForPlaceHolder($(e.target.parentNode).attr('id'),true);
			}
			else
			{
				showComboAjaxForPlaceHolder($(e.target).attr('id'),true);
			}
			return false;
		});

		var editpromptable = $("#ca-viewsource").add("#te-editanon").add('.loginToEditProtectedPage');

		// add .editsection on wikis with anon editing disabled
		if ( (typeof wgDisableAnonymousEditig !== 'undefined') && (wgDisableAnonymousEditig) ) {
			editpromptable = editpromptable.add(".editsection");
		}

		editpromptable.click(function(e){
			// message handeling
			var message = true; // base 'login requiref for this action'
			if ($(e.target).is(".loginToEditProtectedPage")) {
				message = 'protected';
			}

			showComboAjaxForPlaceHolder(false, "", function(){
				AjaxLogin.doSuccess = function() {
					if(message == 'protected'){
						AjaxLogin.doReload('action=edit');
					} else {
						var target = $(e.target);
						if( target.is('a') ){
							window.location.href = target.attr('href');
						} else {
							window.location.href = target.parent().attr('href');
						}
					}
				}
			}, false, message); // show the 'login required for this action' message.
			return false;
		});

		 $(".wikiaComboAjaxLogin").click(function(e){
			showComboAjaxForPlaceHolder(false, "", function(){
				AjaxLogin.doSuccess = function() {
					CreatePage.openDialog(e, null);
				}
			});
			return false;
		});
	}
});
