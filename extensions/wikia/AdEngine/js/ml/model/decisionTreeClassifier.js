/*global define*/
define('ext.wikia.adEngine.ml.model.decisionTreeClassifier', [
	'wikia.nirvana',
	'wikia.window'
], function (nirvana, win) {
	'use strict';

	function findMax(nums) {
		var index = 0;
		for (var i = 0; i < nums.length; i++) {
			index = nums[i] > nums[index] ? i : index;
		}

		return index;
	}

	function create(modelId) {
		var lChilds, rChilds, thresholds, indices, classes;

		function loadParameters(callback) {
			nirvana.sendRequest({
				controller: 'AdEngine2Api',
				method: 'getModelData',
				format: 'json',
				type: 'get',
				scriptPath: win.wgCdnApiUrl,
				data: {
					id: modelId
				},
				callback: function(params) {
					lChilds = params.lChilds;
					rChilds = params.rChilds;
					thresholds = params.thresholds;
					indices = params.indices;
					classes = params.classes;

					callback(params);
				}
			});
		}

		function predict(features, node) {
			if (!lChilds || !rChilds || !thresholds || !indices || !classes) {
				return null;
			}

			node = (typeof node !== 'undefined') ? node : 0;
			if (thresholds[node] !== -2) {
				if (features[indices[node]] <= thresholds[node]) {
					return predict(features, lChilds[node]);
				} else {
					return predict(features, rChilds[node]);
				}
			}

			return findMax(classes[node]);
		}

		return {
			loadParameters: loadParameters,
			predict: predict
		};
	}

	return {
		create: create
	};
});
