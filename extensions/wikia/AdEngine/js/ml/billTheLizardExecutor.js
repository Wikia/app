/*global define*/
define('ext.wikia.adEngine.ml.billTheLizardExecutor', [], function () {
	'use strict';

	var autoPlayDisabled = false,
		methods = [
			'disableAutoPlay'
		];

	return {
		disableAutoPlay: function () {
			autoPlayDisabled = true;
		},
		isAutoPlayDisabled: function () {
			return autoPlayDisabled;
		},
		methods: methods
	};
});
