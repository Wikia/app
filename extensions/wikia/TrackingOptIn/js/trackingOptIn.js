define('wikia.trackingOptIn', [
	'wikia.lazyqueue'
], function (lazyQueue) {
	var optIn = false,
		userConsentQueue = [];

	lazyQueue.makeQueue(userConsentQueue, function (callback) {
		callback(optIn);
	});

	function init() {
		var trackingOptInModalUrl = window.location.origin + '/__cb' + window.wgStyleVersion + '/extensions/wikia/TrackingOptIn/dist/opt_in_modal.html';
		var trackingOptInModalFrame = document.createElement('iframe');
		trackingOptInModalFrame.src = trackingOptInModalUrl;

		window.addEventListener('message', function (event) {
			console.log('got data from modal: ' + event.source.location + ' ' + event.data);
		});

		trackingOptInModalFrame.width = '100%';
		trackingOptInModalFrame.height = '' + window.innerHeight;

		trackingOptInModalFrame.style.position = 'fixed';
		trackingOptInModalFrame.style.top = '0px';
		trackingOptInModalFrame.style.left = '0px';
		trackingOptInModalFrame.style.zIndex = '999999999';

		document.body.appendChild(trackingOptInModalFrame);
console.log('url is:' + trackingOptInModalUrl);
		trackingOptInModalFrame.onload = function () {
			trackingOptInModalFrame.contentWindow.postMessage('test', trackingOptInModalUrl);
		};
	}

	function pushToUserConsentQueue(callback) {
		userConsentQueue.push(callback);
	}

	return {
		init: init,
		pushToUserConsentQueue: pushToUserConsentQueue
	}
});
