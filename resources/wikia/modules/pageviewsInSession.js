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
	['wikia.window', 'wikia.document', 'wikia.cookies', 'mw'], function (window, document, cookies, mw) {
	'use strict';

	var wikiaDomain = mw.config.get('wgDevelEnvironment') ? '.wikia-dev.com' : '.wikia.com',
		pageviewsCookieName = 'pageviewsInSession',
		opentabsNumberCookieName = 'openTabsNumber';

	function init() {
		increaseNumberOfOpenTabs();
		setPageviewsCount();

		window.addEventListener('unload', function () {
			decreaseNumberOfOpenTabs();
			sessionStorage.setItem('wasWikiPageShownInCurrentTab', true);
		});
	}

	function getPageviewsCount() {
		var pageviews = cookies.get(pageviewsCookieName);
		return pageviews ? parseInt(pageviews) : 0;
	}

	function setPageviewsCount() {
		var pageviews = getPageviewsCount();

		if (isUserFirstPageview()) {
			pageviews = 1;
		} else {
			pageviews = getPageviewsCount() + 1;
		}

		cookies.set(pageviewsCookieName, pageviews, { domain: wikiaDomain });
	}

	function clearPageviewsCount() {
		cookies.set(pageviewsCookieName);
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
		cookies.set(opentabsNumberCookieName, numberOfTabs, { domain: wikiaDomain });
	}

	function isUserFirstPageview() {
		var lastUrl = document.referrer;

		/**
		 * We assume that user first page view is when
		 * - user has just one tab with wiki page open
		 * - user has not opened wiki page in current tab before
		 * - we don't have information about last visited page or last page is not a wiki page
		 */
		if (getNumberOfOpenTabs() === 1 &&
			!sessionStorage.getItem('wasWikiPageShownInCurrentTab') &&
			(!lastUrl || !hasWikiaDomain(lastUrl))
		) {
			/**
			 * We need to clear page views when user close all tabs with wiki pages (but not whole browser)
			 * and then come back to wiki page. Then we want to start another session.
			 */
			clearPageviewsCount();
			return true;
		}

		return false;
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
