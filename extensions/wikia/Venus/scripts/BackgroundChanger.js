/**
 * BackgroundChanger
 *
 * Loader for background.scss
 *
 * @type {{load: Function}}
 */

define('wikia.backgroundchanger', function()  {
	'use strict';
	/**
	 * Load background.scss with params
	 *
	 * param is object with following properties:
	 * a) skinImage (string, mandatory) - URL to skin's image
	 * b) backgroundColor (string, mandatory) - background color for skin
	 * c) skinImageWidth (integer, mandatory if skinImage is given) - image's width
	 * d) skinImageHeight (integer, mandatory if skinImage is given) - image's height
	 * e) backgroundFixed (boolean, defaults to true) - "true" if image should be fixed on top, "false" otherwise
	 * f) backgroundTiled (boolean, defaults to false) - "true" if image should be tiles, "false" otherwise
	 *
	 * @param options
	 */
	function load(options) {
		var imagePreload = new Image(),
			optionsForSass = {
				'background-image': options.skinImage || '',
				'background-image-width': options.skinImageWidth || 0,
				'background-image-height': options.skinImageHeight || 0,
				'color-body': options.backgroundColor
			},
			settings = $.extend({}, window.wgSassParams, optionsForSass),
			sassUrl = $.getSassCommonURL('/extensions/wikia/Venus/styles/background.scss', settings);

		// preload adskin image
		imagePreload.src = options.skinImage;

		// load CSS and apply class changes to body element after loading
		$.getCSS(sassUrl, function() {
			if (options.skinImage !== '' && options.skinImageWidth > 0 && options.skinImageHeight > 0) {
				if ((options.backgroundFixed === undefined) || !!options.backgroundFixed) {
					$('body').addClass('background-fixed');
				} else {
					$('body').removeClass('background-fixed');
				}

				if ((options.backgroundTiled !== undefined) && !!options.backgroundTiled) {
					$('body').removeClass('background-not-tiled');
				} else {
					$('body').addClass('background-not-tiled');
				}
			} else {
				$('body').removeClass('background-not-tiled background-fixed');
			}
		});
	}

	return {
		load: load
	};
});
