import Service from '@ember/service';
import {computed} from '@ember/object';
import {getQueryString} from '../utils/url';
import {normalizeToUnderscore} from '../utils/string';

export default Service.extend({
	langPathRegexp: '(/[a-z]{2,3}(?:-[a-z-]{2,12})?)',

	langPath: computed(function () {
		return this.getLanguageCodeFromRequest(window.location.pathname);
	}),

	getLanguageCodeFromRequest(path) {
		const matches = path.match(new RegExp(`^${this.get('langPathRegexp')}/`));

		return matches && matches[1] || '';
	},

	/**
	 * This function constructs a URL given pieces of a typical Wikia URL.
	 * If the current wiki has a lang path (e.g. glee.wikia.com/pl/) then it will be added to all local URLs
	 *
	 * Some example parameters and results:
	 *
	 *   {host: 'www.wikia.com', path: '/login', query: {redirect: '/somepage'}}
	 *   ...returns 'http://www.wikia.com/login?redirect=%2Fsomepage'
	 *
	 *   {host: 'glee.wikia.com', title: 'Jeff'}
	 *   ...returns 'http://glee.wikia.com/wiki/Jeff'
	 *
	 *   {host: 'glee.wikia.com', namespace: 'User', title: 'JaneDoe', path: '/preferences'}
	 *   ...returns 'http://glee.wikia.com/wiki/User:JaneDoe/preferences'
	 *
	 * @param {Object} urlParams
	 * @returns {string}
	 */
	build(urlParams) {
		const host = urlParams.host;

		if (!urlParams.protocol) {
			if (window && window.location && window.location.protocol) {
				urlParams.protocol = window.location.protocol.replace(':', '');
			} else {
				urlParams.protocol = 'http';
			}
		}

		if (!urlParams.articlePath) {
			urlParams.articlePath = '/wiki/';
		}

		let url = `${urlParams.protocol}://${host}`;
		let langPath = this.get('langPath');

		// You can override langPath for external links, e.g. www.wikia.com
		if (typeof urlParams.langPath !== 'undefined') {
			langPath = urlParams.langPath;
		}

		if (langPath) {
			url += langPath;
		}

		if (urlParams.title) {
			url += urlParams.articlePath +
				(urlParams.namespace ? `${urlParams.namespace}:` : '') +
				encodeURIComponent(normalizeToUnderscore(urlParams.title));
		}

		if (urlParams.wikiPage) {
			url += urlParams.articlePath + urlParams.wikiPage;
		}

		if (urlParams.path) {
			url += urlParams.path;
		}

		if (urlParams.query) {
			url += getQueryString(urlParams.query);
		}

		return url;
	},
});
