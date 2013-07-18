/*
 * Copyright (c) 2010 Garrett Brown <http://www.mediawiki.org/wiki/User:Gbruin>
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
 * This function is called when FB SDK is loaded using $.getScript (inline bottom script)
 *
 * @author macbre
 *
 * This function is executed when loading FB SDK using $.loadFacebookAPI()
 */
window.onFBloaded = function() {
	var fbAppId = window.fbAppId,
		// macbre: fix IE issue (RT #140425)
		// @see http://threebrothers.org/brendan/blog/facebook-connect-ie-fb_xd_fragment-iframe/
		channelUrl = window.location.protocol + '//' +
			window.location.host + window.wgScriptPath +
			'/channel.php?lang=' + encodeURIComponent(window.fbScriptLangCode);

	if (window.fbAppInit) {
		return;

	} else if (typeof fbAppId != 'string') {
		$().log('FB', 'appId is empty!');
		return;
	}

	// Initialize the library with the API key
	FB.init({
		appId : fbAppId,
		oauth : true,
		status : true, // Check login status
		cookie : true, // Enable cookies to allow the server to access the session
		xfbml  : window.fbUseMarkup, // Whether XFBML should be automatically parsed
		channelUrl: channelUrl //for now
	});

	if (typeof GlobalTriggers != 'undefined') {
		GlobalTriggers.fire('fbinit');
	}

	window.fbAppInit = true;
};

/**
 * jQuery code to be run when the DOM is ready to be manhandled.
 */
$(function() {
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
	$("#fbconnect a").on('click', function(ev){
		loginByFBConnect();
		ev.preventDefault();
	});

	if( $.getUrlVar( 'ref' ) === 'fbfeed' ) {
		var suffix = '',
		type = $.getUrlVar( 'fbtype' );
		if( type !== '' ) {
			suffix = '/' + type;
		}
	}


	//Checks for visibility of Facebook Like button's hover panel and hides ads accordingly to prevent z-index problems
	// Christian: (BugId 7297)
	if (skin == 'oasis') {
		var timer = null,
			mouseIn = false,
			FBbutton = $('#WikiaPageHeader .likes :first-child');

		var poll = function() {
			if (FBbutton.children('span').filter(':visible').length > 1) {
			} else {
				if (!mouseIn) {
					clearInterval(timer);
				}
			}
		};

		$('#WikiaPageHeader .likes').hover(function() {
			mouseIn = true;
			timer = setInterval(poll, 250);
		}, function() {
			mouseIn = false;
			if (FBbutton.children('span').filter(':visible').length < 2) {
				clearInterval(timer);
			}
		});
	}
});

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
		var destUrl = wgServer + wgScript + "?title=Special:Connect" + formName + "&returnto=" + encodeURIComponent(window.fbReturnToTitle || wgPageName) + "&returntoquery=" + encodeURIComponent(window.wgPageQuery || '');

		if (formName == "/ConnectExisting") {
			window.location.href = destUrl;
			return;
		}
		$('#fbConnectModalWrapper').remove();
		$.postJSON(window.wgScript + '?action=ajax&rs=SpecialConnect::checkCreateAccount&cb='+wgStyleVersion, function(data) {
			if(data.status == "ok") {
				$().getModal(window.wgScript + '?action=ajax&rs=SpecialConnect::ajaxModalChooseName&returnto=' + encodeURIComponent(wgPageName) + '&returntoquery=' + encodeURIComponent(window.wgPageQuery || ''),  "#fbConnectModal", {
			        id: "fbConnectModalWrapper",
			        width: 600
				});
			} else {
				window.location.href = destUrl;
			}
		});
	});
}


function openFbLogin() {
/*
	if (!isFbApiInit()) {
		setTimeout(openFbLogin,300);
		return true;
	}
*/
	FB.login(sendToConnectOnLogin, { scope : "publish_stream" });
}

/**
 * only for user header button
 */
function loginByFBConnect() {
/*
	if (!isFbApiInit()) {
		window.fbAsyncInit();
	}
*/
	openFbLogin();
	return false;
}

function fixXFBML(id) {
	// BugId:19603 (IE8 specific fix)
	if (typeof $.browser.msie != 'undefined' && typeof $.browser.version != 'undefined' && $.browser.version && $.browser.version.substring(0, $.browser.version.indexOf('.')) < 9) {
		GlobalTriggers.bind('fbinit', function() {
			var node = $('#' + id).parent(),
				html = node.html();

			// FB JS adds 'fb' namespace support in IE, regenerate FBML tags
			node.html('').append(html);

			// force button to be rendered again
			FB.XFBML.parse(node.get(0));
		});
	}
}

// BugId:19767 - fix FBconnect button on Special:Connect
$(function() {
	if (window.wgCanonicalSpecialPageName === 'Connect') {
		$.loadFacebookAPI( function() {
			fixXFBML('fbSpecialConnect');
		});
	}
});
