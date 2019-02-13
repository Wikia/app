import { utils } from '@wikia/ad-engine';
import { backgroundChanger } from './background-changer';

const logGroup = 'skin-template';

function triggerPixels(parentNode, pixels = []) {
	let pixelElement;
	pixels.forEach((pixelUrl) => {
		if (pixelUrl) {
			utils.logger(logGroup, 'adding tracking pixel ', pixelUrl);
			pixelElement = document.createElement('img');
			pixelElement.src = pixelUrl;
			pixelElement.width = 1;
			pixelElement.height = 1;
			parentNode.appendChild(pixelElement);
		}
	});
}

export class Skin {
	static getName() {
		return 'skin';
	}

	static getDefaultConfig() {
		return {};
	}

	/**
	 * Initializes the Skin unit
	 *
	 * @param {Object} params
	 * @param {string} params.destUrl - URL to go when the background is clicked
	 * @param {string} params.skinImage - URL of the 1700x800 image to show in the background
	 * @param {string} params.backgroundColor - background color to use (rrggbb, without leading #)
	 * @param {string} [params.middleColor] - color to use in the middle (rrggbb, without leading #)
	 * @param {Array} params.pixels - URLs of tracking pixels to append when showing the skin
	 */
	init(params) {
		window.wgAfterContentAndJS.push(() => {
			utils.logger(logGroup, 'init', params);

			const adSkin = document.getElementById('ad-skin');
			const adSkinStyle = adSkin.style;
			const backgroundColor = params.backgroundColor ? params.backgroundColor.replace('#', '') : '';
			const backgroundOptions = {
				skinImage: params.skinImage,
				skinImageWidth: 1700,
				skinImageHeight: 800
			};
			const wikiaSkin = document.getElementById('WikiaPageBackground');

			params = params || {};
			params.pixels = params.pixels || [];
			params.middleColor = params.middleColor || backgroundColor;

			if (window.wgOasisResponsive || window.wgOasisBreakpoints) {
				if (params.backgroundColor) {
					backgroundOptions.backgroundColor = `#${backgroundColor}`;
					backgroundOptions.backgroundMiddleColor = `#${params.middleColor.replace('#', '')}`;
				}
				if (params.ten64) {
					backgroundOptions.ten64 = true;
				}
				backgroundChanger.change(backgroundOptions);
			} else {
				adSkinStyle.background = `url("${params.skinImage}") no-repeat top center #${backgroundColor}`;
			}

			document.body.classList.add('background-ad');

			adSkinStyle.position = 'fixed';
			adSkinStyle.height = '100%';
			adSkinStyle.width = '100%';
			adSkinStyle.left = 0;
			adSkinStyle.top = 0;
			adSkinStyle.zIndex = 1;
			adSkinStyle.cursor = 'pointer';

			if (wikiaSkin) {
				wikiaSkin.style.opacity = 1;
			}

			adSkin.addEventListener('click', () => {
				utils.logger(logGroup, 'click');
				window.open(params.destUrl);
			});

			window.wgAdSkinPresent = true;
			triggerPixels(adSkin, params.pixels);
		});
	}
}
