/*global define*/
define('ext.wikia.adEngine.video.player.ui.soundControl', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.ui.soundControl',
		volumeOn = '<svg width="18" height="14" viewBox="0 0 18 14" xmlns="http://www.w3.org/2000/svg"><g><path d="M8.45.17L4.664 4.28H1.036C.256 4.28 0 4.74 0 5.175v3.522c0 .436.256.985 1.036.985h3.646l3.785 4.176c.165.092.35.143.533.143a.964.964 0 0 0 .5-.136c.33-.185.5-.526.5-.897V1.013c0-.37-.17-.713-.5-.898-.33-.186-.72-.13-1.05.054zm4.95 10.156a4.393 4.393 0 0 0 0-6.19.708.708 0 0 0-1.004 1 2.978 2.978 0 0 1 0 4.192.707.707 0 1 0 1.003.998z"/><path d="M17.515 7.23A6.186 6.186 0 0 0 15.7 2.84a.707.707 0 1 0-1.003.998A4.777 4.777 0 0 1 16.1 7.23a4.778 4.778 0 0 1-1.4 3.395.708.708 0 1 0 1.002 1 6.186 6.186 0 0 0 1.814-4.394z"/></g></svg>',
		volumeOff = '<svg width="22" height="14" viewBox="0 0 22 14" xmlns="http://www.w3.org/2000/svg"><path d="M8.45.17L4.664 4.28H1.036C.256 4.28 0 4.74 0 5.175v3.522c0 .436.256.985 1.036.985h3.646l3.785 4.176c.165.092.35.143.533.143a.964.964 0 0 0 .5-.136c.33-.185.5-.526.5-.897V1.013c0-.37-.17-.713-.5-.898-.33-.186-.72-.13-1.05.054zM18.413 7l3.294-3.294a1 1 0 0 0-1.412-1.413L17 5.588l-3.294-3.295a.998.998 0 1 0-1.413 1.413L15.588 7l-3.295 3.295a.998.998 0 1 0 1.413 1.412L17 8.413l3.295 3.294a.996.996 0 0 0 1.412 0 1 1 0 0 0 0-1.412L18.413 7z"/></svg>';

	function createSoundControl() {
		var speaker = doc.createElement('a');

		speaker.classList.add('sound-control', 'control-bar-item');

		log('volume control is added', log.levels.info, logGroup);

		speaker.mute = function () {
			speaker.classList.add('mute');
			speaker.innerHTML = volumeOff;

			log('mute', log.levels.info, logGroup);
		};

		speaker.unmute = function () {
			speaker.classList.remove('mute');
			speaker.innerHTML = volumeOn;

			log('unmute', log.levels.info, logGroup);
		};

		return speaker;
	}

	function updateCurrentState(video, soundControl) {
		if (video.isMuted() || video.isMobilePlayerMuted()) {
			soundControl.mute();
		} else {
			soundControl.unmute();
		}
	}

	function add(video, params) {
		var soundControl = createSoundControl();

		video.addEventListener('wikiaVolumeChange', function () {
			updateCurrentState(video, soundControl);
		});

		video.addEventListener('wikiaAdStarted', function () {
			updateCurrentState(video, soundControl);
		});

		soundControl.addEventListener('click', function (e) {
			video.volumeToggle();
			e.preventDefault();
		});

		params.controlBarItems.appendChild(soundControl);
	}

	return {
		add: add
	};
});
