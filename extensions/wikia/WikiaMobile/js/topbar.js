/**
 * Module used to control topbar on wikiamobile
 * has to be run onload event
 *
 * @author Jakub "Student" Olek
 */

define('topbar', ['wikia.querystring', 'wikia.loader', 'toc', 'jquery', 'track', 'throbber', 'wikia.window'], function (qs, loader, toc, $, track, throbber, w) {
	'use strict';

	var	d = w.document,
		wkPrfTgl = d.getElementById('wkPrfTgl'),
		navBar = d.getElementById('wkTopNav'),
		navigationTgl = d.getElementById('wkNavTgl'),
		wkPrf = d.getElementById('wkPrf'),
		searchInput = d.getElementById('wkSrhInp'),
		searchSug = d.getElementById('wkSrhSug'),
		searchForm = d.getElementById('wkSrhFrm'),
		searchTgl = d.getElementById('wkSrhTgl'),
		wkNavMenu,
		wikiNavHeader,
		wikiNavH1,
		wikiNavLink,
		lvl2Link,
		barSetUp = false,
		navSetUp = false,
		searchInit = false;

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

	//navigation setup
	function setupNav(){
		wkNavMenu = d.getElementById('wkNavMenu');

		//replace menu from bottom to topBar - the faster the better
		d.getElementById('wkNav').replaceChild(wkNavMenu, d.getElementById('wkWikiNav'));

		wikiNavHeader = wkNavMenu.getElementsByTagName('header')[0];
		wikiNavH1 = wikiNavHeader.getElementsByTagName('h1')[0];
		wikiNavLink = d.getElementById('wkNavLink');

		wikiNavH1.className = '';

		//add chevrons to all elements that have child lists
		var uls = wkNavMenu.querySelectorAll('ul ul'),
			i = uls.length;

		while(i){
			uls[--i].parentElement.className += ' cld';
		}

		d.getElementById('lvl1').addEventListener('click', function(event) {
			var t = event.target;

			if(t.className.indexOf('cld') > -1) {
				event.preventDefault();

				var element = t.childNodes[0],
					href = element.href;

				t.getElementsByTagName('ul')[0].className += ' cur';

				handleHeaderLink(href);

				if(wkNavMenu.className === 'cur1'){
					wikiNavH1.innerText = element.innerText;
					lvl2Link = href;
					track.event('wikinav', track.CLICK, {
						label: 'level-2'
					});
					wkNavMenu.className = 'cur2';
					wikiNavH1.className = 'anim';
				}else{
					track.event('wikinav', track.CLICK, {
						label: 'level-3'
					});

					wkNavMenu.className = 'cur3';
					wikiNavH1.className = 'animNext';

					setTimeout(function(){
						wikiNavH1.innerText = element.innerText;
					}, 250);
				}
			}
		});

		d.getElementById('wkNavBack').addEventListener('click', function() {
			if(wkNavMenu.className === 'cur2') {
				setTimeout(function(){
					wkNavMenu.querySelector('.lvl2.cur').className = 'lvl2';
				}, 501);
				track.event('wikinav', track.CLICK, {
					label: 'level-1'
				});
				wkNavMenu.className = 'cur1';
				wikiNavH1.className = 'animBack';
			} else {
				setTimeout(function(){
					wkNavMenu.querySelector('.lvl3.cur').className = 'lvl3';
					wikiNavH1.className = '';
				}, 501);

				wikiNavH1.className = 'animBack';
				setTimeout(function(){
					wikiNavH1.innerText = wkNavMenu.querySelector('.lvl2.cur').previousSibling.innerText;
				}, 250);


				handleHeaderLink(lvl2Link);

				track.event('wikinav', track.CLICK, {
					label: 'level-2'
				});
				wkNavMenu.className = 'cur2';
			}
		});

		wikiNavLink.addEventListener('click', function(){
			track.event('wikinav', track.CLICK, {
				label: 'header-' + wkNavMenu.className.slice(3)
			});
		});

		navSetUp = true;
	}

	navigationTgl && navigationTgl.addEventListener('click', function(event){
		event.preventDefault();
		if(navBar.className.indexOf('fllNav') > -1){
			closeDropDown();
		}else{
			openNav();
		}
	});

	function openNav(){
		!navSetUp && setupNav();
		reset();
		track.event('wikinav', track.CLICK, {
			label: 'level-1'
		});
		wkNavMenu.className = 'cur1';
		navBar.className = 'fllNav';
	}

	function closeNav(){
		if(navBar.className.indexOf('fllNav') > -1){
			//track('nav/close');
			showPage();
		}
	}

	function handleHeaderLink(link){
		if(link) {
			wikiNavLink.href = link;
			wikiNavLink.style.display = 'block';
		} else {
			wikiNavLink.style.display = 'none';
		}
	}
	//end navigation setup

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
		closeNav();
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
		closeNav: closeNav,
		closeSearch: closeSearch,
		closeDropDown: closeDropDown
	};
});