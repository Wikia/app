/*global define*/
define('ext.wikia.adEngine.ml.model.decisionTreeClassifier', [
	'wikia.log'
], function () {
	'use strict';

	function buildUrl(modelId) {
		return '/wikia.php?controller=AdEngine2Api&method=getModelData&id=' + modelId
	}

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
			var request = new XMLHttpRequest();

			request.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					var params = JSON.parse(this.responseText);

					lChilds = params.lChilds;
					rChilds = params.rChilds;
					thresholds = params.thresholds;
					indices = params.indices;
					classes = params.classes;

					callback(params);
				}
			};

			request.open('GET', buildUrl(modelId), true);
			request.send();
		}

		function predict(features, node) {
			if (!lChilds || !rChilds || !thresholds || !indices || !classes) {
				return;
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
