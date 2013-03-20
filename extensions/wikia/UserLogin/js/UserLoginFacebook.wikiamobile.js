require(['track', 'wikia.querystring', 'toast', 'wikia.nirvana', 'JSMessages'], function(track, qs, toast, nirvana, msg){
	var btn = document.getElementById('ssoFbBtn');

	btn.addEventListener('click', function(){
		FB.login(
			function(response){
				if(typeof response === 'object' && response.status == 'connected'){
					// now check FB account (is it connected with Wikia account?)
					nirvana.postJson('FacebookSignup', 'index').done(
						function(resp){
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