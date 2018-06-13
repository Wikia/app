import {helper as buildHelper} from '@ember/component/helper';

/**
 * Check if two arguments are equals
 *
 * @param {Array} params
 * @returns {string}
 */
export default buildHelper((params) => {
	return params[0] === params[1];
});
