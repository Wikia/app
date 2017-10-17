define(
	'wikia.articleVideo.featuredVideo.jwplayer.icons',
	[],
	function () {
		var icons = {
			// wds-icons-play-triangle-small.svg
			play: '<path d="M14.767 9.437L3.858 16.903a.553.553 0 0 1-.565.037.531.531 0 0 1-.293-.473V1.533c0-.199.113-.381.293-.473a.557.557 0 0 1 .565.036l10.91 7.467A.53.53 0 0 1 15 9a.53.53 0 0 1-.233.437z" fill-rule="evenodd"/>\n',
			// wds-icons-pause-small.svg
			pause: '<g fill-rule="evenodd"><rect width="5" height="16" rx="1" x="2" y="1"/><rect x="11" width="5" height="16" rx="1" y="1"/></g>',
			// wds-icons-fullscreen-small.svg
			fullScreenOn: '<path d="M3.249 7H1V2h5v2.25H3.249zm11.502 0H17V2h-5v2.25h2.751zM3.249 11H1v5h5v-2.25H3.249zm11.502 0H17v5h-5v-2.25h2.751z" fill-rule="evenodd"/>\n',
			// wds-icons-fullscreen-off-small.svg
			fullScreenOff: '<path d="M3.751 2H6v5H1V4.75h2.751zm10.498 0H12v5h5V4.75h-2.751zM3.751 16H6v-5H1v2.25h2.751zm10.498 0H12v-5h5v2.25h-2.751z" fill-rule="evenodd"/>\n',
			// wds-icons-gear-small.svg
			settings: '<path d="M9 7.09a1.909 1.909 0 1 1 0 3.819A1.909 1.909 0 0 1 9 7.09m-4.702-.03a1.07 1.07 0 0 1-.99.667h-.672A.637.637 0 0 0 2 8.364v1.272c0 .352.285.637.636.637h.672c.436 0 .824.264.99.667l.006.013c.167.403.08.864-.229 1.172L3.6 12.6a.636.636 0 0 0 0 .9l.9.9a.636.636 0 0 0 .9 0l.475-.475a1.072 1.072 0 0 1 1.185-.223c.403.166.667.554.667.99v.672c0 .35.285.636.637.636h1.272a.637.637 0 0 0 .637-.636v-.672c0-.436.264-.824.667-.99l.013-.006a1.07 1.07 0 0 1 1.172.229l.475.475a.636.636 0 0 0 .9 0l.9-.9a.636.636 0 0 0 0-.9l-.475-.475a1.072 1.072 0 0 1-.229-1.172l.006-.013a1.07 1.07 0 0 1 .99-.667h.672A.637.637 0 0 0 16 9.636V8.364a.637.637 0 0 0-.636-.637h-.672a1.07 1.07 0 0 1-.996-.68 1.072 1.072 0 0 1 .229-1.172L14.4 5.4a.636.636 0 0 0 0-.9l-.9-.9a.636.636 0 0 0-.9 0l-.475.475c-.308.308-.77.396-1.172.229l-.013-.006a1.07 1.07 0 0 1-.667-.99v-.672A.637.637 0 0 0 9.636 2H8.364a.637.637 0 0 0-.637.636v.672a1.07 1.07 0 0 1-.68.996 1.07 1.07 0 0 1-1.172-.229L5.4 3.6a.636.636 0 0 0-.9 0l-.9.9a.636.636 0 0 0 0 .9l.475.475a1.072 1.072 0 0 1 .223 1.185" fill-rule="evenodd"/>\n',
			// wds-icons-volume-off-small.svg
			volumeOff: '<path d="M8.45 2.17L4.664 6.28H1.036C.256 6.28 0 6.739 0 7.175v3.522c0 .436.256.985 1.036.985h3.646l3.785 4.176a1.1 1.1 0 0 0 .533.143.964.964 0 0 0 .5-.137c.33-.185.5-.526.5-.897V3.013c0-.37-.17-.713-.5-.898-.33-.186-.72-.13-1.05.054zm7.192 7.33l2.121-2.122a.807.807 0 1 0-1.142-1.141l-2.122 2.12-2.12-2.12a.808.808 0 0 0-1.142 1.141L13.358 9.5l-2.121 2.121a.807.807 0 1 0 1.142 1.142l2.12-2.12 2.122 2.12a.805.805 0 0 0 1.142 0 .807.807 0 0 0 0-1.142L15.642 9.5z" fill-rule="evenodd"/>\n',
			// wds-icons-volume-small.svg
			volumeOn: '<g fill-rule="evenodd"><path d="M8.45 2.17L4.664 6.28H1.036C.256 6.28 0 6.739 0 7.175v3.522c0 .436.256.985 1.036.985h3.646l3.785 4.176a1.1 1.1 0 0 0 .533.143.964.964 0 0 0 .5-.137c.33-.185.5-.526.5-.897V3.013c0-.37-.17-.713-.5-.898-.33-.186-.72-.13-1.05.054zm4.95 10.156a4.393 4.393 0 0 0 0-6.19.708.708 0 0 0-1.004 1 2.978 2.978 0 0 1 0 4.192.707.707 0 1 0 1.003.998z"/><path d="M17.515 9.231A6.186 6.186 0 0 0 15.7 4.84a.707.707 0 1 0-1.003.998A4.777 4.777 0 0 1 16.1 9.231a4.778 4.778 0 0 1-1.4 3.394.708.708 0 1 0 1.002.999 6.186 6.186 0 0 0 1.814-4.393z"/></g>'
		};

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

			replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-play'), icons.play);
			replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-pause'), icons.pause);
			replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-fullscreen-on'), icons.fullScreenOn);
			replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-fullscreen-off'), icons.fullScreenOff);
			replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-settings'), icons.settings);
			replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-volume-0'), icons.volumeOff);
			replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-volume-50'), icons.volumeOn);
			replaceJWIconWithCustom(controlBar.querySelector('.jw-svg-icon-volume-100'), icons.volumeOn);
		}

		return function (videoPlayerElement, playerInstance) {
			playerInstance.on('ready', function () {
				replaceIcons(videoPlayerElement);
			});
		};
	}
);
