/* global define, google */
define('ext.wikia.adEngine.video.googleImaAdStatus', [], function () {
	'use strict';

	function create(ad) {
		var status = null;

		function setStatus(newStatus) {
			return function () {
				status = newStatus;
			};
		}

		ad.addEventListener(google.ima.AdEvent.Type.RESUMED, setStatus('playing'));
		ad.addEventListener(google.ima.AdEvent.Type.STARTED, setStatus('playing'));
		ad.addEventListener(google.ima.AdEvent.Type.PAUSED, setStatus('paused'));

		return {
			get: function () {
				return status;
			}
		};
	}

	return {
		create: create
	};
});
