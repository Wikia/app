/**
 * Pageviews in session counter
 *
 * What is definition of session in this case?
 * Session is series of page views (across one or many wikis) done by one user.
 * It starts when user first enter wiki page and ends when user close last browser tab with wiki page.
 *
 * One case is not covered in this solution:
 * User is on wiki page, navigate to external service and then type wiki address into browser address bar.
 * When the url is typed in this bar we don't have information about history and last page.
 */
define('wikia.pageviewsInSession',
	['wikia.window', 'wikia.document', 'wikia.cookies', 'wikia.sessionStorage', 'mw'],
	function (window, document, cookies, sessionStorage, mw) {
	'use strict';

	var wikiaDomain = mw.config.get('wgCookieDomain'),
		pageviewsCookieName = 'pageviewsInSession',
		opentabsNumberCookieName = 'openTabsNumber',
		wikiPageShownSessionKey = 'wasWikiPageShownInCurrentTab',
		cookieOptions = {
			domain: wikiaDomain,
			path: mw.config.get('wgCookiePath')
		};

	function init() {
		increaseNumberOfOpenTabs();
		setPageviewsCount();

		window.addEventListener('unload', function () {
			decreaseNumberOfOpenTabs();
			sessionStorage.setItem(wikiPageShownSessionKey, true);
		});
	}

	function getPageviewsCount() {
		var pageviews = cookies.get(pageviewsCookieName);
		return pageviews ? parseInt(pageviews) : 0;
	}

	function setPageviewsCount() {
		if (isUserFirstPageview()) {
			/**
			 * We need to clear page views when user close all tabs with wiki pages (but not whole browser)
			 * and then come back to wiki page. Then we want to start another session.
			 */
			clearPageviewsCount();
		}

		cookies.set(pageviewsCookieName, getPageviewsCount() + 1, cookieOptions);
	}

	function clearPageviewsCount() {
		cookies.set(pageviewsCookieName, 0, cookieOptions);
	}

	function getNumberOfOpenTabs() {
		var opentabs = cookies.get(opentabsNumberCookieName);
		return opentabs ? parseInt(opentabs) : 0;
	}

	function increaseNumberOfOpenTabs() {
		setNumberOfOpenTabs(getNumberOfOpenTabs() + 1);
	}

	function decreaseNumberOfOpenTabs() {
		setNumberOfOpenTabs(getNumberOfOpenTabs() - 1);
	}

	function setNumberOfOpenTabs(numberOfTabs) {
		cookies.set(opentabsNumberCookieName, numberOfTabs, cookieOptions);
	}

	function isUserFirstPageview() {
		var lastUrl = document.referrer;

		/**
		 * We assume that user first page view is when
		 * - user has just one tab with wiki page open
		 * - user has not opened wiki page in current tab before
		 * - we don't have information about last visited page or last page is not a wiki page
		 */
		return (getNumberOfOpenTabs() === 1 &&
			!sessionStorage.getItem(wikiPageShownSessionKey) &&
			(!lastUrl || !hasWikiaDomain(lastUrl))
		);
	}

	function hasWikiaDomain(url) {
		var hostname = getUrlHostname(url);

		if (hostname.indexOf('.') !== -1) {
			return hostname.substr(hostname.length - wikiaDomain.length) === wikiaDomain;
		}
		return false;
	}

	function getUrlHostname(url) {
		var location = document.createElement('a');
		location.href = url;

		return location.hostname;
	}

	init();

	return {
		getPageviewsCount: getPageviewsCount
	}
});
