import { utils } from '@wikia/ad-engine/dist/ad-engine';

const wikiaApiController = 'AdEngine3ApiController';
const wikiaApiMethod = 'getRecCode';

/**
 * Injects rec code into page
 */
export const recInjector = {
	/**
	 * Requests and injects rec code into DOM
	 * @param {string} type
	 * @returns {Promise}
	 */
	inject(type) {
		const url = `${window.wgCdnApiUrl}/wikia.php?controller=${wikiaApiController}&method=${wikiaApiMethod}&type=${type}`;

		return utils.scriptLoader.loadScript(
			url,
			'text/javascript',
			false,
			document.head.lastChild,
		);
	}
};
