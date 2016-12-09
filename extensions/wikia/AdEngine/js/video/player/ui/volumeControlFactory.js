/*global define*/
define('ext.wikia.adEngine.video.player.ui.volumeControlFactory', [
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (doc, log, win) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.ui.volumeControlFactory';

	function create(video) {
		var muteDiv,
			speaker;

		muteDiv = createMuteDiv();
		speaker = muteDiv.querySelector('.speaker');

		muteDiv.addEventListener('click', function(e) {
			e.preventDefault();
			onAdMuteClick(video, speaker);
		});

		video.addEventListener(win.google.ima.AdEvent.Type.LOADED, function () {
			unmute(video, speaker);
			muteDiv.classList.remove('hidden');
		});
		video.addEventListener(win.google.ima.AdEvent.Type.ALL_ADS_COMPLETED, function () {
			unmute(video, speaker);
			muteDiv.classList.add('hidden');
		});

		return muteDiv;
	}

	function createMuteDiv() {
		var muteDiv,
			speaker;

		muteDiv = doc.createElement('div');
		muteDiv.className = 'ima-mute-div';
		muteDiv.classList.add('hidden');
		speaker = doc.createElement('a');
		speaker.className = 'speaker';
		speaker.appendChild(doc.createElement('span'));
		muteDiv.appendChild(speaker);
		log('volume control is added', log.levels.info, logGroup);

		return muteDiv;
	}

	function onAdMuteClick(video, speaker) {
		if (video.isMuted()) {
			unmute(video, speaker);
		} else {
			mute(video, speaker);
		}
	}

	function mute(video, speaker) {
		log('mute', log.levels.info, logGroup);
		speaker.classList.add('mute');
		video.setVolume(0);
	}

	function unmute(video, speaker) {
		log('unmute', log.levels.info, logGroup);
		speaker.classList.remove('mute');
		video.setVolume(0.75);
	}

	return {
		create: create
	};
});
