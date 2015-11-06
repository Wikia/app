/* global wgScriptPath */
(function () {
	'use strict';

	var track = require('track'),
		Qs = require('wikia.querystring'),
		toast = require('toast'),
		nirvana = require('wikia.nirvana'),
		msg = require('JSMessages'),
		window = require('wikia.window'),
		btn = document.getElementById('ssoFbBtn'),
		fbInit = (function () {
			var initialized = false;

			return function () {
				if (!initialized) {
					window.FB.init({
						appId: window.fbAppId,
						status: true, // Check login status
						cookie: true, // Enable cookies to allow the server to access the session
						xfbml: true,
						version: 'v2.1'
					});

					initialized = true;
				}
			};
		})();

	if (window.FB) {
		btn.disabled = false;
		btn.addEventListener('click', function () {
			fbInit();

			window.FB.login(loginCallback, {
				scope: 'email'
			});
		});
	}

	function loginCallback(response) {
		if (response && response.status === 'connected') {
			// now check FB account (is it connected with Wikia account?)
			nirvana.postJson('FacebookSignup', 'index').done(
				FBSignUpControllerCallBack
			);
		}
	}

	function FBSignUpControllerCallBack(resp) {
		if (resp.loggedIn) {
			track.event('login', track.CLICK, {
				label: 'facebook',
				value: 1
			});

			var reload = new Qs(),
				returnto = reload.getVal('returnto',
					// TODO: special page URL matching needs to be consolidated. @see UC-187
					(window.wgCanonicalSpecialPageName &&
					window.wgCanonicalSpecialPageName.match(/Userlogin|Userlogout|UserSignup/)) ?
						window.wgMainPageTitle :
						''
				);

			if (returnto) {
				reload.setPath(window.wgArticlePath.replace('$1', returnto));
			}

			reload.removeVal('returnto').removeHash('topbar').addCb().goTo();
		} else if (resp.unconfirmed) {
			$.get(wgScriptPath + '/wikia.php', {
				controller: 'UserLoginSpecial',
				method: 'getUnconfirmedUserRedirectUrl',
				format: 'json',
				username: resp.userName
			}, function (json) {
				window.location = json.redirectUrl;
			});
		} else {
			track.event('login', track.CLICK, {
				label: 'facebook',
				value: 0
			});
			toast.show(msg('wikiamobile-facebook-connect-fail'), {error: true});
		}
	}
})();
