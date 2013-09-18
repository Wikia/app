/**
 * Module used to control topbar on wikiamobile
 * has to be run onload event
 *
 * @author Jakub "Student" Olek
 */

define('topbar', ['wikia.querystring', 'wikia.loader', 'toc', 'jquery', 'track', 'throbber', 'wikia.window', 'navigation.wiki'],
	function (qs, loader, toc, $, track, throbber, w, wikiNav) {
	'use strict';

	var	d = w.document,
		wkPrfTgl = d.getElementById('wkPrfTgl'),
		navBar = d.getElementById('wkTopNav'),
		wkPrf = d.getElementById('wkPrf'),
		searchInput = d.getElementById('wkSrhInp'),
		searchSug = d.getElementById('wkSrhSug'),
		searchForm = d.getElementById('wkSrhFrm'),
		searchTgl = d.getElementById('wkSrhTgl'),
		barSetUp = false,
		searchInit = false;

	wikiNav.init($(d.getElementById('wkNav')));

	$('#wkNavTgl').on('click', function(ev){
		ev.preventDefault();

		var nav = $(navBar);

		if(!nav.toggleClass('nav-open').hasClass('nav-open')){
			$.event.trigger('nav:close');

			showPage();
		}else{
			reset();

			$.event.trigger('nav:open');
		}
	});

	function setupTopBar() {
		//close WikiNav on back button
		if ('onhashchange' in w) {
			w.addEventListener('hashchange', function() {
				if (!qs().getHash() && navBar.className) {
					closeDropDown();
				}
			}, false);
		}

		barSetUp = true;
	}

	function reset(stopScrolling){
		!barSetUp && setupTopBar();
		!stopScrolling && wkPrfTgl.scrollIntoView();
		toc.close();

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
		},50);

	}

	function closeSearch(){
		if(navBar.className.indexOf('srhOpn') > -1){
			showPage();
		}
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

	searchTgl && searchTgl.addEventListener('click', function(event){
		event.preventDefault();
		if(navBar.className.indexOf('srhOpn') > -1){
			closeDropDown();
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
			if(navBar.className.indexOf('prf') > -1){
				closeDropDown();
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

	//hash - hash to be set to after returnto query
	//used in ie. ArticleComments.wikiamobile.js
	function openProfile(hash){
		reset();

		if(w.wgUserName){
			//track('profile/open');
		}else{
			openLogin(hash);
		}

		navBar.className = 'prf';
	}

	function openLogin(hash){
		if(wkPrf.className.indexOf('loaded') === -1){
			throbber.show(wkPrf, {center: true});

			loader(
			{
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
								encodeURIComponent(w.wgCanonicalSpecialPageName &&
									w.wgCanonicalSpecialPageName.match(/Userlogin|Userlogout/) ?
										w.wgMainPageTitle :
										w.wgPageName
								)
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

	function closeDropDown() {
		closeProfile();
		closeSearch();
		if(qs().getHash() === '#topbar') {
			var pos = w.scrollY;
			w.history.back();
			w.scrollTo(0,pos);
		}
	}

	function closeProfile(){
		if(navBar.className.indexOf('prf') > -1){
			/*if(wgUserName){
				track('profile/close');
			}else{
				track('login/close');
			}*/
			showPage();
		}
	}

	function hidePage(){
		$.event.trigger('ads:unfix');

		if(d.documentElement.className.indexOf('hidden') === -1) {
			d.documentElement.className += ' hidden';
		}
	}

	function showPage(){
		$.event.trigger('ads:fix');

		navBar.className = '';
		d.documentElement.className = d.documentElement.className.replace(' hidden', '');
	}

	return {
		initAutocomplete: initAutocomplete,
		openLogin: openLogin,
		openProfile: openProfile,
		openSearch: openSearch,
		closeProfile: closeProfile,
		closeSearch: closeSearch,
		closeDropDown: closeDropDown
	};
});