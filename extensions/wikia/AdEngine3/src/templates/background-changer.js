const SCSS_FILE_PATH = '/skins/oasis/css/core/breakpoints-background.scss';

function configureClasses(options) {
	if (options.skinImage !== '' && options.skinImageWidth > 0 && options.skinImageHeight > 0) {
		document.body.classList.add('background-not-tiled');
		document.body.classList.add('background-fixed');
		document.body.classList.add('background-dynamic');

		if (options.ten64) {
			document.querySelector('.background-image-gradient').classList.add('no-gradients');
		}
	} else {
		document.body.classList.remove('background-dynamic');
		document.body.classList.remove('background-not-tiled');
		document.body.classList.remove('background-fixed');
	}
}

class BackgroundChanger {
	constructor() {
		this.loadedCss = [];
	}

	change(options) {
		const imagePreload = new Image();
		const optionsForSass = {
			'background-dynamic': true,
			'background-image': options.skinImage || '',
			'background-image-width': options.skinImageWidth || 0,
			'background-image-height': options.skinImageHeight || 0,
			'color-body': options.backgroundColor,
			'color-body-middle': options.backgroundMiddleColor
		};
		const settings = Object.assign({}, window.wgSassParams, optionsForSass);
		const settingsBreakpoints = Object.assign({}, settings, {widthType: 0});
		const sassUrl = $.getSassCommonURL(SCSS_FILE_PATH, window.wgOasisBreakpoints ? settingsBreakpoints : settings);
		const nodeIndex = this.loadedCss.indexOf(sassUrl);

		// Preload background image
		imagePreload.src = options.skinImage;

		if (nodeIndex > -1) {
			document.querySelector('link[data-background-changer]').setAttribute('disabled', 'true');
			document.querySelector((`link[data-background-changer="${sassUrl}"]`).setAttribute('disabled', 'false'));
			configureClasses(options);
		} else {
			// load CSS and apply class changes to body element after loading
			$.getCSS(sassUrl, (link) => {
				this.loadedCss.push(sassUrl);
				$(link).attr('data-background-changer', sassUrl);
				configureClasses(options);
			});
		}
	}
}

export const backgroundChanger = new BackgroundChanger();
