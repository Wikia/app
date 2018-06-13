import config from '../config/environment';

/**
 * @typedef {Object} getQueryStringOptions
 *
 * @param {boolean} [useBrackets=true] Decides if [] should be added to array params, e.g. id[]=1&id[]=2
 * @param {boolean} [skipQuestionMark=false]
 */

/**
 * Converting and escaping Querystring object to string.
 *
 * @param {Object} [query={}] Querystring object
 * @param {getQueryStringOptions} options
 * @returns {string}
 */
export function getQueryString(query = {}, {useBrackets = true, skipQuestionMark = false} = {}) {
	const queryArray = Object.keys(query);
	const brackets = useBrackets ? '[]' : '';

	let queryString = '';

	if (queryArray.length > 0) {
		const start = skipQuestionMark ? '' : '?';

		queryString = `${start}${queryArray.map((key) => {
			if (query[key] instanceof Array) {
				if (query[key].length) {
					return query[key]
						.map(item => `${encodeURIComponent(key)}${brackets}=${encodeURIComponent(item)}`)
						.join('&');
				}
			} else {
				return `${encodeURIComponent(key)}=${encodeURIComponent(query[key])}`;
			}
		}).join('&')}`;
	}

	return queryString;
}

function getServicesHost() {
	if (typeof FastBoot === 'undefined') {
		return `https://${config.services.domain}`;
	} else {
		return config.fastbootOnly.servicesInternalHost;
	}
}

export function getDiscussionServiceUrl(path = '') {
	return `${getServicesHost()}/${config.services.discussions.baseAPIPath}${path}`;
}

export function getEventLoggerServiceUrl(path = '') {
	return `${getServicesHost()}/${config.services.eventLogger.baseAPIPath}${path}`;
}

export function getFollowingServiceUrl(path = '') {
	return `${getServicesHost()}/${config.services.following.baseAPIPath}${path}`;
}

export function getOpenGraphServiceUrl(path = '') {
	return `${getServicesHost()}/${config.services.openGraph.baseAPIPath}${path}`;
}

export function getSiteAttributeServiceUrl(path = '') {
	return `${getServicesHost()}/${config.services.siteAttribute.baseAPIPath}${path}`;
}

export function getUserAttributeServiceUrl(path = '') {
	return `${getServicesHost()}/${config.services.userAttribute.baseAPIPath}${path}`;
}

export function getUserPermissionsServiceUrl(path = '') {
	return `${getServicesHost()}/${config.services.userPermissions.baseAPIPath}${path}`;
}

export function getOnSiteNotificationsServiceUrl(path = '') {
	return `${getServicesHost()}/${config.services.onSiteNotifications.baseAPIPath}${path}`;
}

export function getUserPreferencesServiceUrl(path = '') {
	return `${getServicesHost()}/${config.services.userPreferences.baseAPIPath}${path}`;
}

export function getGlobalDiscussionLogServiceUrl(path = '') {
	return `${getServicesHost()}/${config.services.globalDiscussionLog.baseAPIPath}${path}`;
}

/**
 * @param {string} url
 * @param {Object} [params={}]
 * @returns {string}
 */
export function addQueryParams(url, params = {}) {
	const paramsString = getQueryString(params, {skipQuestionMark: true});

	if (paramsString.length > 0) {
		if (url.indexOf('?') === -1) {
			url = `${url}?`;
		} else {
			url = `${url}&`;
		}
	}

	return `${url}${paramsString}`;
}

export function isUrl(textToMatch) {
	/**
	 * @see https://codegolf.stackexchange.com/questions/464/shortest-url-regex-match-in-javascript
	 */
	const regex = /^(http:\/\/|https:\/\/|www\.)?[a-z0-9]+([-.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;

	return regex.test(textToMatch);
}
