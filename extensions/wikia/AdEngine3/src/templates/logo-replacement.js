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
			const newLogoAnchorElement = document.createElement('a');
			newLogoAnchorElement.href = this.config.clickThroughUrl || 'https://www.fandom.com/';

			const newLogo = document.createElement('img');
			newLogo.src = this.config.logoImage;
			newLogo.classList.add('new-logo');

			const trackingPixel = document.createElement('img');
			trackingPixel.src = this.config.pixelUrl;
			trackingPixel.classList.add('tracking-pixel');

			parentElement.insertBefore(newLogoAnchorElement, fandomLogo);
			parentElement.removeChild(fandomLogo);
			parentElement.appendChild(trackingPixel);
			newLogoAnchorElement.appendChild(newLogo);

			this.adSlot.emitEvent(events.LOGO_REPLACED);
		}
	}
}
