/**
 * This file is loaded on when VisualEditor is requested on an article.
 *
 * It should be added as a dependency for "ext.visualEditor.wikia.core" Resource Loader module.
 */
require(['wikia.window', 'mw', 'EditDraftSaving'], function(window, mw, EditDraftSaving) {
	var EDITOR_TYPE = 'editor-ve',
		surface;

	// editing surface is ready, we can now read the draft (if there is any)
	mw.hook('ve.wikia.surfaceReady').add(function (targetEvents) {
		EditDraftSaving.log('ve.wikia.surfaceReady');

		// @see https://doc.wikimedia.org/VisualEditor/master/#!/api/ve.init.Target-method-getSurface
		surface = targetEvents.target.getSurface(); // VeUiDesktopSurface

		console.log('surfaceReady', surface);
	});

	// user is making changes, keep saving a draft
	// @see https://doc.wikimedia.org/VisualEditor/master/#!/api/ve.ui.Surface
	mw.hook('ve.toolbarSaveButton.stateChanged').add(function() {
		if (!surface) return;
		console.log('stateChanged', surface);
	});

	EditDraftSaving.log('ve.js loaded for ' + EDITOR_TYPE);
});
