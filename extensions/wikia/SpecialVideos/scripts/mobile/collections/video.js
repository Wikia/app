define('specialVideos.mobile.collections.videos', [
	'wikia.nirvana'
], function (nirvana) {
	'use strict';

	/**
	 * VideoCollection
	 * @constructor
	 */
	function VideoCollection() {
		// maintains page number for updating collection via 'load more' interaction
		this.page = 1;
		// current filter applied to collection (server-side)
		this.filter = 'trending';
	}

	/**
	 * fetch
	 * @description get new videos from server
	 * @param filter {String} a string value of either 'trending' or 'latest'
	 * @return {jQuery Promise} xhr
	 */
	VideoCollection.prototype.fetch = function (filter) {
		var self = this;

		// if filter is explicitly passed, set it, otherwise
		// request will be set with cached filter value
		if (filter) {
			this.filter = filter;
		}

		// cancel any pending xhr
		if (this.xhr) {
			this.xhr.abort();
		}

		this.xhr = nirvana.getJson('SpecialVideosSpecial', 'getVideos', {
			sort: this.filter,
			// if the sort changes, we reset to page 0
			// otherwise we increment the page number then send request
			page: filter ? 0 : ++this.page
		}).success(function (data) {
			self.data = data;
		});

		return this.xhr;
	};

	return VideoCollection;
});
