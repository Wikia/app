var trackSpecialCssClick = function ( action, label, value, params, event ) {
	'use strict';

	Wikia.Tracker.track({
		category: 'special-css',
		action: action,
		browserEvent: event,
		label: label,
		trackingMethod: 'analytics',
		value: value
	}, params );
};

$(function() {
	'use strict';

	// impressions
	Wikia.Tracker.buildTrackingFunction({
		category: 'special-css',
		trackingMethod: 'analytics',
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

	require(['wikia.ace.editor', 'editpage.events'], function(ace, events){
		var options = {
				showPrintMargin: false,
				fontFamily: 'Monaco, Menlo, Ubuntu Mono, Consolas, source-code-pro, monospace'
			},
			// aceScriptsPath is set in PHP controller SpecialCssController.class.php:99
			config = {
				workerPath: window.aceScriptsPath
			},
			inputAttr = {
				name: 'cssContent'
			},
			editorInitContent,
			disableBeforeUnload = false,
			EDITOR_BOTTOM_MARGIN = 10,
			heightUpdateFunction = function( editor ) {
				var $editorContainer = $( '#cssEditorContainer' ),
					newHeight = $( '.css-side-bar' ).height() -
						$( '.editor-changes-info-wrapper' ).children().outerHeight( true ) -
						EDITOR_BOTTOM_MARGIN;

				$editorContainer.outerHeight( newHeight );

				// This call is required for the editor to fix all of
				// its inner structure for adapting to a change in size
				editor.resize();
			};

		ace.setConfig( config );
		ace.init( 'cssEditorContainer', inputAttr );
		ace.setOptions( options );
		ace.setTheme();
		ace.setMode();

		editorInitContent = ace.getContent();

		heightUpdateFunction( ace.getEditorInstance() );

		$( '#cssEditorForm' ).submit(function( e ) {
			var $form = $( this ),
				hiddenInput = ace.getInput().val( ace.getContent() );

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

		events.attachDiff('showChanges');

		//noinspection FunctionWithInconsistentReturnsJS,JSUnusedLocalSymbols
		$( window ).bind( 'beforeunload', function() {
			if ( !disableBeforeUnload && editorInitContent !== ace.getContent() ) {
				return $.msg( 'special-css-leaveconfirm-message' );
			}
		});

	});
});
