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
		volume.className = 'ima-mute-div hidden';

		volume.appendChild(speaker);
		volume.speaker = speaker;
		log('volume control is added', log.levels.info, logGroup);

		return volume;
	}

	function add(video) {
		var volume = createVolumeControl(),
			mobileVideoAd = video.container.querySelector('video');

		volume.mute = function () {
			volume.speaker.classList.add('mute');
			video.setVolume(0);
			log('mute', log.levels.info, logGroup);
		};
		volume.unmute = function () {
			volume.speaker.classList.remove('mute');
			video.setVolume(0.75);
			log('unmute', log.levels.info, logGroup);
		};

		volume.addEventListener('click', function(e) {
			if (video.isMuted()) {
				volume.unmute();
			} else {
				volume.mute();
			}
			e.preventDefault();
		});

		video.addEventListener('wikiaAdStarted', function () {
			if (mobileVideoAd && mobileVideoAd.muted) {
				volume.mute();
			} else {
				volume.unmute();
			}
			volume.classList.remove('hidden');
		});

		video.container.appendChild(volume);
	}

	return {
		add: add
	};
});
