export const getConfig = () => ({
		replaceLogo: (logoImage, pixelUrl, clickThroughUrl) => {
			const parentElement = document.querySelector('.wds-global-navigation__content-bar-left');
			const fandomLogo = document.querySelector('.wds-global-navigation__logo');

			if (parentElement && fandomLogo) {
				const newLogoAnchorElement = document.createElement('a');
				newLogoAnchorElement.href = clickThroughUrl;

				const newLogo = document.createElement('img');
				newLogo.src = logoImage;

				const trackingPixel = document.createElement('img');
				trackingPixel.src = pixelUrl;
				trackingPixel.style.display = 'none';

				parentElement.insertBefore(newLogoAnchorElement, fandomLogo);
				parentElement.removeChild(fandomLogo);
				parentElement.appendChild(trackingPixel);
				newLogoAnchorElement.appendChild(newLogo);
			}
		}
	}
);

export default {
	getConfig,
};
