/* global define */
define('ext.wikia.adEngine.utils.sampler', [
	'wikia.querystring'
], function (QueryString) {
	'use strict';

	var qs = new QueryString(),
		queryStringParam = 'ignored_samplers';

	function samplerIsIgnored(name) {
		var ignored = qs.getVal(queryStringParam, '').split(',');
		return ignored.indexOf(name) > -1;
	}

	function sample(name, partToSample, all) {
		return samplerIsIgnored(name) ? true : getRandomInt(0, all) < partToSample;
	}

	function getRandomInt(min, max) {
		return Math.floor(Math.random() * (max - min)) + min;
	}

	return {
		sample: sample
	};
});
