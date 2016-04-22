require([
	'jquery',
	'mw',
	'ext.wikia.spitfires.experiments.tracker',
	'wikia.loader',
	'wikia.mustache'
], function ($, mw, tracker, cache, loader, mustache) {

	function init() {
		console.log('Experiment initiated');
	}

	$(init);
});
