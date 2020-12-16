import { context, events, utils } from '@wikia/ad-engine'

export class LogoReplacement {
	static getName() {
		return 'logoReplacement';
	}

	static getDefaultConfig() {
		return {};
	}

	constructor(adSlot) {
		this.adSlot = adSlot;
		this.config = context.get('templates.logoReplacement') || {};
	}

	init(params) {
		utils.logger(LogoReplacement.getName(), 'init');
		this.config = { ...this.config, ...params };

		setTimeout(() => {
			this.replaceLogo();
		}, 1000);
	}

	replaceLogo() {
		const parentElement = document.querySelector('.wds-global-navigation__content-bar-left');
		const fandomLogo = document.querySelector('.wds-global-navigation__logo');

		if (parentElement && fandomLogo) {
			const customLogoAnchorElement = document.createElement('a');
			customLogoAnchorElement.href = this.config.clickThroughUrl || 'https://www.fandom.com/';
			customLogoAnchorElement.classList.add('custom-logo-anchor');

			const customLogo = document.createElement('img');
			customLogo.src = this.config.logoImage;
			customLogo.classList.add('custom-logo');

			const trackingPixel = document.createElement('img');
			trackingPixel.src = this.config.pixelUrl;
			trackingPixel.classList.add('tracking-pixel');

			parentElement.insertBefore(customLogoAnchorElement, fandomLogo);
			parentElement.removeChild(fandomLogo);
			parentElement.appendChild(trackingPixel);

			if (this.config.smallSizedLogoImage) {
				const smallCustomLogo = document.createElement('img');
				smallCustomLogo.src = this.config.smallSizedLogoImage;
				smallCustomLogo.classList.add('small-custom-logo');
				customLogoAnchorElement.appendChild(smallCustomLogo);
			}

			customLogoAnchorElement.appendChild(customLogo);

			this.adSlot.emitEvent(events.LOGO_REPLACED);
		}
	}
}
