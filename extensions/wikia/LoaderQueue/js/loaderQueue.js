/**
require(['lazyQueue', 'mw'], function(lazyQueue, mw) {
	function callback(item) {
		if (!item || !item.deps || !item.callback) {
			throw new Error('LoaderQueue requires both deps and callback fields to be defined');
		}

		// load all dependencies and then pass them
		mw.loader.use(item.deps).then(function() {
			require(item.deps, item.callback);
		});
	}

	if (window.wgLoaderQueue) {
		lazyQueue.makeQueue(window.wgLoaderQueue, callback);
		window.wgLoaderQueue.start();
	}
});
**/
