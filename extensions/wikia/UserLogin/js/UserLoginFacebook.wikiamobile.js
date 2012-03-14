var UserLoginFacebook = (function(){
	/** @private **/
	var btn,
		callbacks = {};

	//init
	$(function(){
		btn = document.getElementById('ssoFbBtn');

		//see fbconnect.js
		FB.init({
			appId : window.fbAppId,
			oauth : true,
			status : true, // Check login status
			cookie : true, // Enable cookies to allow the server to access the session
			xfbml  : window.fbUseMarkup // Whether XFBML should be automatically parsed
		});

		btn.addEventListener('click', function(){
			UserLoginFacebook.login();
		});
	});

	function goToUrl(url){
		url = url || wgMainPageTitle;
		url = wgArticlePath.replace('$1', url);
		window.location.href = url;
	}

	/** @public **/

	return {
		login: function(){
			// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
			FB.login(
				function(response){
					if(typeof response === 'object' && response.status){
						switch(response.status) {
							case 'connected':
								// now check FB account (is it connected with Wikia account?)
								$.nirvana.postJson('FacebookSignupController', 'index', null, function(resp){
									if(resp.loggedIn){
										// logged in using FB account, reload the page or callback
										var loginCallback = callbacks['login-success'];

										if (typeof loginCallback === 'function') {
											loginCallback();
										} else {
											goToUrl(WikiaMobile.querystring.getVal('returnto'));
										}
									}else{
										//TODO: use the WikiaMobile toast message when it will be ready
										alert($.msg('wikiamobile-facebook-connect-fail'));
									}
								});
								break;

							case 'unknown':
								break;
						}
					}
				},
				{scope:'email'}
			);
		}
	}
})();