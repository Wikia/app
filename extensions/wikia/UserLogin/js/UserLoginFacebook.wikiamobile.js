var UserLoginFacebook = (function(){
	/** @private **/
	var btn,
		callbacks = {};

	//init
	$(function(){
		btn = $(document.getElementById('ssoFbBtn'));
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
								$.nirvana.postJson('FacebookSignupController', 'index', function(){
									if(resp.loggedIn){
										// logged in using FB account, reload the page or callback
										var loginCallback = callbacks.login-success;

										if (typeof loginCallback === 'function') {
											loginCallback();
										} else {
											WikiaMobile.reloadPage();
										}
									}else{
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