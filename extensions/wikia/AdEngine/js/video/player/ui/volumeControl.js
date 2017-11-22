/*global define*/
define('ext.wikia.adEngine.video.player.ui.volumeControl', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.ui.volumeControl';

	function createVolumeControl() {
		var volume = doc.createElement('div'),
			speaker = doc.createElement('a');

		speaker.className = 'speaker';
		speaker.appendChild(doc.createElement('span'));
		volume.className = 'ima-mute-div volume-control hidden';

		volume.appendChild(speaker);
		volume.speaker = speaker;
		log('volume control is added', log.levels.info, logGroup);

		volume.mute = function () {
			volume.speaker.classList.add('mute');
			log('mute', log.levels.info, logGroup);
		};

		volume.unmute = function () {
			volume.speaker.classList.remove('mute');
			log('unmute', log.levels.info, logGroup);
		};

		return volume;
	}

	function updateCurrentState(video, volumeControl) {
		if (video.isMuted() || video.isMobilePlayerMuted()) {
			volumeControl.mute();
		} else {
			volumeControl.unmute();
		}
	}

	function add(video, params, panel) {
		var volumeControl = createVolumeControl(),
			container = panel ? panel.getContainer() : video.container;

		video.addEventListener('wikiaVolumeChange', function () {
			updateCurrentState(video, volumeControl);
		});

		video.addEventListener('wikiaAdPlay', function () {
			updateCurrentState(video, volumeControl);
			volumeControl.classList.remove('hidden');
		});

		volumeControl.addEventListener('click', function (e) {
			video.ima.dispatchEvent('wikiaVolumeChangeClicked');
			video.volumeToggle();
			e.preventDefault();
		});

		container.appendChild(volumeControl);
	}

	return {
		add: add
	};
});
