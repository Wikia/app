var UserLoginFacebook = (function(){
	/** @private **/

	//init
	$(function(){
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

				btn.addEventListener(WikiaMobile.getClickEvent(), function(){
					WikiaMobile.track('facebook/connect/login');
					UserLoginFacebook.login();
				});
				btn.disabled = false;
			}
		);
	});
	/** @public **/

	return {
		login: function(){
			// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
			FB.login(
				function(response){
					if(typeof response === 'object' && response.status == 'connected'){
						require(['querystring', 'toast'], function(qs, toast){
							// now check FB account (is it connected with Wikia account?)
							$.nirvana.postJson('FacebookSignupController', 'index', null, function(resp){
								if(resp.loggedIn){
									WikiaMobile.track('facebook/connect/success');

										var reload = qs(),
											returnto = reload.getVal('returnto', (wgCanonicalSpecialPageName && (wgCanonicalSpecialPageName.match(/Userlogin|Userlogout/))) ? wgMainPageTitle : '');

										if(returnto) {
											reload.setPath(wgArticlePath.replace('$1', returnto));
										}

										reload.setVal('returnto', '');
										reload.setVal('cb', wgStyleVersion);
										reload.goTo();

								}else{
									WikiaMobile.track('facebook/connect/fail');
									toast.show($.msg('wikiamobile-facebook-connect-fail'), {error: true});
								}
							});
						});
					}
				},
				{scope:'email'}
			);
		}
	}
})();