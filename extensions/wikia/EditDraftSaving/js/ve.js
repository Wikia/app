/**
 * This file is loaded on when VisualEditor is requested on an article.
 *
 * It should be added as a dependency for "ext.visualEditor.wikia.core" Resource Loader module.
 */
(function(mw) {
	console.log('EditDraftSaving: hook init');

	mw.hook('ve.activationComplete').add(function () {
		console.log('EditDraftSaving: ve.activationComplete hook called, VisualEditor is ready');
		console.log('EditDraftSaving: ', arguments);
	});
})(window.mediaWiki);
