import {helper} from '@ember/component/helper';
import {htmlSafe} from '@ember/string';
import Ember from 'ember';

/**
 * Helper to generate HTML from passed string and additional options.
 * The passed string is HTML escaped before being wrapped in the given tags.
 * By default, if no tagName specified, wraps passed string in <span> tags.
 * Useful ie. when we need to style differently elements of the same string.
 * Options:
 * - tagName - override default span tag name
 * - className - class name to be added to wrapping tag
 * - href - href attribute to be added to wrapping tag
 * - target - target attribute to be added to wrapping tag
 *
 * @example
 * {{{i18n 'main.search-error-not-found'
 * 	ns='search'
 * 	query=(wrap-me erroneousQuery className='search-error-not-found__query' tagName='span')
 * }}}
 *
 * @param {Array} params
 * @param {Object} options
 * @returns {string}
 */

export default helper((params, options) => {
	const content = Ember.Handlebars.Utils.escapeExpression(params[0] || '');
	let tagName = 'span',
		className = '',
		otherOptions = {
			href: '',
			target: '',
		},
		otherOptionsCombined;

	if (options.tagName) {
		tagName = options.tagName;
	}

	if (options.className) {
		className = ` class="${options.className}"`;
	}

	otherOptionsCombined = Object.keys(otherOptions).map(
		(key) => (options[key] ? ` ${key}="${options[key]}"` : '')
	).join('');

	return htmlSafe(`<${tagName}${className}${otherOptionsCombined}>${content}</${tagName}>`).toHTML();
});
