/*global define*/
define('ext.wikia.adEngine.utils.math', [
], function () {
	'use strict';

	function getBucket(number, bucketSize) {
		return parseInt(number / bucketSize, 10) * bucketSize;
	}

	return {
		getBucket: getBucket
	};
});
