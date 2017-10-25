/**
 * Replaces inner markup of JW SVG's with SVG from Design System
 * We cannot override the whole SVG as this makes the player misbehave
 * (e.g.) show fullscreen icon twice, next to each other
 *
 * @param {HTMLElement} icon
 * @param {string} iconHtml
 */
function replaceJWIconWithCustom(icon, iconHtml) {
	icon.innerHTML = iconHtml;

	// JW icons have viewBox=0,0,240,240 so we need to override it,
	// otherwise our icons would be too small
	icon.setAttribute('viewBox', '0 0 24 24');
}

/**
 * @param {HTMLElement} videoPlayerElement
 */
function replaceIcons(videoPlayerElement) {
	var controlBar = videoPlayerElement.querySelector('.jw-controlbar');

	replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-play'), wikiaJWPlayerIcons.play);
	replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-pause'), wikiaJWPlayerIcons.pause);
	replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-fullscreen-on'), wikiaJWPlayerIcons.fullScreenOn);
	replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-fullscreen-off'), wikiaJWPlayerIcons.fullScreenOff);
	replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-settings'), wikiaJWPlayerIcons.settings);
	replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-volume-0'), wikiaJWPlayerIcons.volumeOff);
	replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-volume-50'), wikiaJWPlayerIcons.volumeOn);
	replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-volume-100'), wikiaJWPlayerIcons.volumeOn);
}

function wikiaJWPlayerReplaceIcons(playerInstance) {
	playerInstance.on('ready', function () {
		replaceIcons(playerInstance.getContainer());
	});
};
