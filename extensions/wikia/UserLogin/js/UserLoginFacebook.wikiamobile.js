var UserLoginFacebook;

require(['track', 'events', 'querystring', 'toast'], function(track, events, qs, toast){
	/** @private **/

	//init
	$(function () {
		var btn = document.getElementById('ssoFbBtn');
		$.getResources(
			['http://connect.facebook.net/en_US/all.js'],
			function() {
				//see fbconnect.js
				FB.init({
					appId : window.fbAppId,
					oauth : true,
					status : true, // Check login status
					cookie : true, // Enable cookies to allow the server to access the session
					xfbml  : window.fbUseMarkup // Whether XFBML should be automatically parsed
				});

				btn.addEventListener(events.click, function(){
					UserLoginFacebook.login();
				});
				btn.disabled = false;
			}
		);
	});
	/** @public **/

	UserLoginFacebook = {
		login: function(){
			// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
			FB.login(
				function(response){
					if(typeof response === 'object' && response.status == 'connected'){
						// now check FB account (is it connected with Wikia account?)
						$.nirvana.postJson('FacebookSignupController', 'index', null, function(resp){
							if(resp.loggedIn){
								track.event('login', track.CLICK, {
									label: 'facebook',
									value: 1
								});

								var reload = new qs(),
									returnto = reload.getVal('returnto', (wgCanonicalSpecialPageName && (wgCanonicalSpecialPageName.match(/Userlogin|Userlogout/))) ? wgMainPageTitle : '');

								if(returnto) {
									reload.setPath(wgArticlePath.replace('$1', returnto));
								}

								reload.removeVal('returnto').addCb().goTo();

							}else{
								track.event('login', track.CLICK, {
									label: 'facebook',
									value: 0
								});
								toast.show($.msg('wikiamobile-facebook-connect-fail'), {error: true});
							}
						});
					}
				},
				{scope: 'email'}
			);
		}
	};
});