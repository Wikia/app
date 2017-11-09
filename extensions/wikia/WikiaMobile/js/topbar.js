/**
 * Module used to control topbar on wikiamobile
 * has to be run onload event
 *
 * @author Jakub "Student" Olek
 */

define('topbar', ['wikia.querystring', 'wikia.loader', 'jquery', 'track', 'throbber', 'wikia.window'],
function (
	qs,
	loader,
	$,
	track,
	throbber,
	w
) {
	'use strict';

	var d = w.document,
		loginButton = d.getElementById('wkPrfTgl'),
		navBar = d.getElementById('wkTopNav'),
		$navBar = $(navBar),
		wkPrf = d.getElementById('wkPrf'),
		searchInput = d.getElementById('wkSrhInp'),
		searchSug = d.getElementById('wkSrhSug'),
		searchForm = d.getElementById('wkSrhFrm'),
		barSetUp = false,
		searchInit = false;

	$('#wkNavTgl').on('click', function (ev) {
		ev.preventDefault();

		if ($navBar.hasClass('nav-open')) {
			showPage();

			$.event.trigger('nav:close');
		} else {
			reset();
			$navBar.removeClass().addClass('nav-open');

			$.event.trigger('nav:open');
		}
	});

	function setupTopBar() {
		//close WikiNav on back button
		if ('onhashchange' in w) {
			w.addEventListener('hashchange', function () {
				if (!qs().getHash() && navBar.className) {
					close();
				}
			}, false);
		}

		barSetUp = true;
	}

	function reset(stopScrolling) {
		if (!barSetUp) {
			setupTopBar();
		}

		if (!stopScrolling) {
			window.scrollTo(0, 0);
		}

		$.event.trigger('nav:close');

		var query = qs(),
			hash = query.getHash();

		if (hash !== '#topbar') {
			query.setHash('topbar');
		}

		hidePage();
	}

	function openSearch() {
		reset(true);
		//show search
		navBar.className = 'srhOpn';

		//reset search
		searchInput.value = '';
		searchSug.innerHTML = '';

		searchInput.focus();

		// Hiding topbar while searchForm open -> first line for Android. Second line for iOS to wait for the browser
		// to show keyboard (first version will not work for iOS browsers as they will move the topbar back to the
		// viewport
		searchForm.scrollIntoView();
		setTimeout(function () {
			searchForm.scrollIntoView();
		}, 0);
	}

	if (searchForm) {
		searchForm.addEventListener('submit', function (ev) {
			if (searchInput.value === '') {
				ev.preventDefault();
			} else {
				track.event('search', track.SUBMIT, {
					label: w.wgCanonicalSpecialPageName === 'Search' ? 'search' : 'article'
				});
			}
		});
	}

	$('#wkSrhTgl').on('click', function (event) {
		event.preventDefault();

		if ($navBar.hasClass('srhOpn')) {
			close();
		} else {
			initAutocomplete();
			openSearch();
		}
	});
	//end search setup

	//profile/login setup
	if (loginButton && !loginButton.classList.contains('new-login')) {
		//Fix for ios 4.x not respecting fully event.preventDefault()
		// (it shows url bar for a second (and this is ugly (really)))
		loginButton.href = '';
		loginButton.addEventListener('click', function (event) {
			event.preventDefault();

			if ($navBar.hasClass('prf')) {
				close();
			} else {
				openProfile();
			}
		}, true);
	}
	//end profile/login setup

	function initAutocomplete() {
		if (!searchInit) {
			loader({
				type: loader.AM_GROUPS,
				resources: 'wikiamobile_autocomplete_js'
			}).done(
				function () {
					require(['autocomplete'], function (sug) {
						sug({
							url: w.wgScriptPath + '/api.php?action=opensearch',
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

	function openProfile(hash) {
		reset();

		if (!w.wgUserName) {
			openLogin(hash);
		}

		navBar.className = 'prf';
	}

	function openLogin(hash) {
		if (wkPrf.className.indexOf('loaded') === -1) {
			throbber.show(wkPrf, {
				center: true
			});

			loader({
				type: loader.LIBRARY,
				resources: 'facebook'
			}, {
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
				function (res) {
					throbber.remove(wkPrf);

					loader.processStyle(res.styles);
					wkPrf.insertAdjacentHTML('beforeend', res.templates.UserLoginSpecial_index); // jshint ignore:line
					loader.processScript(res.scripts);

					wkPrf.className += ' loaded';

					var wkLgn = document.getElementById('wkLgn'),
						form = wkLgn.getElementsByTagName('form')[0],
						loginToken = document.getElementById('loginToken');

					if (loginToken && w.wgLoginToken) {
						loginToken.value = w.wgLoginToken;
					}

					form.setAttribute('action',
						qs(form.getAttribute('action'))
						.setVal('returnto',
							createReturnToString(),
							true
						).setHash(hash)
						.toString()
					);

					form.addEventListener('submit', function (ev) {
						var t = ev.target;

						if (t[2].value.trim() === '' || t[3].value.trim() === '') {
							ev.preventDefault();
						}
					});
				}
			).fail(function () {
				qs()
					.setPath(w.wgArticlePath.replace('$1', 'Special:UserLogin'))
					.setVal('returnto', createReturnToString(), true)
					.goTo();
			});
		}
	}

	/**
	 *
	 * @return {String} MainPage title or current page title
	 */
	function createReturnToString() {
		return w.wgCanonicalSpecialPageName &&
			// TODO: special page URL matching needs to be consolidated. @see UC-187
			w.wgCanonicalSpecialPageName.match(/Userlogin|Userlogout|UserSignup/) ?
			w.wgMainPageTitle :
			w.wgPageName;
	}

	function showPage() {
		$navBar.removeClass();
		$.event.trigger('curtain:hide');
	}

	$(d).on('curtain:hidden', showPage);

	function close() {
		showPage();

		if (qs().getHash() === '#topbar') {
			var pos = w.scrollY;
			w.history.back();
			w.scrollTo(0, pos);
		}

		$.event.trigger('topbar:close');
	}

	function hidePage() {
		$.event.trigger('curtain:show');
	}

	return {
		initAutocomplete: initAutocomplete,
		openLogin: openLogin,
		openProfile: openProfile,
		openSearch: openSearch,
		close: close
	};
});
