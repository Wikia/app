/**
 * This file is loaded on when VisualEditor is requested on an article.
 *
 * It should be added as a dependency for "ext.visualEditor.wikia.core" Resource Loader module.
 */
require(['wikia.window', 'mw', 'EditDraftSaving'], function(window, mw, EditDraftSaving) {
	var EDITOR_TYPE = 'editor-ve',
		ve = window.ve,
		surface;

	// editing surface is ready, we can now read the draft (if there is any)
	mw.hook('ve.wikia.surfaceReady').add(function (targetEvents) {
		EditDraftSaving.log('VisualEditor editing surface is ready');

		// @see https://doc.wikimedia.org/VisualEditor/master/#!/api/ve.init.Target-method-getSurface
		surface = targetEvents.target.getSurface(); // VeUiDesktopSurface
	});

	// user is making changes, keep saving a draft
	// @see https://doc.wikimedia.org/VisualEditor/master/#!/api/ve.ui.Surface
	mw.hook('ve.toolbarSaveButton.stateChanged').add(function() {
		if (!surface || !surface.model) return;

		// code borrowed from ve.ui.WikiaSourceModeDialog
		// @see https://doc.wikimedia.org/VisualEditor/master/#!/api/ve.init.mw.ArticleTarget-method-serialize
		var surfaceDom = ve.dm.converter.getDomFromModel( surface.model.documentModel, false ),
			content = surfaceDom.body.innerHTML;

		EditDraftSaving.log(content);

		EditDraftSaving.storeDraft({
			editor: EDITOR_TYPE,
			draftText: content
		});
	});

	EditDraftSaving.log('initialized for ' + EDITOR_TYPE);
});
