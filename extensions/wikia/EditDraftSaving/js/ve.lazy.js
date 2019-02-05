/**
 * This file is loaded on every page and used to lazy loaded the rest of
 * edit draft handling code when VisualEditor is loaded.
 */
(function(mw) {
	console.log('EditDraftSaving: hook init');

	mw.hook('ve.activate').add(function() {
		console.log('EditDraftSaving: ve.activate hook called');
		mw.loader.load('ext.wikia.EditDraftSaving.ve');
	});
})(window.mediaWiki);
