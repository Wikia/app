$(document).ready( function() {
	window.wikiDom = {
		'type': 'document',
		'children': [
			{
				'type': 'paragraph',
				'content': {
					'text': 'Barack Hussein Obama II is the 44th   and current President of the United States. He is the first African American to hold the office. Obama previously served as a United States Senator from Illinois, from January 2005 until he resigned following his victory in the 2008 presidential election.',
					'annotations': [
						{
							'type': 'textStyle/bold',
							'range': {
								'start': 7,
								'end': 14
							}
						},
						{
							'type': 'textStyle/italic',
							'range': {
								'start': 10,
								'end': 17
							}
						},
						{
							'type': 'object/template',
							'data': {
								'html': '<sup><small>[<a href="#">citation needed</a>]</small></sup>'
							},
							'range': {
								'start': 36,
								'end': 37
							}
						}
					]
				}
			},			
			{
				'type': 'table',
				'attributes': { 'html/style': 'width: 500px; float: left; margin: 0 1em 1em 0; border: solid 1px;' },
				'children': [
					{
						'type': 'tableRow',
						'children': [
							{
								'type': 'tableCell',
								'attributes': { 'html/style': 'border: solid 1px;' },
								'children': [
									{
										'type': 'paragraph',
										'content': { 'text': 'row 1 & cell 1' }
									}
								]
							},
							{
								'type': 'tableCell',
								'attributes': { 'html/style': 'border: solid 1px;' },
								'children': [
									{
										'type': 'paragraph',
										'content': { 'text': 'row 1 & cell 2' }
									}
								]
							},
							{
								'type': 'tableCell',
								'attributes': { 'html/style': 'border: solid 1px;' },
								'children': [
									{
										'type': 'paragraph',
										'content': { 'text': 'row 1 & cell 3' }
									}
								]
							},
							{
								'type': 'tableCell',
								'attributes': { 'html/style': 'border: solid 1px;' },
								'children': [
									{
										'type': 'paragraph',
										'content': { 'text': 'row 1 & cell 4' }
									}
								]
							}							
						]
					},
					{
						'type': 'tableRow',
						'children': [
							{
								'type': 'tableCell',
								'attributes': { 'html/style': 'border: solid 1px;' },
								'children': [
									{
										'type': 'paragraph',
										'content': { 'text': 'row 2 & cell 1' }
									}
								]
							},
							{
								'type': 'tableCell',
								'attributes': { 'html/style': 'border: solid 1px;' },
								'children': [
									{
										'type': 'paragraph',
										'content': { 'text': 'row 2 & cell 2' }
									}
								]
							},
							{
								'type': 'tableCell',
								'attributes': { 'html/style': 'border: solid 1px;' },
								'children': [
									{
										'type': 'paragraph',
										'content': { 'text': 'row 2 & cell 3' }
									}
								]
							},
							{
								'type': 'tableCell',
								'attributes': { 'html/style': 'border: solid 1px;' },
								'children': [
									{
										'type': 'paragraph',
										'content': { 'text': 'row 2 & cell 4' }
									}
								]
							}							
						]
					}
				]
			},
			{
				'type': 'paragraph',
				'content': { 'text': 'Born in Honolulu, Hawaii, Obama is a graduate of Columbia University and Harvard Law School, where he was the president of the Harvard Law Review. He was a community organizer in Chicago before earning his law degree. He worked as a civil rights attorney in Chicago and taught constitutional law at the University of Chicago Law School from 1992 to 2004. He served three terms representing the 13th District in the Illinois Senate from 1997 to 2004.' }
			}
		]
	};
	
	window.documentModel = es.DocumentModel.newFromPlainObject( window.wikiDom );
	window.surfaceModel = new es.SurfaceModel( window.documentModel );
	window.surfaceView = new es.SurfaceView( $( '#es-editor' ), window.surfaceModel );
	window.toolbarView = new es.ToolbarView( $( '#es-toolbar' ), window.surfaceView );

	/*
	 * This code is responsible for switching toolbar into floating mode when scrolling (with
	 * keyboard or mouse).
	 */
	var $toolbarWrapper = $( '#es-toolbar-wrapper' ),
		$toolbar = $( '#es-toolbar' ),
		$window = $( window );
	$window.scroll( function() {
		var toolbarWrapperOffset = $toolbarWrapper.offset();
		if ( $window.scrollTop() > toolbarWrapperOffset.top ) {
			if ( !$toolbarWrapper.hasClass( 'float' ) ) {
				var	left = toolbarWrapperOffset.left,
					right = $window.width() - $toolbarWrapper.outerWidth() - left;
				$toolbarWrapper.css( 'height', $toolbarWrapper.height() ).addClass( 'float' );
				$toolbar.css( { 'left': left, 'right': right } );
			}
		} else {
			if ( $toolbarWrapper.hasClass( 'float' ) ) {
				$toolbarWrapper.css( 'height', 'auto' ).removeClass( 'float' );
				$toolbar.css( { 'left': 0, 'right': 0 } );
			}
		}
	} );

	var $modeButtons = $( '.es-modes-button' ),
		$panels = $( '.es-panel' ),
		$base = $( '#es-base' ),
		currentMode = null,
		modes = {
			'wikitext': {
				'$': $( '#es-mode-wikitext' ),
				'$panel': $( '#es-panel-wikitext' ),
				'update': function() {
					this.$panel.text(
						es.WikitextSerializer.stringify( documentModel.getPlainObject() )
					);
				}
			}
		};

	$.each( modes, function( name, mode ) {
		mode.$.click( function() {
			var disable = $(this).hasClass( 'es-modes-button-down' );
			var visible = $base.hasClass( 'es-showData' );
			$modeButtons.removeClass( 'es-modes-button-down' );
			$panels.hide();
			if ( disable ) {
				if ( visible ) {
					$base.removeClass( 'es-showData' );
					$window.resize();
				}
				currentMode = null;
			} else {
				$(this).addClass( 'es-modes-button-down' );
				mode.$panel.show();
				if ( !visible ) {
					$base.addClass( 'es-showData' );
					$window.resize();
				}
				mode.update.call( mode );
				currentMode = mode;
			}
		} );
	} );

	window.surfaceModel.on( 'transact', function() {
console.log("123");
		if ( currentMode ) {
			currentMode.update.call( currentMode );
		}
	} );

	$( '#es-docs, #es-base' ).css( { 'visibility': 'visible' } );
} );