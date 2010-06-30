/*
 * Copyright © 2010 Garrett Brown <http://www.mediawiki.org/wiki/User:Gbruin>
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * fbconnect.js and fbconnect-min.js
 * 
 * FBConnect relies on several different libraries and frameworks for its JavaScript
 * code. Each framework has its own method to verify that the proper code won't be
 * called before it's ready. (Below, lambda represents a named or anonymous function.)
 * 
 * MediaWiki:             addOnloadHook(lambda);
 *     This function manages an array of window.onLoad event handlers to be called
 *     be called by a MediaWiki script when the window is fully loaded. Because the
 *     DOM may be ready before the window (due to large images to be downloaded) a
 *     faster alternative is JQuery's document-ready function.
 * 
 * FaceBook Connect SDK:  window.fbAsyncInit = lambda;
 *     This global variable is called when the Facebook Connect SDK is fully
 *     initialized asynchronously to the document's state. This might be long
 *     after the document is finished rendering the first time the script is
 *     downloaded. Subsequently, it may even be called before the DOM is ready.
 * 
 * jQuery:                $(document).ready(lambda);
 *     Self-explanatory -- to be called when the DOM is ready to be manipulated.
 *     Typically this should occur sooner than MediaWiki's addOnloadHook function
 *     is called.
 */

/**
 * After the Facebook Connect JavaScript SDK has been asynchronously loaded,
 * it looks for the global fbAsyncInit and executes the function when found.
 */
window.fbAsyncInit = function() {
	// Initialize the library with the API key
	FB.init({
		appId : window.fbAppId,
		status : true, // Check login status
		cookie : true, // Enable cookies to allow the server to access the session
		xfbml  : window.fbUseMarkup // Whether XFBML should be automatically parsed
	});

	// NOTE: Auth.login doesn't appear to work anymore.  The onlogin attribute of the fb:login-buttons is being used instead.
	
	// Register a function for when the user logs out of Facebook
	FB.Event.subscribe('auth.logout', function(response) {
		// TODO: Internationalize
		var login = confirm("Not logged in.\n\nWe detected that you have been logged " +
		                    "out of Facebook. If this isn't the case, don't worry! " +
		                    "Facebook's new library seems to have some growing pains. " +
		                    "Just press Cancel to stay on the current page. Otherwise, " +
		                    "Press OK to log in via Facebook Connect again.");
		if (login) {
			window.location = window.wgArticlePath.replace(/\$1/, "Special:Connect");
		}
	});
};

/**
 * jQuery code to be run when the DOM is ready to be manhandled.
 */
$(document).ready(function() {
	// Add a pretty logo to Facebook links
	$('#pt-fbconnect,#pt-fblink,#pt-fbconvert').addClass('mw-fblink');
	
	// Add the logout behavior to the "Logout of Facebook" button
	$('#pt-fblogout').click(function() {
		// TODO: Where did the fancy DHTML window go? Maybe consider jQuery Alert Dialogs:
		// http://abeautifulsite.net/2008/12/jquery-alert-dialogs/
		var logout = confirm("You are logging out of both this site and Facebook.");
		if (logout) {
			FB.logout(function(response) {
				window.location = window.fbLogoutURL;
			});
		}
	});
	
	//window.fbAsyncInit ();
	$("#fbconnect a").click( function(){
		WET.byStr( 'FBconnect/userlinks/connect' ); 
		loginByFBConnect();
		return false;
	});

	if( $.getUrlVal( "ref" ) == "fbfeed" ) {
		var suffix = "";
		if( $.getUrlVal( "fbtype" ) != "" ) {
			suffix = "/" + $.getUrlVal("fbtype");
		}
		WET.byStr( 'FBconnect/userfromfb' + suffix );
	}
});


/**
 * check for api is init (FB.init)
 * @return bool
 */

function isFbApiInit() {
	return !(typeof FB._apiKey == 'undefined' ||  FB._apiKey == null);
}


/**
 * An optional handler to use in fbOnLoginJsOverride for when a user logs in via facebook connect.
 *
 * This will redirect to Special:Connect with the returnto variables configured properly.
 */
function sendToConnectOnLogin(){
	sendToConnectOnLoginForSpecificForm("");
}
// Allows optional specification of a form to force on Special:Connect (such as ChooseName, ConnectExisting, or Convert).
function sendToConnectOnLoginForSpecificForm(formName){
	FB.getLoginStatus(function(response) {
		if(formName != ""){
	        formName = "/"+formName;
	    }
		var destUrl = wgServer + wgScript + "?title=Special:Connect" + formName + "&returnto=" + wgPageName + "&returntoquery=" + wgPagequery;
		
		if (formName == "/ConnectExisting") {
			window.location.href = destUrl;
			return 
		}
		$('#fbConnectModalWrapper').remove();
		$.postJSON(window.wgScript + '?action=ajax&rs=SpecialConnect::checkCreateAccount&cb='+wgStyleVersion, function(data) {
			if(data.status == "ok") {
				$().getModal(window.wgScript + '?action=ajax&rs=SpecialConnect::ajaxModalChooseName&returnto=' + wgPageName + '&returntoquery=' + wgPagequery,  "#fbConnectModal", {
			        id: "fbConnectModalWrapper",
			        width: "600px",
			        callback: function() {
						$('#fbConnectModalWrapper .close').click(function(){
							WET.byStr( 'FBconnect/ChooseName/X' );
						});
					}
				});    
			} else {
				window.location.href = destUrl;
			}	
		});	
	});
	return
}


function openFbLogin() {
	if (!isFbApiInit()) {
		setTimeout(openFbLogin,300);
		return true;
	}
	FB.login(FB.bind(sendToConnectOnLogin, null), { perms : "publish_stream" });
}

/**
 * only for user header button
 */
function loginByFBConnect() {
	if (!isFbApiInit()) {
		window.fbAsyncInit();
	}
	openFbLogin();
	return false;
}

/**
 * When user wants to log in using a Wikia account and connect
 * it to a Facebook account at the same time.
 */
function loginAndConnectExistingUser(){
	AjaxLogin.action = 'loginAndConnect'; // for clicktracking
	AjaxLogin.form.unbind('submit'); // unbind the hander for previous form
	AjaxLogin.form = $('#userajaxconnectform');

	//window.wgAjaxLoginOnSuccess = loggedInNowNeedToConnect;

	// Make sure the default even doesn't happen.
	AjaxLogin.form.submit(function(ev){
			AjaxLogin.formSubmitHandler(ev);
			return false;
	});
}

/*
 * expend ajax login to use slider login/merge switch 
 */

window.wgAjaxLoginOnInit = function() {
	AjaxLogin.slideToNormalLogin = function(el){
		$().log('AjaxLogin: slideToNormalLogin()');
		var firstSliderCell = $("#AjaxLoginSliderNormal");
		var slideto = 0;
		
		AjaxLogin.beforeDoSuccess = function() { 
			return true;
		};
		$("#AjaxLoginConnectMarketing a.forward").show();
		$("#AjaxLoginConnectMarketing a.back").hide();
		firstSliderCell.animate({
			marginLeft: slideto
		}, function(){$('#fbLoginAndConnect').hide();});
	};
	AjaxLogin.slideToLoginAndConnect = function(el){
		$().log('AjaxLogin: slideToLoginAndConnect()');
		$('#fbLoginAndConnect').show();
		var firstSliderCell = $("#AjaxLoginSliderNormal");
		var slideto = -354;
		$("#AjaxLoginConnectMarketing a.forward").hide();
		$("#AjaxLoginConnectMarketing a.back").show();

		AjaxLogin.beforeDoSuccess = function() {			
			FB.getLoginStatus(function(response) {
				if (response.session) {
					// already logged-in/connected via facebook
					sendToConnectOnLoginForSpecificForm("ConnectExisting");
				} else {
					var slideto = -354;
					$('#userloginErrorBox3').hide();
					$('#fbLoginLastStep').show();
					$('#AjaxLoginConnectMarketing').animate({
						marginLeft: slideto
					}, function() {
						$('#fbLoginAndConnect').animate({
							marginLeft: slideto
						});
					});
					$('#fbLoginAndConnect').hide();
				}
			});
			return false;
		}
		
		firstSliderCell.animate({
			marginLeft: slideto
		});
	};
	AjaxLogin.LoginAndConnectHideBack = function() {
		$("#AjaxLoginConnectMarketing a.back").hide();
	};

	AjaxLogin.slider = function(e) {
		if(typeof e != 'undefined'){
			e.preventDefault();
		}
	
		// Split into diff functions so that they can be called from elsewhere.
		if ($(this).hasClass("forward")) {
			AjaxLogin.slideToLoginAndConnect(this);
		} else {
			AjaxLogin.slideToNormalLogin(this);
		}
	};
	
	//setup slider
	$("#AjaxLoginConnectMarketing a").click(AjaxLogin.slider);
	
	$('#fbAjaxLoginConnect').click(function() {
		WET.byStr( 'FBconnect/login_dialog/connect' );	
	});
	
	$("#AjaxLoginConnectMarketing .forward").click(function() {
		WET.byStr( 'FBconnect/login_dialog/slider/forward' );	
	});
	
	$("#AjaxLoginConnectMarketing .back").click(function() {
		WET.byStr( 'FBconnect/login_dialog/slider/back' );	
	});
	
	$("#wpLoginAndConnectCombo").click(function() {
		WET.byStr( 'FBconnect/login_dialog/login_and_connect' );	
	});
	
	$().log('Fbconnect: AjaxLogin expend');
}

/**
 * When the page is loaded, always init the FB code if it has not been initialized.  This
 * will allow FBML tags in content (if configured to do this).
 */
$(document).ready(function(){
	initFbWhenReady();
});
function initFbWhenReady(){
	if(typeof FB == 'undefined'){
		// The fbsdk code hasn't been loaded yet. Give it more time.
		setTimeout("initFbWhenReady()", 500);
	} else if (!isFbApiInit()) {
		// The fbsdk has loaded but didn't initialize. Force it to init. 
		window.fbAsyncInit();
	}
}
