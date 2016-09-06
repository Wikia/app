/*global define*/
define('ext.wikia.adEngine.utils.math', [
], function () {
	'use strict';

	function getBucket(number, bucketSize) {
		return parseInt(number / bucketSize, 10) * bucketSize;
	}

	function leftPad(number, offset) {
		var label = number + '';
		while (label.length < offset) {
			label = '0' + label;
		}

		return label;
	}

	return {
		getBucket: getBucket,
		leftPad: leftPad
	};
});
