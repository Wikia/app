/**
 * We need to support links like:
 * /wiki/Rachel Berry
 * /wiki/Rachel  Berry
 * /wiki/Rachel__Berry
 *
 * but we want them to be displayed normalized in URL bar
 */

/**
 * @param {string} [title='']
 * @returns {string}
 */
export function normalizeToUnderscore(title = '') {
	return title
		.replace(/\s/g, '_')
		.replace(/_+/g, '_');
}

/**
 * Get last url from input text
 * @param {string} text
 * @returns {string|null}
 */
export function getLastUrlFromText(text) {
	const urls = text.match(/(https?:\/\/[^\s]+)/ig);

	return urls ? urls.pop() : null;
}

/**
 * @param  {string} text
 * @return {string}
 */
export function escapeRegex(text) {
	return text.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&');
}
