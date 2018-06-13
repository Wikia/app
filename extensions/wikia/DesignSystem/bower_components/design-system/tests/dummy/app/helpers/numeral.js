import {helper as buildHelper} from '@ember/component/helper';
import numeral from 'numeral';

/**
 * @param {Array} params
 * @returns {string}
 */
export default buildHelper(([numberToFormat, format]) => {
	return numeral(numberToFormat).format(format);
});
