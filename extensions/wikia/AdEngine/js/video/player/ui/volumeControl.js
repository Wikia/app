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

	function isVideoMuted(video) {
		var mobileVideoAd = video.container.querySelector('video');
		return (mobileVideoAd && mobileVideoAd.muted) || video.isMuted();
	}

	function add(video) {
		var volumeControl = createVolumeControl();

		volumeControl.mute = function () {
			volumeControl.speaker.classList.add('mute');
			video.setVolume(0);
			log('mute', log.levels.info, logGroup);
		};
		volumeControl.unmute = function () {
			volumeControl.speaker.classList.remove('mute');
			video.setVolume(0.75);
			log('unmute', log.levels.info, logGroup);
		};

		volumeControl.addEventListener('click', function(e) {
			if (video.isMuted()) {
				volumeControl.unmute();
			} else {
				volumeControl.mute();
			}
			e.preventDefault();
		});

		video.addEventListener('wikiaAdStarted', function () {
			if (isVideoMuted(video)) {
				volumeControl.mute();
			} else {
				volumeControl.unmute();
			}
			volumeControl.classList.remove('hidden');
		});

		video.container.appendChild(volumeControl);
	}

	return {
		add: add
	};
});
