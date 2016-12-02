/*global define*/
define('ext.wikia.adEngine.video.volumeControlHandler', [
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (doc, log, win) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.volumeControlHandler';

	function init(ima) {
		var muteDiv,
			speaker;

		muteDiv = createMuteDiv(ima.container);
		speaker = muteDiv.querySelector('.speaker');

		muteDiv.addEventListener('click', function(e) {
			e.preventDefault();
			onAdMuteClick(ima, speaker);
		});

		ima.addEventListener(win.google.ima.AdEvent.Type.LOADED, function () {
			unmute(ima, speaker);
			muteDiv.classList.remove('hidden');
		});
		ima.addEventListener(win.google.ima.AdEvent.Type.ALL_ADS_COMPLETED, function () {
			unmute(ima, speaker);
			muteDiv.classList.add('hidden');
		});
	}

	function createMuteDiv(container) {
		var muteDiv,
			speaker;

		muteDiv = doc.createElement('div');
		muteDiv.className = 'ima-mute-div';
		muteDiv.classList.add('hidden');
		speaker = doc.createElement('a');
		speaker.className = 'speaker';
		speaker.appendChild(doc.createElement('span'));
		muteDiv.appendChild(speaker);
		container.appendChild(muteDiv);
		log('volume control is added', log.levels.info, logGroup);

		return muteDiv;
	}

	function onAdMuteClick(ima, speaker) {
		if (ima.adMuted) {
			unmute(ima, speaker);
		} else {
			mute(ima, speaker);
		}
	}

	function mute(ima, speaker) {
		log('mute', log.levels.info, logGroup);
		speaker.classList.add('mute');
		ima.adMuted = true;
		ima.adsManager.setVolume(0);
	}

	function unmute(ima, speaker) {
		log('unmute', log.levels.info, logGroup);
		speaker.classList.remove('mute');
		ima.adMuted = false;
		ima.adsManager.setVolume(0.75);
	}

	return {
		init: init
	};
});
