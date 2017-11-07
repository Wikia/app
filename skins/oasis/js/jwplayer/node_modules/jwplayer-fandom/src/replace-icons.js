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
		icon.innerHTML = iconHtml;

		// JW icons have viewBox=0,0,240,240 so we need to override it,
		// otherwise our icons would be too small
		icon.setAttribute('viewBox', '0 0 24 24');
	}
}

/**
 * @param {HTMLElement} videoPlayerElement
 */
function replaceIcons(videoPlayerElement) {
	var controlBar = videoPlayerElement.querySelector('.jw-controlbar');
	var iconList = [
		{ selector: '.jw-svg-icon-play', iconName: 'play' },
		{ selector: '.jw-svg-icon-pause', iconName: 'pause' },
		{ selector: '.jw-svg-icon-fullscreen-on', iconName: 'fullScreenOn' },
		{ selector: '.jw-svg-icon-fullscreen-off', iconName: 'fullScreenOff' },
		{ selector: '.jw-svg-icon-settings', iconName: 'settings' },
		{ selector: '.jw-svg-icon-volume-0', iconName: 'volumeOff' },
		{ selector: '.jw-svg-icon-volume-50', iconName: 'volumeOn' },
		{ selector: '.jw-svg-icon-volume-100', iconName: 'volumeOn' }
	];

	iconList.forEach(function (iconData) {
		replaceJWIconWithCustom(
			controlBar.querySelector(iconData.selector),
			wikiaJWPlayerIcons[iconData.iconName]
		);
	});
}

function wikiaJWPlayerReplaceIcons(playerInstance) {
	playerInstance.on('ready', function () {
		replaceIcons(playerInstance.getContainer());
	});
};
