/**
 * Configuration of Dialog module for wikiEditor
 */
( function( $ ) { $.wikiEditor.modules.dialogs.config = {

replaceIcons: function( $textarea ) {
	$textarea
		.wikiEditor( 'removeFromToolbar', { 'section': 'main', 'group': 'insert', 'tool': 'xlink' } )
		.wikiEditor( 'removeFromToolbar', { 'section': 'main', 'group': 'insert', 'tool': 'ilink' } )
		.wikiEditor( 'removeFromToolbar', { 'section': 'main', 'group': 'insert', 'tool': 'reference' } )
		.wikiEditor( 'removeFromToolbar', { 'section': 'advanced', 'group': 'insert', 'tool': 'table' } )
		.wikiEditor( 'addToToolbar', {
			'section': 'main',
			'group': 'insert',
			'tools': {
				'link': {
					'labelMsg': 'wikieditor-toolbar-tool-link',
					'type': 'button',
					'icon': 'insert-link.png',
					'offset': [2, -1654],
					'action': {
						'type': 'dialog',
						'module': 'insert-link'
					}
				},
				'reference': {
					'labelMsg': 'wikieditor-toolbar-tool-reference',
					'filters': [ 'body.ns-subject' ],
					'type': 'button',
					'icon': 'insert-reference.png',
					'offset': [2, -1798],
					'action': {
						'type': 'dialog',
						'module': 'insert-reference'
					}
				}
			}
		} )
		.wikiEditor( 'addToToolbar', {
			'section': 'advanced',
			'group': 'insert',
			'tools': {
				'table': {
					'labelMsg': 'wikieditor-toolbar-tool-table',
					'type': 'button',
					'icon': 'insert-table.png',
					'offset': [2, -1942],
					'action': {
						'type': 'dialog',
						'module': 'insert-table'
					}
				}
			}
		} )
		.wikiEditor( 'addToToolbar', {
			'section': 'advanced',
			'groups': {
				'search': {
					'tools': {
						'replace': {
							'labelMsg': 'wikieditor-toolbar-tool-replace',
							'type': 'button',
							'icon': 'search-replace.png',
							'offset': [-70, -214],
							'action': {
								'type': 'dialog',
								'module': 'search-and-replace'
							}
						}
					}
				}
			}
		} );
},

getDefaultConfig: function () {
	return { 'dialogs': {
		'insert-link': {
			titleMsg: 'wikieditor-toolbar-tool-link-title',
			id: 'wikieditor-toolbar-link-dialog',
			html: '\
				<fieldset>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<label for="wikieditor-toolbar-link-int-target" rel="wikieditor-toolbar-tool-link-int-target" id="wikieditor-toolbar-tool-link-int-target-label"></label>\
						<div id="wikieditor-toolbar-link-int-target-status"></div>\
						<input type="text" id="wikieditor-toolbar-link-int-target" />\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<label for="wikieditor-toolbar-link-int-text" rel="wikieditor-toolbar-tool-link-int-text"></label>\
						<input type="text" id="wikieditor-toolbar-link-int-text" />\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<div class="wikieditor-toolbar-floated-field-wrapper">\
							<input type="radio" id="wikieditor-toolbar-link-type-int" name="wikieditor-toolbar-link-type" selected />\
							<label for="wikieditor-toolbar-link-type-int" rel="wikieditor-toolbar-tool-link-int"></label>\
						</div>\
						<div class="wikieditor-toolbar-floated-field-wrapper">\
							<input type="radio" id="wikieditor-toolbar-link-type-ext" name="wikieditor-toolbar-link-type" />\
							<label for="wikieditor-toolbar-link-type-ext" rel="wikieditor-toolbar-tool-link-ext"></label>\
						</div>\
					</div>\
				</fieldset>',
			init: function() {
				function isExternalLink( s ) {
					// The following things are considered to be external links:
					// * Starts a URL protocol
					// * Starts with www.
					// All of these are potentially valid titles, and the latter two categories match about 6300
					// titles in enwiki's ns0. Out of 6.9M titles, that's 0.09%
					if ( typeof arguments.callee.regex == 'undefined' ) {
						// Cache the regex
						arguments.callee.regex =
							new RegExp( "^(" + mw.config.get( 'wgUrlProtocols' ) + "|www\\.)", 'i');
					}
					return s.match( arguments.callee.regex );
				}
				// Updates the status indicator above the target link
				function updateWidget( status ) {
					$( '#wikieditor-toolbar-link-int-target-status' ).children().hide();
					$( '#wikieditor-toolbar-link-int-target' ).parent()
						.removeClass(
							'status-invalid status-external status-notexists status-exists status-loading'
						);
					if ( status ) {
						$( '#wikieditor-toolbar-link-int-target-status-' + status ).show();
						$( '#wikieditor-toolbar-link-int-target' ).parent().addClass( 'status-' + status );
					}
					if ( status == 'invalid' ) {
						$( '.ui-dialog:visible .ui-dialog-buttonpane button:first' )
							.attr( 'disabled', true )
							.addClass( 'disabled' );
					} else {
						$( '.ui-dialog:visible .ui-dialog-buttonpane button:first' )
							.removeAttr('disabled')
							.removeClass('disabled');
					}
				}
				// Updates the UI to show if the page title being inputed by the user exists or not
				// accepts parameter internal for bypassing external link detection
				function updateExistence( internal ) {
					// ensure the internal parameter is a boolean
					if ( internal != true ) internal = false;
					// Abort previous request
					var request = $( '#wikieditor-toolbar-link-int-target-status' ).data( 'request' );
					if ( request ) {
						request.abort();
					}
					var target = $( '#wikieditor-toolbar-link-int-target' ).val();
					var cache = $( '#wikieditor-toolbar-link-int-target-status' ).data( 'existencecache' );
					if ( cache[target] ) {
						updateWidget( cache[target] );
						return;
					}
					if ( target.replace( /^\s+$/,'' ) == '' ) {
						// Hide the widget when the textbox is empty
						updateWidget( false );
						return;
					}
					// If the forced internal paremter was not true, check if the target is an external link
					if ( !internal && isExternalLink( target ) ) {
						updateWidget( 'external' );
						return;
					}
					if ( target.indexOf( '|' ) != -1 ) {
						// Title contains | , which means it's invalid
						// but confuses the API. Show invalid and bypass API
						updateWidget( 'invalid' );
						return;
					}
					// Show loading spinner while waiting for the API to respond
					updateWidget( 'loading' );
					// Call the API to check page status, saving the request object so it can be aborted if
					// necessary
					$( '#wikieditor-toolbar-link-int-target-status' ).data(
						'request',
						$.ajax( {
							url: mw.util.wikiScript( 'api' ),
							dataType: 'json',
							data: {
								'action': 'query',
								'indexpageids': '',
								'titles': target,
								'converttitles': '',
								'format': 'json'
							},
							success: function( data ) {
								var status;
								if ( !data || typeof data.query == 'undefined' ) {
									// This happens in some weird cases
									status = false;
								} else {
									var page = data.query.pages[data.query.pageids[0]];
									status = 'exists';
									if ( typeof page.missing != 'undefined' )
										status = 'notexists';
									else if ( typeof page.invalid != 'undefined' )
										status = 'invalid';
								}
								// Cache the status of the link target if the force internal parameter was not
								// passed
								if ( !internal ) cache[target] = status;
								updateWidget( status );
							}
						} )
					);
				}
				$( '#wikieditor-toolbar-link-type-int, #wikieditor-toolbar-link-type-ext' ).click( function() {
					if( $( '#wikieditor-toolbar-link-type-ext' ).is( ':checked' ) ) {
						// Abort previous request
						var request = $( '#wikieditor-toolbar-link-int-target-status' ).data( 'request' );
						if ( request ) {
							request.abort();
						}
						updateWidget( 'external' );
					}
					if( $( '#wikieditor-toolbar-link-type-int' ).is( ':checked' ) )
						updateExistence( true );
				});
				// Set labels of tabs based on rel values
				$(this).find( '[rel]' ).each( function() {
					$(this).text( mediaWiki.msg( $(this).attr( 'rel' ) ) );
				});
				// Set tabindexes on form fields
				$.wikiEditor.modules.dialogs.fn.setTabindexes( $(this).find( 'input' ).not( '[tabindex]' ) );
				// Setup the tooltips in the textboxes
				$( '#wikieditor-toolbar-link-int-target' )
					.data( 'tooltip', mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-tooltip' ) );
				$( '#wikieditor-toolbar-link-int-text' )
					.data( 'tooltip', mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-text-tooltip' ) );
				$( '#wikieditor-toolbar-link-int-target, #wikieditor-toolbar-link-int-text' )
					.each( function() {
						var tooltip = mediaWiki.msg( $( this ).attr( 'id' ) + '-tooltip' );
						if ( $( this ).val() == '' )
							$( this )
								.addClass( 'wikieditor-toolbar-dialog-hint' )
								.val( $( this ).data( 'tooltip' ) )
								.data( 'tooltip-mode', true );
					} )
					.focus( function() {
						if( $( this ).val() == $( this ).data( 'tooltip' ) ) {
							$( this )
								.val( '' )
								.removeClass( 'wikieditor-toolbar-dialog-hint' )
								.data( 'tooltip-mode', false );
						}
					})
					.bind( 'change', function() {
						if ( $( this ).val() != $( this ).data( 'tooltip' ) ) {
							$( this )
								.removeClass( 'wikieditor-toolbar-dialog-hint' )
								.data( 'tooltip-mode', false );
						}
					})
					.bind( 'blur', function() {
						if ( $( this ).val() == '' ) {
							$( this )
								.addClass( 'wikieditor-toolbar-dialog-hint' )
								.val( $( this ).data( 'tooltip' ) )
								.data( 'tooltip-mode', true );
						}
					});

				// Automatically copy the value of the internal link page title field to the link text field unless the
				// user has changed the link text field - this is a convenience thing since most link texts are going to
				// be the the same as the page title - Also change the internal/external radio button accordingly
				$( '#wikieditor-toolbar-link-int-target' ).bind( 'change keydown paste cut', function() {
					// $(this).val() is the old value, before the keypress - Defer this until $(this).val() has
					// been updated
					setTimeout( function() {
						if ( isExternalLink( $( '#wikieditor-toolbar-link-int-target' ).val() ) ) {
							$( '#wikieditor-toolbar-link-type-ext' ).attr( 'checked', 'checked' );
							updateWidget( 'external' );
						} else {
							$( '#wikieditor-toolbar-link-type-int' ).attr( 'checked', 'checked' );
							updateExistence();
						}
						if ( $( '#wikieditor-toolbar-link-int-text' ).data( 'untouched' ) )
							if ( $( '#wikieditor-toolbar-link-int-target' ).val() ==
								$( '#wikieditor-toolbar-link-int-target' ).data( 'tooltip' ) ) {
									$( '#wikieditor-toolbar-link-int-text' )
										.addClass( 'wikieditor-toolbar-dialog-hint' )
										.val( $( '#wikieditor-toolbar-link-int-text' ).data( 'tooltip' ) )
										.change();
								} else {
									$( '#wikieditor-toolbar-link-int-text' )
										.val( $( '#wikieditor-toolbar-link-int-target' ).val() )
										.change();
								}
					}, 0 );
				});
				$( '#wikieditor-toolbar-link-int-text' ).bind( 'change keydown paste cut', function() {
					var oldVal = $(this).val();
					var that = this;
					setTimeout( function() {
						if ( $(that).val() != oldVal )
							$(that).data( 'untouched', false );
					}, 0 );
				});
				// Add images to the page existence widget, which will be shown mutually exclusively to communicate if
				// the page exists, does not exist or the title is invalid (like if it contains a | character)
				var existsMsg = mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-status-exists' );
				var notexistsMsg = mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-status-notexists' );
				var invalidMsg = mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-status-invalid' );
				var externalMsg = mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-status-external' );
				var loadingMsg = mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-status-loading' );
				$( '#wikieditor-toolbar-link-int-target-status' )
					.append( $( '<div />' )
						.attr( 'id', 'wikieditor-toolbar-link-int-target-status-exists' )
						.append( existsMsg )
					)
					.append( $( '<div />' )
						.attr( 'id', 'wikieditor-toolbar-link-int-target-status-notexists' )
						.append( notexistsMsg )
					)
					.append( $( '<div />' )
						.attr( 'id', 'wikieditor-toolbar-link-int-target-status-invalid' )
						.append( invalidMsg )
					)
					.append( $( '<div />' )
						.attr( 'id', 'wikieditor-toolbar-link-int-target-status-external' )
						.append( externalMsg )
					)
					.append( $( '<div />' )
						.attr( 'id', 'wikieditor-toolbar-link-int-target-status-loading' )
						.append( $( '<img />' ).attr( {
							'src': $.wikiEditor.imgPath + 'dialogs/' + 'loading-small.gif',
							'alt': loadingMsg,
							'title': loadingMsg
						} ) )
					)
					.data( 'existencecache', {} )
					.children().hide();

				$( '#wikieditor-toolbar-link-int-target' )
					.bind( 'keyup paste cut', function() {
						// Cancel the running timer if applicable
						if ( typeof $(this).data( 'timerID' ) != 'undefined' ) {
							clearTimeout( $(this).data( 'timerID' ) );
						}
						// Delay fetch for a while
						// FIXME: Make 120 configurable elsewhere
						var timerID = setTimeout( updateExistence, 120 );
						$(this).data( 'timerID', timerID );
					} )
					.change( function() {
						// Cancel the running timer if applicable
						if ( typeof $(this).data( 'timerID' ) != 'undefined' ) {
							clearTimeout( $(this).data( 'timerID' ) );
						}
						// Fetch right now
						updateExistence();
					} );

				// Title suggestions
				$( '#wikieditor-toolbar-link-int-target' ).data( 'suggcache', {} ).suggestions( {
					fetch: function( query ) {
						var that = this;
						var title = $(this).val();

						if ( isExternalLink( title ) || title.indexOf( '|' ) != -1  || title == '') {
							$(this).suggestions( 'suggestions', [] );
							return;
						}

						var cache = $(this).data( 'suggcache' );
						if ( typeof cache[title] != 'undefined' ) {
							$(this).suggestions( 'suggestions', cache[title] );
							return;
						}

						var request = $.ajax( {
							url: mw.util.wikiScript( 'api' ),
							data: {
								'action': 'opensearch',
								'search': title,
								'namespace': 0,
								'suggest': '',
								'format': 'json'
							},
							dataType: 'json',
							success: function( data ) {
								cache[title] = data[1];
								$(that).suggestions( 'suggestions', data[1] );
							}
						});
						$(this).data( 'request', request );
					},
					cancel: function() {
						var request = $(this).data( 'request' );
						if ( request )
							request.abort();
					}
				});
			},
			dialog: {
				width: 500,
				dialogClass: 'wikiEditor-toolbar-dialog',
				buttons: {
					'wikieditor-toolbar-tool-link-insert': function() {
						function escapeInternalText( s ) {
							// FIXME: Should this escape [[ too? Seems to work without that
							return s.replace( /(]{2,})/g, '<nowiki>$1</nowiki>' );
						}
						function escapeExternalTarget( s ) {
							return s.replace( / /g, '%20' )
								.replace( /\[/g, '%5B' )
								.replace( /]/g, '%5D' );
						}
						function escapeExternalText( s ) {
							// FIXME: Should this escape [ too? Seems to work without that
							return s.replace( /(]+)/g, '<nowiki>$1</nowiki>' );
						}
						var insertText = '';
						var whitespace = $( '#wikieditor-toolbar-link-dialog' ).data( 'whitespace' );
						var target = $( '#wikieditor-toolbar-link-int-target' ).val();
						var text = $( '#wikieditor-toolbar-link-int-text' ).val();
						// check if the tooltips were passed as target or text
						if ( $( '#wikieditor-toolbar-link-int-target' ).data( 'tooltip-mode' ) )
							target = "";
						if ( $( '#wikieditor-toolbar-link-int-text' ).data( 'tooltip-mode' ) )
							text = "";
						if ( target == '' ) {
							alert( mediaWiki.msg( 'wikieditor-toolbar-tool-link-empty' ) );
							return;
						}
						if ( $.trim( text ) == '' ) {
							// [[Foo| ]] creates an invisible link
							// Instead, generate [[Foo|]]
							text = '';
						}
						if ( $( '#wikieditor-toolbar-link-type-int' ).is( ':checked' ) ) {
							// FIXME: Exactly how fragile is this?
							if ( $( '#wikieditor-toolbar-link-int-target-status-invalid' ).is( ':visible' ) ) {
								// Refuse to add links to invalid titles
								alert( mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-invalid' ) );
								return;
							}

							if ( target == text || !text.length )
								insertText = '[[' + target + ']]';
							else
								insertText = '[[' + target + '|' + escapeInternalText( text ) + ']]';
						} else {
							// Prepend http:// if there is no protocol
							if ( !target.match( /^[a-z]+:\/\/./ ) )
								target = 'http://' + target;

							// Detect if this is really an internal link in disguise
							var match = target.match( $(this).data( 'articlePathRegex' ) );
							if ( match && !$(this).data( 'ignoreLooksInternal' ) ) {
								var buttons = { };
								var that = this;
								buttons[ mediaWiki.msg( 'wikieditor-toolbar-tool-link-lookslikeinternal-int' ) ] =
									function() {
										$( '#wikieditor-toolbar-link-int-target' ).val( match[1] ).change();
										$(this).dialog( 'close' );
									};
								buttons[ mediaWiki.msg( 'wikieditor-toolbar-tool-link-lookslikeinternal-ext' ) ] =
									function() {
										$(that).data( 'ignoreLooksInternal', true );
										$(that).closest( '.ui-dialog' ).find( 'button:first' ).click();
										$(that).data( 'ignoreLooksInternal', false );
										$(this).dialog( 'close' );
									};
								$.wikiEditor.modules.dialogs.quickDialog(
									mediaWiki.msg( 'wikieditor-toolbar-tool-link-lookslikeinternal', match[1] ),
									{ buttons: buttons }
								);
								return;
							}

							var escTarget = escapeExternalTarget( target );
							var escText = escapeExternalText( text );

							if ( escTarget == escText )
								insertText = escTarget;
							else if ( text == '' )
								insertText = '[' + escTarget + ']';
							else
								insertText = '[' + escTarget + ' ' + escText + ']';
						}
						// Preserve whitespace in selection when replacing
						if ( whitespace ) insertText = whitespace[0] + insertText + whitespace[1];
						$(this).dialog( 'close' );
						$.wikiEditor.modules.toolbar.fn.doAction( $(this).data( 'context' ), {
							type: 'replace',
							options: {
								pre: insertText
							}
						}, $(this) );

						// Blank form
						$( '#wikieditor-toolbar-link-int-target, #wikieditor-toolbar-link-int-text' ).val( '' );
						$( '#wikieditor-toolbar-link-type-int, #wikieditor-toolbar-link-type-ext' )
							.attr( 'checked', '' );
					},
					'wikieditor-toolbar-tool-link-cancel': function() {
						// Clear any saved selection state
						var context = $(this).data( 'context' );
						context.fn.restoreCursorAndScrollTop();
						$(this).dialog( 'close' );
					}
				},
				open: function() {
					// Obtain the server name without the protocol. wgServer may be protocol-relative
					var serverName = mw.config.get( 'wgServer' ).replace( /^(https?:)?\/\//, '' );
					// Cache the articlepath regex
					$(this).data( 'articlePathRegex', new RegExp(
						'^https?://' + $.escapeRE( serverName + mw.config.get( 'wgArticlePath' ) )
							.replace( /\\\$1/g, '(.*)' ) + '$'
					) );
					// Pre-fill the text fields based on the current selection
					var context = $(this).data( 'context' );
					// Restore and immediately save selection state, needed for inserting stuff later
					context.fn.restoreCursorAndScrollTop();
					context.fn.saveCursorAndScrollTop();
					var selection = context.$textarea.textSelection( 'getSelection' );
					$( '#wikieditor-toolbar-link-int-target' ).focus();
					// Trigger the change event, so the link status indicator is up to date
					$( '#wikieditor-toolbar-link-int-target' ).change();
					$( '#wikieditor-toolbar-link-dialog' ).data( 'whitespace', [ '', '' ] );
					if ( selection != '' ) {
						var target, text, type;
						var matches;
						if ( ( matches = selection.match( /^(\s*)\[\[([^\]\|]+)(\|([^\]\|]*))?\]\](\s*)$/ ) ) ) {
							// [[foo|bar]] or [[foo]]
							target = matches[2];
							text = ( matches[4] ? matches[4] : matches[2] );
							type = 'int';
							// Preserve whitespace when replacing
							$( '#wikieditor-toolbar-link-dialog' ).data( 'whitespace', [ matches[1], matches[5] ] );
						} else if ( ( matches = selection.match( /^(\s*)\[([^\] ]+)( ([^\]]+))?\](\s*)$/ ) ) ) {
							// [http://www.example.com foo] or [http://www.example.com]
							target = matches[2];
							text = ( matches[4] ? matches[4] : '' );
							type = 'ext';
							// Preserve whitespace when replacing
							$( '#wikieditor-toolbar-link-dialog' ).data( 'whitespace', [ matches[1], matches[5] ] );
						} else {
							// Trim any leading and trailing whitespace from the selection,
							// but preserve it when replacing
							target = text = $.trim( selection );
							if ( target.length < selection.length ) {
								$( '#wikieditor-toolbar-link-dialog' ).data( 'whitespace', [
									selection.substr( 0, selection.indexOf( target.charAt( 0 ) ) ),
									selection.substr(
										selection.lastIndexOf( target.charAt( target.length - 1 ) ) + 1
									) ]
								);
							}
						}

						// Change the value by calling val() doesn't trigger the change event, so let's do that
						// ourselves
						if ( typeof text != 'undefined' )
							$( '#wikieditor-toolbar-link-int-text' ).val( text ).change();
						if ( typeof target != 'undefined' )
							$( '#wikieditor-toolbar-link-int-target' ).val( target ).change();
						if ( typeof type != 'undefined' )
							$( '#wikieditor-toolbar-link-' + type ).attr( 'checked', 'checked' );
					}
					$( '#wikieditor-toolbar-link-int-text' ).data( 'untouched',
						$( '#wikieditor-toolbar-link-int-text' ).val() ==
								$( '#wikieditor-toolbar-link-int-target' ).val() ||
							$( '#wikieditor-toolbar-link-int-text' ).hasClass( 'wikieditor-toolbar-dialog-hint' )
					);
					$( '#wikieditor-toolbar-link-int-target' ).suggestions();

					//don't overwrite user's text
					if( selection != '' ){
						$( '#wikieditor-toolbar-link-int-text' ).data( 'untouched', false );
					}

					$( '#wikieditor-toolbar-link-int-text, #wikiedit-toolbar-link-int-target' )
						.each( function() {
							if ( $(this).val() == '' )
								$(this).parent().find( 'label' ).show();
						});

					if ( !( $(this).data( 'dialogkeypressset' ) ) ) {
						$(this).data( 'dialogkeypressset', true );
						// Execute the action associated with the first button
						// when the user presses Enter
						$(this).closest( '.ui-dialog' ).keypress( function( e ) {
							if ( ( e.keyCode || e.which ) == 13 ) {
								var button = $(this).data( 'dialogaction' ) || $(this).find( 'button:first' );
								button.click();
								e.preventDefault();
							}
						});

						// Make tabbing to a button and pressing
						// Enter do what people expect
						$(this).closest( '.ui-dialog' ).find( 'button' ).focus( function() {
							$(this).closest( '.ui-dialog' ).data( 'dialogaction', this );
						});
					}
				}
			}
		},
		'insert-reference': {
			titleMsg: 'wikieditor-toolbar-tool-reference-title',
			id: 'wikieditor-toolbar-reference-dialog',
			html: '\
			<div class="wikieditor-toolbar-dialog-wrapper">\
			<fieldset><div class="wikieditor-toolbar-table-form">\
				<div class="wikieditor-toolbar-field-wrapper">\
					<label for="wikieditor-toolbar-reference-text"\
						rel="wikieditor-toolbar-tool-reference-text"></label>\
					<input type="text" id="wikieditor-toolbar-reference-text" />\
				</div>\
			</div></fieldset>\
			</div>',
			init: function() {
				// Insert translated strings into labels
				$( this ).find( '[rel]' ).each( function() {
					$( this ).text( mediaWiki.msg( $( this ).attr( 'rel' ) ) );
				} );

			},
			dialog: {
				dialogClass: 'wikiEditor-toolbar-dialog',
				width: 590,
				buttons: {
					'wikieditor-toolbar-tool-reference-insert': function() {
						var insertText = $( '#wikieditor-toolbar-reference-text' ).val();
						var whitespace = $( '#wikieditor-toolbar-reference-dialog' ).data( 'whitespace' );
						var attributes = $( '#wikieditor-toolbar-reference-dialog' ).data( 'attributes' );
						// Close the dialog
						$( this ).dialog( 'close' );
						$.wikiEditor.modules.toolbar.fn.doAction(
							$( this ).data( 'context' ),
							{
								type: 'replace',
								options: {
									pre: whitespace[0] + '<ref' + attributes + '>',
									peri: insertText,
									post: '</ref>' + whitespace[1]
								}
							},
							$( this )
						);
						// Restore form state
						$( '#wikieditor-toolbar-reference-text' ).val( "" );
					},
					'wikieditor-toolbar-tool-reference-cancel': function() {
						// Clear any saved selection state
						var context = $( this ).data( 'context' );
						context.fn.restoreCursorAndScrollTop();
						$( this ).dialog( 'close' );
					}
				},
				open: function() {
					// Pre-fill the text fields based on the current selection
					var context = $(this).data( 'context' );
					// Restore and immediately save selection state, needed for inserting stuff later
					context.fn.restoreCursorAndScrollTop();
					context.fn.saveCursorAndScrollTop();
					var selection = context.$textarea.textSelection( 'getSelection' );
					// set focus
					$( '#wikieditor-toolbar-reference-text' ).focus();
					$( '#wikieditor-toolbar-reference-dialog' )
						.data( 'whitespace', [ '', '' ] )
						.data( 'attributes', '' );
					if ( selection != '' ) {
						var matches, text;
						if ( ( matches = selection.match( /^(\s*)<ref([^\>]*)>([^\<]*)<\/ref\>(\s*)$/ ) ) ) {
							text = matches[3];
							// Preserve whitespace when replacing
							$( '#wikieditor-toolbar-reference-dialog' )
								.data( 'whitespace', [ matches[1], matches[4] ] );
							$( '#wikieditor-toolbar-reference-dialog' ).data( 'attributes', matches[2] );
						} else {
							text = selection;
						}
						$( '#wikieditor-toolbar-reference-text' ).val( text );
					}
					if ( !( $( this ).data( 'dialogkeypressset' ) ) ) {
						$( this ).data( 'dialogkeypressset', true );
						// Execute the action associated with the first button
						// when the user presses Enter
						$( this ).closest( '.ui-dialog' ).keypress( function( e ) {
							if ( ( e.keyCode || e.which ) == 13 ) {
								var button = $( this ).data( 'dialogaction' ) || $( this ).find( 'button:first' );
								button.click();
								e.preventDefault();
							}
						} );
						// Make tabbing to a button and pressing
						// Enter do what people expect
						$( this ).closest( '.ui-dialog' ).find( 'button' ).focus( function() {
							$( this ).closest( '.ui-dialog' ).data( 'dialogaction', this );
						} );
					}
				}
			}
		},
		'insert-table': {
			titleMsg: 'wikieditor-toolbar-tool-table-title',
			id: 'wikieditor-toolbar-table-dialog',
			// FIXME: Localize 'x'?
			html: '\
				<div class="wikieditor-toolbar-dialog-wrapper">\
				<fieldset><div class="wikieditor-toolbar-table-form">\
					<div class="wikieditor-toolbar-field-wrapper">\
						<input type="checkbox" id="wikieditor-toolbar-table-dimensions-header" checked />\
						<label for="wikieditor-toolbar-table-dimensions-header"\
							rel="wikieditor-toolbar-tool-table-dimensions-header"></label>\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<input type="checkbox" id="wikieditor-toolbar-table-wikitable" checked />\
						<label for="wikieditor-toolbar-table-wikitable" rel="wikieditor-toolbar-tool-table-wikitable"></label>\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<input type="checkbox" id="wikieditor-toolbar-table-sortable" />\
						<label for="wikieditor-toolbar-table-sortable" rel="wikieditor-toolbar-tool-table-sortable"></label>\
					</div>\
					<div class="wikieditor-toolbar-table-dimension-fields">\
						<div class="wikieditor-toolbar-field-wrapper">\
							<label for="wikieditor-toolbar-table-dimensions-rows"\
								rel="wikieditor-toolbar-tool-table-dimensions-rows"></label><br />\
							<input type="text" id="wikieditor-toolbar-table-dimensions-rows" size="4" />\
						</div>\
						<div class="wikieditor-toolbar-field-wrapper">\
							<label for="wikieditor-toolbar-table-dimensions-columns"\
								rel="wikieditor-toolbar-tool-table-dimensions-columns"></label><br />\
							<input type="text" id="wikieditor-toolbar-table-dimensions-columns" size="4" />\
						</div>\
					</div>\
				</div></fieldset>\
				<div class="wikieditor-toolbar-table-preview-wrapper" >\
					<span rel="wikieditor-toolbar-tool-table-example"></span>\
					<div class="wikieditor-toolbar-table-preview-content">\
						<table id="wikieditor-toolbar-table-preview" class="wikieditor-toolbar-table-preview wikitable">\
						<thead>\
							<tr class="wikieditor-toolbar-table-preview-header">\
								<th rel="wikieditor-toolbar-tool-table-example-header"></th>\
								<th rel="wikieditor-toolbar-tool-table-example-header"></th>\
								<th rel="wikieditor-toolbar-tool-table-example-header"></th>\
							</tr>\
						</thead><tbody>\
							<tr class="wikieditor-toolbar-table-preview-hidden" style="display: none;">\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
							</tr><tr>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
							</tr><tr>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
							</tr><tr>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
							</tr>\
						</tbody>\
						</table>\
					</div>\
				</div></div>',
			init: function() {
				$(this).find( '[rel]' ).each( function() {
					$(this).text( mediaWiki.msg( $(this).attr( 'rel' ) ) );
				});
				// Set tabindexes on form fields
				$.wikiEditor.modules.dialogs.fn.setTabindexes( $(this).find( 'input' ).not( '[tabindex]' ) );

				$( '#wikieditor-toolbar-table-dimensions-rows' ).val( 3 );
				$( '#wikieditor-toolbar-table-dimensions-columns' ).val( 3 );
				$( '#wikieditor-toolbar-table-wikitable' ).click( function() {
					$( '.wikieditor-toolbar-table-preview' ).toggleClass( 'wikitable' );
				});

				// Hack for sortable preview: dynamically adding
				// sortable class doesn't work, so we use a clone
				$( '#wikieditor-toolbar-table-preview' )
					.clone()
					.attr( 'id', 'wikieditor-toolbar-table-preview2' )
					.addClass( 'sortable' )
					.insertAfter( $( '#wikieditor-toolbar-table-preview' ) )
					.hide();

				mw.loader.using( 'jquery.tablesorter', function() {
		                       	$( '#wikieditor-toolbar-table-preview2' ).tablesorter();
				});

				$( '#wikieditor-toolbar-table-sortable' ).click( function() {
					// Swap the currently shown one clone with the other one
					$( '#wikieditor-toolbar-table-preview' )
						.hide()
						.attr( 'id', 'wikieditor-toolbar-table-preview3' );
					$( '#wikieditor-toolbar-table-preview2' )
						.attr( 'id', 'wikieditor-toolbar-table-preview' )
						.show();
					$( '#wikieditor-toolbar-table-preview3' ).attr( 'id', 'wikieditor-toolbar-table-preview2' );
				});

				$( '#wikieditor-toolbar-table-dimensions-header' ).click( function() {
					// Instead of show/hiding, switch the HTML around
					// We do this because the sortable tables script styles the first row,
					// visible or not
					var headerHTML = $( '.wikieditor-toolbar-table-preview-header' ).html();
					var hiddenHTML = $( '.wikieditor-toolbar-table-preview-hidden' ).html();
					$( '.wikieditor-toolbar-table-preview-header' ).html( hiddenHTML );
					$( '.wikieditor-toolbar-table-preview-hidden' ).html( headerHTML );
					if ( typeof jQuery.fn.tablesorter == 'function' ) {
							$( '#wikieditor-toolbar-table-preview, #wikieditor-toolbar-table-preview2' )
								.filter( '.sortable' )
								.tablesorter();
					}
				});
			},
			dialog: {
				resizable: false,
				dialogClass: 'wikiEditor-toolbar-dialog',
				width: 590,
				buttons: {
					'wikieditor-toolbar-tool-table-insert': function() {
						var rowsVal = $( '#wikieditor-toolbar-table-dimensions-rows' ).val();
						var colsVal = $( '#wikieditor-toolbar-table-dimensions-columns' ).val();
						var rows = parseInt( rowsVal, 10 );
						var cols = parseInt( colsVal, 10 );
						var header = $( '#wikieditor-toolbar-table-dimensions-header' ).is( ':checked' ) ? 1 : 0;
						if ( isNaN( rows ) || isNaN( cols ) || rows != rowsVal  || cols != colsVal ) {
							alert( mediaWiki.msg( 'wikieditor-toolbar-tool-table-invalidnumber' ) );
							return;
						}
						if ( rows + header == 0 || cols == 0 ) {
							alert( mediaWiki.msg( 'wikieditor-toolbar-tool-table-zero' ) );
							return;
						}
						if ( rows * cols > 1000 ) {
							alert( mediaWiki.msg( 'wikieditor-toolbar-tool-table-toomany', 1000 ) );
							return;
						}
						var headerText = mediaWiki.msg( 'wikieditor-toolbar-tool-table-example-header' );
						var normalText = mediaWiki.msg( 'wikieditor-toolbar-tool-table-example' );
						var table = "";
						for ( var r = 0; r < rows + header; r++ ) {
							table += "|-\n";
							for ( var c = 0; c < cols; c++ ) {
								var isHeader = ( header && r == 0 );
								var delim = isHeader ? '!' : '|';
								if ( c > 0 ) {
									delim += delim;
								}
								table += delim + ' ' + ( isHeader ? headerText : normalText ) + ' ';
							}
							// Replace trailing space by newline
							// table[table.length - 1] is read-only
							table = table.substr( 0, table.length - 1 ) + "\n";
						}
						var classes = [];
						if ( $( '#wikieditor-toolbar-table-wikitable' ).is( ':checked' ) )
							classes.push( 'wikitable' );
						if ( $( '#wikieditor-toolbar-table-sortable' ).is( ':checked' ) )
							classes.push( 'sortable' );
						var classStr = classes.length > 0 ? ' class="' + classes.join( ' ' ) + '"' : '';
						$(this).dialog( 'close' );
						$.wikiEditor.modules.toolbar.fn.doAction(
							$(this).data( 'context' ),
							{
								type: 'replace',
								options: {
									pre: '{|' + classStr + "\n",
									peri: table,
									post: '|}',
									ownline: true
								}
							},
							$(this)
						);

						// Restore form state
							$( '#wikieditor-toolbar-table-dimensions-rows' ).val( 3 );
							$( '#wikieditor-toolbar-table-dimensions-columns' ).val( 3 );
						// Simulate clicks instead of setting values, so the according
						// actions are performed
							if ( !$( '#wikieditor-toolbar-table-dimensions-header' ).is( ':checked' ) )
								$( '#wikieditor-toolbar-table-dimensions-header' ).click();
							if ( !$( '#wikieditor-toolbar-table-wikitable' ).is( ':checked' ) )
								$( '#wikieditor-toolbar-table-wikitable' ).click();
							if ( $( '#wikieditor-toolbar-table-sortable' ).is( ':checked' ) )
								$( '#wikieditor-toolbar-table-sortable' ).click();
					},
					'wikieditor-toolbar-tool-table-cancel': function() {
						$(this).dialog( 'close' );
					}
				},
				open: function() {
					$( '#wikieditor-toolbar-table-dimensions-rows' ).focus();
					if ( !( $(this).data( 'dialogkeypressset' ) ) ) {
						$(this).data( 'dialogkeypressset', true );
						// Execute the action associated with the first button
						// when the user presses Enter
						$(this).closest( '.ui-dialog' ).keypress( function( e ) {
							if ( ( e.keyCode || e.which ) == 13 ) {
								var button = $(this).data( 'dialogaction' ) || $(this).find( 'button:first' );
								button.click();
								e.preventDefault();
							}
						});

						// Make tabbing to a button and pressing
						// Enter do what people expect
						$(this).closest( '.ui-dialog' ).find( 'button' ).focus( function() {
							$(this).closest( '.ui-dialog' ).data( 'dialogaction', this );
						});
					}
				}
			}
		},
		'search-and-replace': {
			'browsers': {
				// Left-to-right languages
				'ltr': {
					'msie': false,
					'firefox': [['>=', 2]],
					'opera': false,
					'safari': [['>=', 3]],
					'chrome': [['>=', 3]]
				},
				// Right-to-left languages
				'rtl': {
					'msie': false,
					'firefox': [['>=', 2]],
					'opera': false,
					'safari': [['>=', 3]],
					'chrome': [['>=', 3]]
				}
			},
			titleMsg: 'wikieditor-toolbar-tool-replace-title',
			id: 'wikieditor-toolbar-replace-dialog',
			html: '\
				<div id="wikieditor-toolbar-replace-message">\
					<div id="wikieditor-toolbar-replace-nomatch" rel="wikieditor-toolbar-tool-replace-nomatch"></div>\
					<div id="wikieditor-toolbar-replace-success"></div>\
					<div id="wikieditor-toolbar-replace-emptysearch" rel="wikieditor-toolbar-tool-replace-emptysearch"></div>\
					<div id="wikieditor-toolbar-replace-invalidregex"></div>\
				</div>\
				<fieldset>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<label for="wikieditor-toolbar-replace-search" rel="wikieditor-toolbar-tool-replace-search"></label>\
						<input type="text" id="wikieditor-toolbar-replace-search" style="width: 100%;" />\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<label for="wikieditor-toolbar-replace-replace" rel="wikieditor-toolbar-tool-replace-replace"></label>\
						<input type="text" id="wikieditor-toolbar-replace-replace" style="width: 100%;" />\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<input type="checkbox" id="wikieditor-toolbar-replace-case" />\
						<label for="wikieditor-toolbar-replace-case" rel="wikieditor-toolbar-tool-replace-case"></label>\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<input type="checkbox" id="wikieditor-toolbar-replace-regex" />\
						<label for="wikieditor-toolbar-replace-regex" rel="wikieditor-toolbar-tool-replace-regex"></label>\
					</div>\
				</fieldset>',
			init: function() {
				$(this).find( '[rel]' ).each( function() {
					$(this).text( mediaWiki.msg( $(this).attr( 'rel' ) ) );
				});
				// Set tabindexes on form fields
				$.wikiEditor.modules.dialogs.fn.setTabindexes( $(this).find( 'input' ).not( '[tabindex]' ) );

				// TODO: Find a cleaner way to share this function
				$(this).data( 'replaceCallback', function( mode ) {
					$( '#wikieditor-toolbar-replace-nomatch, #wikieditor-toolbar-replace-success, #wikieditor-toolbar-replace-emptysearch, #wikieditor-toolbar-replace-invalidregex' ).hide();

					// Search string cannot be empty
					var searchStr = $( '#wikieditor-toolbar-replace-search' ).val();
					if ( searchStr == '' ) {
						$( '#wikieditor-toolbar-replace-emptysearch' ).show();
						return;
					}

					// Replace string can be empty
					var replaceStr = $( '#wikieditor-toolbar-replace-replace' ).val();

					// Prepare the regular expression flags
					var flags = 'm';
					var matchCase = $( '#wikieditor-toolbar-replace-case' ).is( ':checked' );
					if ( !matchCase ) {
						flags += 'i';
					}
					var isRegex = $( '#wikieditor-toolbar-replace-regex' ).is( ':checked' );
					if ( !isRegex ) {
						searchStr = $.escapeRE( searchStr );
					}
					if ( mode == 'replaceAll' ) {
						flags += 'g';
					}

					try {
						var regex = new RegExp( searchStr, flags );
					} catch( e ) {
						$( '#wikieditor-toolbar-replace-invalidregex' )
							.text( mediaWiki.msg( 'wikieditor-toolbar-tool-replace-invalidregex',
								e.message ) )
							.show();
						return;
					}

					var $textarea = $(this).data( 'context' ).$textarea;
					var text = $textarea.textSelection( 'getContents' );
					var match = false;
					var offset, textRemainder;
					if ( mode != 'replaceAll' ) {
						if (mode == 'replace') {
							offset = $(this).data( 'matchIndex' );
						} else {
							offset = $(this).data( 'offset' );
						}
						textRemainder = text.substr( offset );
						match = textRemainder.match( regex );
					}
					if ( !match ) {
						// Search hit BOTTOM, continuing at TOP
						// TODO: Add a "Wrap around" option.
						offset = 0;
						textRemainder = text;
						match = textRemainder.match( regex );
					}

					if ( !match ) {
						$( '#wikieditor-toolbar-replace-nomatch' ).show();
					} else if ( mode == 'replaceAll' ) {
						// Instead of using repetitive .match() calls, we use one .match() call with /g
						// and indexOf() followed by substr() to find the offsets. This is actually
						// faster because our indexOf+substr loop is faster than a match loop, and the
						// /g match is so ridiculously fast that it's negligible.
						// FIXME: Repetitively calling encapsulateSelection() is probably the best strategy
						// in Firefox/Webkit, but in IE replacing the entire content once is better.
						var index;
						for ( var i = 0; i < match.length; i++ ) {
							index = textRemainder.indexOf( match[i] );
							if ( index == -1 ) {
								// This shouldn't happen
								break;
							}
							var matchedText = textRemainder.substr( index, match[i].length );
							textRemainder = textRemainder.substr( index + match[i].length );

							var start = index + offset;
							var end = start + match[i].length;
							// Make regex placeholder substitution ($1) work
							var replace = isRegex ? matchedText.replace( regex, replaceStr ) : replaceStr;
							var newEnd = start + replace.length;
							$textarea
								.textSelection( 'setSelection', { 'start': start, 'end': end } )
								.textSelection( 'encapsulateSelection', {
										'peri': replace,
										'replace': true } )
								.textSelection( 'setSelection', { 'start': start, 'end': newEnd } );
							offset = newEnd;
						}
						$( '#wikieditor-toolbar-replace-success' )
							.text( mediaWiki.msg( 'wikieditor-toolbar-tool-replace-success', match.length ) )
							.show();
						$(this).data( 'offset', 0 );
					} else {
						var start, end;

						if ( mode == 'replace' ) {
							var actualReplacement;

							if (isRegex) {
								// If backreferences (like $1) are used, the actual actual replacement string will be different
								actualReplacement = match[0].replace( regex, replaceStr );
							} else {
								actualReplacement = replaceStr;
							}

							if (match) {
								// Do the replacement
								$textarea.textSelection( 'encapsulateSelection', {
										'peri': actualReplacement,
										'replace': true } );
								// Reload the text after replacement
								text = $textarea.textSelection( 'getContents' );
							}

							// Find the next instance
							offset = offset + match[0].length + actualReplacement.length;
							textRemainder = text.substr( offset );
							match = textRemainder.match( regex );

							if (match) {
								start = offset + match.index;
								end = start + match[0].length;
							} else {
								// If no new string was found, try searching from the beginning.
								// TODO: Add a "Wrap around" option.
								textRemainder = text;
								match = textRemainder.match( regex );
								if (match) {
									start = match.index;
									end = start + match[0].length;
								} else {
									// Give up
									start = 0;
									end = 0;
								}
							}
						} else {
							start = offset + match.index;
							end = start + match[0].length;
						}

						$( this ).data( 'matchIndex', start);

						$textarea.textSelection( 'setSelection', {
								'start': start,
								'end': end
						} );
						$textarea.textSelection( 'scrollToCaretPosition' );
						$( this ).data( 'offset', end );
						var context = $( this ).data( 'context' );
						var textbox = typeof context.$iframe != 'undefined' ?
								context.$iframe[0].contentWindow : $textarea[0];
						textbox.focus();
					}
				});
			},
			dialog: {
				width: 500,
				dialogClass: 'wikiEditor-toolbar-dialog',
				buttons: {
					'wikieditor-toolbar-tool-replace-button-findnext': function( e ) {
						$(this).closest( '.ui-dialog' ).data( 'dialogaction', e.target );
						$(this).data( 'replaceCallback' ).call( this, 'find' );
					},
					'wikieditor-toolbar-tool-replace-button-replace': function( e ) {
						$(this).closest( '.ui-dialog' ).data( 'dialogaction', e.target );
						$(this).data( 'replaceCallback' ).call( this, 'replace' );
					},
					'wikieditor-toolbar-tool-replace-button-replaceall': function( e ) {
						$(this).closest( '.ui-dialog' ).data( 'dialogaction', e.target );
						$(this).data( 'replaceCallback' ).call( this, 'replaceAll' );
					},
					'wikieditor-toolbar-tool-replace-close': function() {
						$(this).dialog( 'close' );
					}
				},
				open: function() {
					$(this).data( 'offset', 0 );
					$(this).data( 'matchIndex', 0 );

					$( '#wikieditor-toolbar-replace-search' ).focus();
					$( '#wikieditor-toolbar-replace-nomatch, #wikieditor-toolbar-replace-success, #wikieditor-toolbar-replace-emptysearch, #wikieditor-toolbar-replace-invalidregex' ).hide();
					if ( !( $(this).data( 'onetimeonlystuff' ) ) ) {
						$(this).data( 'onetimeonlystuff', true );
						// Execute the action associated with the first button
						// when the user presses Enter
						$(this).closest( '.ui-dialog' ).keypress( function( e ) {
							if ( ( e.keyCode || e.which ) == 13 ) {
								var button = $(this).data( 'dialogaction' ) || $(this).find( 'button:first' );
								button.click();
								e.preventDefault();
							}
						});
						// Make tabbing to a button and pressing
						// Enter do what people expect
						$(this).closest( '.ui-dialog' ).find( 'button' ).focus( function() {
							$(this).closest( '.ui-dialog' ).data( 'dialogaction', this );
						});
					}
					var dialog = $(this).closest( '.ui-dialog' );
					var that = this;
					var context = $(this).data( 'context' );
					var textbox = typeof context.$iframe != 'undefined' ?
						context.$iframe[0].contentWindow.document : context.$textarea;

					$( textbox )
						.bind( 'keypress.srdialog', function( e ) {
							if ( ( e.keyCode || e.which ) == 13 ) {
								// Enter
								var button = dialog.data( 'dialogaction' ) || dialog.find( 'button:first' );
								button.click();
								e.preventDefault();
							} else if ( ( e.keyCode || e.which ) == 27 ) {
								// Escape
								$(that).dialog( 'close' );
							}
						});
				},
				close: function() {
					var context = $(this).data( 'context' );
					var textbox = typeof context.$iframe != 'undefined' ?
						context.$iframe[0].contentWindow.document : context.$textarea;
					$( textbox ).unbind( 'keypress.srdialog' );
					$(this).closest( '.ui-dialog' ).data( 'dialogaction', false );
				}
			}
		}
	} };
}

}; } ) ( jQuery );
