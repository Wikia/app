define('specialVideos.mobile.collections.videos', [
	'wikia.nirvana'
], function (nirvana) {
	'use strict';

	var filters = {
		trending: 'trend',
		latest: 'recent'
	};

	/**
	 * VideoCollection
	 * @constructor
	 */
	function VideoCollection() {
		// set page to 1, maintains page number for updating collection via 'load more' interaction
		this.page = 1;
		this.filter = filters.trending;
	}

	VideoCollection.prototype.getFilterKey = function (filter) {
		return filter ? filters[filter.toLowerCase()] : this.filter;
	};

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
			this.page = 1;
		}

		// cancel any pending xhr
		if (this.xhr) {
			this.xhr.abort();
		}

		this.xhr = nirvana.getJson('SpecialVideosSpecial', 'getVideos', {
			sort: this.getFilterKey(filter),
			// if the sort changes, we reset to page 0
			// otherwise we increment the page number then send request
			page: filter ? 1 : ++this.page
		}).success(function (data) {
			self.data = data;
		});

		return this.xhr;
	};

	return VideoCollection;
});
