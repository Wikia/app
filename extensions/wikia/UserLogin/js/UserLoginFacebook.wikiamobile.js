require(['track', 'wikia.querystring', 'toast', 'wikia.nirvana', 'JSMessages', 'wikia.window'],
	function(track, Qs, toast, nirvana, msg, window){
	'use strict';

	var btn = document.getElementById('ssoFbBtn');

	btn.addEventListener('click', function(){
		//see fbconnect.js
		window.FB.init({
			appId : window.fbAppId,
			oauth : true,
			status : true, // Check login status
			cookie : true, // Enable cookies to allow the server to access the session
			xfbml  : window.fbUseMarkup // Whether XFBML should be automatically parsed
		});

		window.FB.login(
			function(response){
				console.log(response);
				if(typeof response === 'object' && response.status === 'connected'){
					// now check FB account (is it connected with Wikia account?)
					nirvana.postJson('FacebookSignup', 'index').done(
						function(resp){
							if(resp.loggedIn){
								track.event('login', track.CLICK, {
									label: 'facebook',
									value: 1
								});

								var reload = new Qs(),
									returnto = reload.getVal('returnto', (wgCanonicalSpecialPageName && (wgCanonicalSpecialPageName.match(/Userlogin|Userlogout/))) ? wgMainPageTitle : '');

								if(returnto) {
									reload.setPath(wgArticlePath.replace('$1', returnto));
								}

								reload.removeVal('returnto').removeHash('topbar').addCb().goTo();

							}else{
								track.event('login', track.CLICK, {
									label: 'facebook',
									value: 0
								});
								toast.show(msg('wikiamobile-facebook-connect-fail'), {error: true});
							}
						}
					);
				}
			},
			{scope: 'email'}
		);
	});

	btn.disabled = false;
});