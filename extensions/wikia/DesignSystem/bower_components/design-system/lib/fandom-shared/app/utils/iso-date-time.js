	/**
 * Gets timestamp from date that can be ISO string or epoch object
 * @param {string|object} date
 * @returns {number} - timestamp
 */
function convertToTimestamp(date) {
	return typeof date === 'string' ? (new Date(date)).getTime() / 1000 : date.epochSecond;
}


/**
 * Gets ISO string from our timestamp
 * @param {string} timestamp
 * @returns {string} - ISO string
 */
function convertToIsoString(timestamp) {
	return new Date(timestamp * 1000).toISOString();
}


export {convertToTimestamp, convertToIsoString};
