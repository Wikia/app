/*global define*/
define('ext.wikia.adEngine.ml.bucketizers', function () {
	'use strict';

	/**
	 * <400 as 400, 400-499 as 500, 500-599 as 600, 600-699 as 700,
	 * 700-799 as 800, 800-900 as 899, 900-999 as 1000
	 * and all from 1000 as 1100
	 *
	 * @param {Number} height
	 * @returns {Number}
	 */
	function bucketizeViewportHeight(height) {
		var buckets = [
			0, 400, 500, 600, 700, 800, 900, 1000
		];
		var bucket = 1100;
		for (var i = 1; i < buckets.length; i++) {
			if (height >= buckets[i-1] && height < buckets[i]) {
				bucket = buckets[i];
			}
		}
		return bucket;
	}

	return {
		bucketizeViewportHeight: bucketizeViewportHeight
	};
});
