/**
 * This file is loaded on when VisualEditor is requested on an article.
 *
 * It should be added as a dependency for "ext.visualEditor.wikia.core" Resource Loader module.
 */
require(['wikia.window', 'mw', 'EditDraftSaving'], function(window, mw, EditDraftSaving) {
	var EDITOR_TYPE = 'editor-ve',
		ve = window.ve,
		surface;

	// code borrowed from ve.ui.WikiaSourceModeDialog
	function restoreDraft(html) {
		if (!surface) return;
		var target = surface.target;

		EditDraftSaving.log('Restoring a draft...');

		target.deactivating = true;
		target.toolbarSaveButton.disconnect( target );
		target.toolbarSaveButton.$element.detach();
		target.getToolbar().$actions.empty();

		target.tearDownSurface( true /* noAnimate */ ).done( function () {

			target.deactivating = false;
			target.activating = true;
			target.edited = true;
			target.doc = ve.createDocumentFromHtml( html );
			target.docToSave = null;
			target.clearPreparedCacheKey();

			target.setupSurface(target.doc, function () {
				target.startSanityCheck();
				target.emit('surfaceReady');

				EditDraftSaving.log('Draft has been restored');
				EditDraftSaving.onDraftRestore(EDITOR_TYPE);
			});
		});
	}

	// editing surface is ready
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

	// editor is fully loaded, we can now read the draft (if there is any)
	mw.hook('ve.activationComplete').add(function() {
		EditDraftSaving.log('VisualEditor is ready');

		var draftData = EditDraftSaving.readDraft();

		// make sure that this draft comes from this editor
		if (draftData && draftData.editor === EDITOR_TYPE) {
			restoreDraft(draftData.draftText);
		}
	});

	EditDraftSaving.log('initialized for ' + EDITOR_TYPE);
});
