var UserLoginFacebook = (function(){
	/** @private **/
	var btn,
		callbacks = {};

	//init
	$(function(){
		btn = $(document.getElementById('ssoFbBtn'));

		//see fbconnect.js
		FB.init({
			appId : window.fbAppId,
			oauth : true,
			status : true, // Check login status
			cookie : true, // Enable cookies to allow the server to access the session
			xfbml  : window.fbUseMarkup, // Whether XFBML should be automatically parsed
		});

		btn.bind('click', function(){
			UserLoginFacebook.login();
		});
	});

	/** @public **/

	return {
		login: function(){
			/* DEBUG */console.log('FB.login START');
			// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
			FB.login(
				function(response){
					if(typeof response === 'object' && response.status){
						/* DEBUG */console.log(response);
						switch(response.status) {
							case 'connected':
								/* DEBUG */console.log('FB.login successful');

								// now check FB account (is it connected with Wikia account?)
								$.nirvana.postJson('FacebookSignupController', 'index', null, function(resp){
									/* DEBUG */console.log(resp);
									if(resp.loggedIn){
										// logged in using FB account, reload the page or callback
										var loginCallback = callbacks['login-success'];
										/* DEBUG */console.log(loginCallback)

										if (typeof loginCallback === 'function') {
											loginCallback();
										} else {
											WikiaMobile.reloadPage();
										}
									}else{
										//TODO: use the WikiaMobile
										alert($.msg('wikiamobile-sso-login-fail'));
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