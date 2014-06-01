/**
 * Module used to control topbar on wikiamobile
 * has to be run onload event
 *
 * @author Jakub "Student" Olek
 */

define('topbar', ['wikia.querystring', 'wikia.loader', 'toc', 'jquery', 'track', 'throbber', 'wikia.window'],
	function (qs, loader, toc, $, track, throbber, w) {
	'use strict';

	var	$html = $('html'),
		d = w.document,
		wkPrfTgl = d.getElementById('wkPrfTgl'),
		navBar = d.getElementById('wkTopNav'),
		$navBar = $(navBar),
		wkPrf = d.getElementById('wkPrf'),
		searchInput = d.getElementById('wkSrhInp'),
		searchSug = d.getElementById('wkSrhSug'),
		searchForm = d.getElementById('wkSrhFrm'),
		barSetUp = false,
		searchInit = false;

	$('#wkNavTgl').on('click', function(ev){
		ev.preventDefault();

		if($navBar.hasClass('nav-open')){
			showPage();

			$.event.trigger('nav:close');
		}else{
			reset();
			$navBar.removeClass().addClass('nav-open');

			$.event.trigger('nav:open');
		}
	});

	function setupTopBar() {
		//close WikiNav on back button
		if ('onhashchange' in w) {
			w.addEventListener('hashchange', function() {
				if (!qs().getHash() && navBar.className) {
					close();
				}
			}, false);
		}

		barSetUp = true;
	}

	function reset(stopScrolling){
		!barSetUp && setupTopBar();
		!stopScrolling && wkPrfTgl.scrollIntoView();
		toc.close();

		$.event.trigger('nav:close');

		var query = qs(),
			hash = query.getHash();

		(hash !== '#topbar') && (query.setHash('topbar'));
		hidePage();
	}

	function openSearch(){
		reset(true);
		//show search
		navBar.className = 'srhOpn';
		searchForm.scrollIntoView();

		//reset search
		searchInput.value = '';
		searchSug.innerHTML = '';

	/*
		This is needed for iOS 4.x
		It knows what to do with input element with autofocus attribute
		but totaly forgets about the rest
		so I need to cause repaint of the navbar

		comment this out and load a page on iOS 4.x for a reference
	*/
		navBar.style.width = 'auto';
		setTimeout(function(){
			navBar.style.width = '100%';
			searchInput.focus();
		}, 50);

	}

	searchForm && searchForm.addEventListener('submit', function(ev){
		if(searchInput.value === '') {
			ev.preventDefault();
		}else{
			track.event('search', track.SUBMIT, {
				label: w.wgCanonicalSpecialPageName === 'Search' ? 'search' : 'article'
			});
		}
	});

	$('#wkSrhTgl').on('click', function(event){
		event.preventDefault();

		if($navBar.hasClass('srhOpn')){
			close();
		}else{
			initAutocomplete();
			openSearch();
		}
	});
	//end search setup

	//profile/login setup
	if(wkPrfTgl){
		//Fix for ios 4.x not respecting fully event.preventDefault()
		// (it shows url bar for a second (and this is ugly (really)))
		wkPrfTgl.href = '';
		wkPrfTgl.addEventListener('click', function(event){
			event.preventDefault();

			if($navBar.hasClass('prf')){
				close();
			}else{
				openProfile();
			}
		}, true);
	}
	//end profile/login setup

	function initAutocomplete(){
		if(!searchInit){
			loader({
				type: loader.AM_GROUPS,
				resources: 'wikiamobile_autocomplete_js'
			}).done(
				function(){
					require(['autocomplete'], function(sug){
						sug({
							url: w.wgServer + '/api.php?action=opensearch',
							input: searchInput,
							list: searchSug,
							clear: d.getElementById('wkClear')
						});
					});
				}
			);

			searchInit = true;
		}
	}

	function openProfile(hash){
		reset();

		if(!w.wgUserName){
			openLogin(hash);
		}

		navBar.className = 'prf';
	}

	function openLogin(hash){
		if(wkPrf.className.indexOf('loaded') === -1){
			throbber.show(wkPrf, {center: true});

			loader({
				type: loader.LIBRARY,
				resources: 'facebook'
			},{
				type: loader.MULTI,
				resources: {
					templates: [{
						controller: 'UserLoginSpecial',
						method: 'index'
					}],
					messages: 'fblogin',
					styles: '/extensions/wikia/UserLogin/css/UserLogin.wikiamobile.scss',
					scripts: 'userlogin_facebook_js_wikiamobile',
					params: {
						useskin: w.skin
					}
				}
			}).done(
				function(res){
					throbber.remove(wkPrf);

					loader.processStyle(res.styles);
					wkPrf.insertAdjacentHTML('beforeend', res.templates.UserLoginSpecial_index);
					loader.processScript(res.scripts);

					wkPrf.className += ' loaded';

					var wkLgn = document.getElementById('wkLgn'),
						form = wkLgn.getElementsByTagName('form')[0];

					form.setAttribute('action',
						qs(form.getAttribute('action'))
							.setVal('returnto',
								w.wgCanonicalSpecialPageName &&
								w.wgCanonicalSpecialPageName.match(/Userlogin|Userlogout/) ?
									w.wgMainPageTitle :
									w.wgPageName,
								true
							).setHash(hash)
							.toString()
					);

					form.addEventListener('submit', function(ev){
						var t = ev.target;

						if(t[2].value.trim() === '' || t[3].value.trim() === '') {
							ev.preventDefault();
						}
					});
				}
			);
		}
	}

	function close() {
		showPage();

		if(qs().getHash() === '#topbar') {
			var pos = w.scrollY;
			w.history.back();
			w.scrollTo(0,pos);
		}

		$.event.trigger('topbar:close');
	}

	function hidePage(){
		$.event.trigger('ads:unfix');

		$html.addClass('hidden');
	}

	function showPage(){
		$.event.trigger('ads:fix');

		$navBar.removeClass();
		$html.removeClass('hidden');
	}

	return {
		initAutocomplete: initAutocomplete,
		openLogin: openLogin,
		openProfile: openProfile,
		openSearch: openSearch,
		close: close
	};
});