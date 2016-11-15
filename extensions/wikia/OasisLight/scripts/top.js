Wikia = {};

// Queues:
// * early queue starts when jQuery and modil are loaded -- this might defer onload
// * late queue starts after early and after body onload -- this cannot defer onload
Wikia.queue = {
	early: [],
	late: [],
	runner: function (item) {
		item();
	},
	init: function () {
		Wikia.LazyQueue.makeQueue(Wikia.queue.early, Wikia.queue.runner);
		Wikia.queue.early.start();
	}
};
Wikia.queue.early.push(function () {
	Wikia.LazyQueue.makeQueue(Wikia.queue.late, Wikia.queue.runner);
	function startLateQueueOnLoad() {
		if (document.readyState === 'complete') {
			Wikia.queue.late.start();
		}
	}

	$(function () {
		startLateQueueOnLoad();
		document.addEventListener('readystatechange', startLateQueueOnLoad);
	})
});
