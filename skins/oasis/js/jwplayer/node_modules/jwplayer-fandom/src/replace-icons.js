function wikiaJWPlayerReplaceIcons(playerInstance) {
	var parser = new DOMParser();

	/**
	 * Replaces inner markup of JW SVG's with SVG from Design System
	 * We cannot override the whole SVG as this makes the player misbehave
	 * (e.g.) show fullscreen icon twice, next to each other
	 *
	 * @param {HTMLElement} icon
	 * @param {string} iconHtml
	 */
	function replaceJWIconWithCustom(icon, iconHtml) {
		// some icons are not present on smaller devices
		if (icon) {
			var newIcon = parser.parseFromString(iconHtml, 'image/svg+xml').documentElement;
			newIcon.setAttribute('class', icon.getAttribute('class'));
			icon.parentNode.replaceChild(newIcon, icon);
		}
	}

	/**
	 * @param {HTMLElement} videoPlayerElement
	 */
	function replaceIcons(videoPlayerElement) {
		var controlBar = videoPlayerElement.querySelector('.jw-controlbar'),
			displayControls = videoPlayerElement.querySelector('.jw-display'),
			controlBarIcons = [
				{ selector: '.jw-svg-icon-play', iconName: 'play' },
				{ selector: '.jw-svg-icon-pause', iconName: 'pause' },
				{ selector: '.jw-svg-icon-fullscreen-on', iconName: 'fullScreenOn' },
				{ selector: '.jw-svg-icon-fullscreen-off', iconName: 'fullScreenOff' },
				{ selector: '.jw-svg-icon-settings', iconName: 'settings' },
				{ selector: '.jw-svg-icon-volume-0', iconName: 'volumeOff' },
				{ selector: '.jw-svg-icon-volume-50', iconName: 'volumeOn' },
				{ selector: '.jw-svg-icon-volume-100', iconName: 'volumeOn' }
			],
			displayControlsIcons = [
				{ selector: '.jw-svg-icon-play', iconName: 'displayPlay' },
				{ selector: '.jw-svg-icon-pause', iconName: 'pause' }
			];

		controlBarIcons.forEach(function (iconData) {
			replaceJWIconWithCustom(
				controlBar.querySelector(iconData.selector),
				wikiaJWPlayerIcons[iconData.iconName]
			);
		});

		displayControlsIcons.forEach(function (iconData) {
			replaceJWIconWithCustom(
				displayControls.querySelector(iconData.selector),
				wikiaJWPlayerIcons[iconData.iconName]
			);
		});
	}

	playerInstance.on('ready', function () {
		replaceIcons(playerInstance.getContainer());
	});
}
