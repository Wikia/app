var trackSpecialCssClick = function ( action, label, value, params, event ) {
	'use strict';

	Wikia.Tracker.track({
		category: 'special-css',
		action: action,
		browserEvent: event,
		label: label,
		trackingMethod: 'both',
		value: value
	}, params );
};

$(function() {
	'use strict';

	// impressions
	Wikia.Tracker.buildTrackingFunction({
		category: 'special-css',
		trackingMethod: 'both',
		action: Wikia.Tracker.ACTIONS.IMPRESSION
	});

	// click on update-items and educational modules
	$( '#cssEditorForm' ).on( 'click', 'a[data-tracking]', function( e ) {
		var $t = $( this );
		trackSpecialCssClick( Wikia.Tracker.ACTIONS.CLICK, $t.data( 'tracking' ), null, {
			href: $t.attr( 'href' )
		}, e );
	});

	// history and show changes
	$( '.wikia-menu-button-submit a' ).on( 'click', function( e ) {
		var $t = $( this );
		switch ( $t.data( 'id' ) ) {
			case 0:
				trackSpecialCssClick( Wikia.Tracker.ACTIONS.CLICK, 'history', null, { href: $t.attr( 'href' ) }, e );
				return;
			case 1:
				trackSpecialCssClick( Wikia.Tracker.ACTIONS.OPEN, 'changes', null, {}, e );
				return;
		}
	});

	var disableBeforeUnload = false,
		EDITOR_BOTTOM_MARGIN = 10,
		ace = window.ace,
		heightUpdateFunction = function( editor ) {
			var $editorContainer = $( '#cssEditorContainer' ),
				newHeight = $( '.css-side-bar' ).height() -
					$( '.editor-changes-info-wrapper' ).children().outerHeight( true ) -
					EDITOR_BOTTOM_MARGIN;

			$editorContainer.outerHeight( newHeight );

			// This call is required for the editor to fix all of
			// its inner structure for adapting to a change in size
			editor.resize();
		},
		editor,
		editorSession,
		editorInitContent;

	// aceScriptsPath is set in PHP controller SpecialCssController.class.php:99
	ace.config.set( 'workerPath', window.aceScriptsPath ); /* JSlint ignore */

	editor = ace.edit( 'cssEditorContainer' );
	editor.setTheme( 'ace/theme/geshi' );
	editor.setShowPrintMargin( false );
	editorSession = editor.getSession();
	editorSession.setMode( 'ace/mode/css' );

	editorInitContent = editorSession.getValue();

	heightUpdateFunction( editor );

	$( '#cssEditorForm' ).submit(function( e ) {
		var $form = $( this ),
			hiddenInput = $( '<input/>' )
				.attr( 'type', 'hidden' )
				.attr( 'name', 'cssContent' )
				.val( editorSession.getValue() );

		disableBeforeUnload = true;
		trackSpecialCssClick( Wikia.Tracker.ACTIONS.SUBMIT, 'publish', null, {}, e );

		$form.append( hiddenInput );

		// prevent submitting immediately so we can track this event
		e.preventDefault();
		$form.unbind( 'submit' );
		setTimeout(function() {
			$form.submit();
		}, 100 );
	});

	$( '#showChanges' ).click(function( event ) {
		event.preventDefault();

		require( [ 'wikia.ui.factory' ], function( uiFactory ) {
			uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
				var showChangesModalConfig = {
					vars: {
						id: 'ShowChangesModal',
						title: $.msg( 'special-css-diff-modal-title' ),
						size: 'large',
						content: '<div class="diffContent modalContent"></div>'
					}
				};

				uiModal.createComponent( showChangesModalConfig, function( showChangesModal ) {
					showChangesModal.deactivate();
					$.when(
							$.nirvana.sendRequest({
								controller: 'SpecialCss',
								method: 'getDiff',
								type: 'post',
								data: {
									wikitext: editor.getSession().getValue()
								}
							}),

							// load CSS for diff
							mw.loader.use( 'mediawiki.action.history.diff' )
						).done(function( ajaxData ) {
							showChangesModal.$content.find( '.diffContent' ).html( ajaxData[ 0 ].diff );
							showChangesModal.activate();
						});
					showChangesModal.show();
				});
			});
		});
	});

	//noinspection FunctionWithInconsistentReturnsJS,JSUnusedLocalSymbols
	$( window ).bind( 'beforeunload', function() {
		if ( !disableBeforeUnload && editorInitContent !== editorSession.getValue() ) {
			return $.msg( 'special-css-leaveconfirm-message' );
		}
	});
});
