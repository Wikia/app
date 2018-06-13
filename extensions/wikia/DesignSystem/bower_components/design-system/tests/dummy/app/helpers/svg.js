import Helper from '@ember/component/helper';
import {htmlSafe} from '@ember/string'
/**
 * Helper to generate SVGs in the form:
 * {{svg name viewBox classes}}
 * <svg viewBox="{{viewBox}}" class="{{classes}}">
 *    <use xlink:href="#{{name}}"></use>
 * </svg>
 *
 * i.e., {{svg "chevron" "0 0 12 7" "icon chevron"}} generates:
 * <svg viewBox="0 0 12 7" class="icon chevron">
 *    <use xlink:href="#chevron"></use>
 * </svg>
 *
 * @param {Array} params
 * @param {Object} hash
 * @returns {Handlebars.SafeString}
 */
export function svg(params, hash) {
	const optionalParams = [
		'class',
		'role',
		'viewBox',
		'width',
		'height'
	],
		name = params[0];

	let ret = '<svg';

	optionalParams.forEach((param) => {
		if (param in hash) {
			ret += ` ${param}="${hash[param]}"`;
		}
	});
	ret += `><use xlink:href="#${name}"></use></svg>`;

	return htmlSafe(ret);
}

export default Helper.helper(svg);
