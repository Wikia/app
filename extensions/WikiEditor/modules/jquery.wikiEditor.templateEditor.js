/* TemplateEditor module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.templateEditor = {
/**
 * Name mappings, dirty hack which will be removed once "TemplateInfo" extension is more fully supported
 */
'nameMappings': { //keep these all lowercase to navigate web of redirects
   "infobox skyscraper": "building_name",
   "infobox settlement": "official_name"
},


/**
 * Compatability map
 */
'browsers': {
	// Left-to-right languages
	'ltr': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]]
	},
	// Right-to-left languages
	'rtl': {
		'msie': false,
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]]
	}
},
/**
 * Core Requirements
 */
'req': [ 'iframe' ],
/**
 * Event handlers
 */
evt: {

	mark: function( context, event ) {
		// The markers returned by this function are skipped on realchange, so don't regenerate them in that case
		if ( context.modules.highlight.currentScope == 'realchange' ) {
			return;
		}

		// Get references to the markers and tokens from the current context
		var markers = context.modules.highlight.markers;
		var tokenArray = context.modules.highlight.tokenArray;
		// Collect matching level 0 template call boundaries from the tokenArray
		var level = 0;
		var tokenIndex = 0;
		while ( tokenIndex < tokenArray.length ){
			while ( tokenIndex < tokenArray.length && tokenArray[tokenIndex].label != 'TEMPLATE_BEGIN' ) {
				tokenIndex++;
			}
			//open template
			if ( tokenIndex < tokenArray.length ) {
				var beginIndex = tokenIndex;
				var endIndex = -1; //no match found
				var openTemplates = 1;
				var templatesMatched = false;
				while ( tokenIndex < tokenArray.length - 1 && endIndex == -1 ) {
					tokenIndex++;
					if ( tokenArray[tokenIndex].label == 'TEMPLATE_BEGIN' ) {
						openTemplates++;
					} else if ( tokenArray[tokenIndex].label == 'TEMPLATE_END' ) {
						openTemplates--;
						if ( openTemplates == 0 ) {
							endIndex = tokenIndex;
						} //we can stop looping
					}
				}//while finding template ending
				if ( endIndex != -1 ) {
					markers.push( {
						start: tokenArray[beginIndex].offset,
						end: tokenArray[endIndex].offset,
						type: 'template',
						anchor: 'wrap',
						afterWrap: function( node ) {
							// Generate model
							var model = $.wikiEditor.modules.templateEditor.fn.updateModel( $( node ) );
							if ( model.isCollapsible() ) {
								$.wikiEditor.modules.templateEditor.fn.wrapTemplate( $( node ) );
								$.wikiEditor.modules.templateEditor.fn.bindTemplateEvents( $( node ) );
							} else {
								$( node ).addClass( 'wikiEditor-template-text' );
							}
						},
						beforeUnwrap: function( node ) {
							if ( $( node ).parent().hasClass( 'wikiEditor-template' ) ) {
								$.wikiEditor.modules.templateEditor.fn.unwrapTemplate( $( node ) );
							}
						},
						onSkip: function( node ) {
							if ( $( node ).html() == $( node ).data( 'oldHTML' ) ) {
								// No change
								return;
							}

							// Text changed, regenerate model
							var model = $.wikiEditor.modules.templateEditor.fn.updateModel( $( node ) );

							// Update template name if needed
							if ( $( node ).parent().hasClass( 'wikiEditor-template' ) ) {
								var $label = $( node ).parent().find( '.wikiEditor-template-label' );
								var displayName = $.wikiEditor.modules.templateEditor.fn.getTemplateDisplayName( model );
								if ( $label.text() != displayName ) {
									$label.text( displayName );
								}
							}

							// Wrap or unwrap the template if needed
							if ( $( node ).parent().hasClass( 'wikiEditor-template' ) &&
									!model.isCollapsible() ) {
								$.wikiEditor.modules.templateEditor.fn.unwrapTemplate( $( node ) );
							} else if ( !$( node ).parent().hasClass( 'wikiEditor-template' ) &&
									model.isCollapsible() ) {
								$.wikiEditor.modules.templateEditor.fn.wrapTemplate( $( node ) );
								$.wikiEditor.modules.templateEditor.fn.bindTemplateEvents( $( node ) );
							}
						},
						getAnchor: function( ca1, ca2 ) {
							return $( ca1.parentNode ).is( 'span.wikiEditor-template-text' ) ?
								ca1.parentNode : null;
						},
						context: context,
						skipDivision: 'realchange'
					} );
				} else { //else this was an unmatched opening
					tokenArray[beginIndex].label = 'TEMPLATE_FALSE_BEGIN';
					tokenIndex = beginIndex;
				}
			}//if opentemplates
		}
	}, //mark

	keydown: function( context, event ) {
		// Reset our ignoreKeypress variable if it's set to true
		if ( context.$iframe.data( 'ignoreKeypress' ) ) {
			context.$iframe.data( 'ignoreKeypress', false );
		}
		var $evtElem = event.jQueryNode;
		if ( $evtElem.hasClass( 'wikiEditor-template-label' ) ) {
			// Allow anything if the command or control key are depressed
			if ( event.ctrlKey || event.metaKey ) return true;
			switch ( event.which ) {
				case 13: // Enter
					$evtElem.click();
					event.preventDefault();
					return false;
				case 32: // Space
					$evtElem.parent().siblings( '.wikiEditor-template-expand' ).click();
					event.preventDefault();
					return false;
				case 37:// Left
				case 38:// Up
				case 39:// Right
				case 40: //Down
					return true;
				default:
					// Set the ignroreKeypress variable so we don't allow typing if the key is held
					context.$iframe.data( 'ignoreKeypress', true );
					// Can't type in a template name
					event.preventDefault();
					return false;
			}
		} else if ( $evtElem.hasClass( 'wikiEditor-template-text' ) ) {
			switch ( event.which ) {
				case 13: // Enter
					// Ensure that the user can't break this by holding in the enter key
					context.$iframe.data( 'ignoreKeypress', true );
					// FIXME: May be a more elegant way to do this, but this works too
					context.fn.encapsulateSelection( { 'pre': '\n', 'peri': '', 'post': '' } );
					event.preventDefault();
					return false;
				default: return true;
			}
		}
	},
	keyup: function( context, event ) {
		// Rest our ignoreKeypress variable if it's set to true
		if ( context.$iframe.data( 'ignoreKeypress' ) ) {
			context.$iframe.data( 'ignoreKeypress', false );
		}
		return true;
	},
	keypress: function( context, event ) {
		// If this event is from a keydown event which we want to block, ignore it
		return ( context.$iframe.data( 'ignoreKeypress' ) ? false : true );
	}
},
/**
 * Regular expressions that produce tokens
 */
exp: [
	{ 'regex': /{{/, 'label': "TEMPLATE_BEGIN" },
	{ 'regex': /}}/, 'label': "TEMPLATE_END", 'markAfter': true }
],
/**
 * Configuration
 */
cfg: {
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates template form module within wikieditor
	 * @param context Context object of editor to create module in
	 * @param config Configuration object to create module from
	 */
	create: function( context, config ) {
		// Initialize module within the context
		context.modules.templateEditor = {};
	},
	/**
	 * Turns a simple template wrapper (really just a <span>) into a complex one
	 * @param $wrapper Wrapping <span>
	 */
	wrapTemplate: function( $wrapper ) {
		var model = $wrapper.data( 'model' );
		var context = $wrapper.data( 'marker' ).context;
		var $template = $wrapper
			.wrap( '<span class="wikiEditor-template"></span>' )
			.addClass( 'wikiEditor-template-text wikiEditor-template-text-shrunken' )
			.parent()
			.addClass( 'wikiEditor-template-collapsed' )
			.prepend(
				'<span class="wikiEditor-template-expand wikiEditor-noinclude"></span>' +
				'<span class="wikiEditor-template-name wikiEditor-noinclude">' +
					'<span class="wikiEditor-template-label wikiEditor-noinclude">' +
					$.wikiEditor.modules.templateEditor.fn.getTemplateDisplayName( model ) + '</span>' +
					'<span class="wikiEditor-template-dialog wikiEditor-noinclude"></span>' +
				'</span>'
			);
	},
	/**
	 * Turn a complex template wrapper back into a simple one
	 * @param $wrapper Wrapping <span>
	 */
	unwrapTemplate: function( $wrapper ) {
		$wrapper.parent().replaceWith( $wrapper );
	},
	/**
	 * Bind events to a template
	 * @param $wrapper Original wrapper for the template to bind events to
	 */
	bindTemplateEvents: function( $wrapper ) {
		var $template = $wrapper.parent( '.wikiEditor-template' );

		if ( typeof ( opera ) == "undefined" ) {
			$template.parent().attr('contentEditable', 'false');
		}

		$template.click( function(event) {event.preventDefault(); return false;} );

		$template.find( '.wikiEditor-template-name' )
			.click( function( event ) {
				$.wikiEditor.modules.templateEditor.fn.createDialog( $wrapper );
				event.stopPropagation();
				return false;
				} )
			.mousedown( function( event ) { event.stopPropagation(); return false; } );
		$template.find( '.wikiEditor-template-expand' )
			.click( function( event ) {
				$.wikiEditor.modules.templateEditor.fn.toggleWikiTextEditor( $wrapper );
				event.stopPropagation();
				return false;
				} )
			.mousedown( function( event ) { event.stopPropagation(); return false; } );
	},
	/**
	 * Toggle the visisbilty of the wikitext for a given template
	 * @param $wrapper The origianl wrapper we want expand/collapse
	 */
	 toggleWikiTextEditor: function( $wrapper ) {
		var context = $wrapper.data( 'marker' ).context;
		var $template = $wrapper.parent( '.wikiEditor-template' );
		context.fn.purgeOffsets();
		$template
			.toggleClass( 'wikiEditor-template-expanded' )
			.toggleClass( 'wikiEditor-template-collapsed' ) ;

		var $templateText = $template.find( '.wikiEditor-template-text' );
		$templateText.toggleClass( 'wikiEditor-template-text-shrunken' );
		$templateText.toggleClass( 'wikiEditor-template-text-visible' );
		if( $templateText.hasClass('wikiEditor-template-text-shrunken') ){
			//we just closed the template

			// Update the model if we need to
			if ( $templateText.html() != $templateText.data( 'oldHTML' ) ) {
				var templateModel = $.wikiEditor.modules.templateEditor.fn.updateModel( $templateText );

				//this is the only place the template name can be changed; keep the template name in sync
				var $tLabel = $template.find( '.wikiEditor-template-label' );
				$tLabel.text( $.wikiEditor.modules.templateEditor.fn.getTemplateDisplayName( templateModel ) );
			}

		}
	},
	/**
	 * Create a dialog for editing a given template and open it
	 * @param $wrapper The origianl wrapper for which to create the dialog
	*/
	createDialog: function( $wrapper ) {
		var context = $wrapper.data( 'marker' ).context;
		var $template = $wrapper.parent( '.wikiEditor-template' );
		var dialog = {
			'titleMsg': 'wikieditor-template-editor-dialog-title',
			'id': 'wikiEditor-template-dialog',
			'html': '\
				<fieldset>\
					<div class="wikiEditor-template-dialog-title" />\
					<div class="wikiEditor-template-dialog-fields" />\
				</fieldset>',
			init: function() {
				$(this).find( '[rel]' ).each( function() {
					$(this).text( mediaWiki.msg( $(this).attr( 'rel' ) ) );
				} );
			},
			immediateCreate: true,
			dialog: {
				width: 600,
				height: 400,
				dialogClass: 'wikiEditor-toolbar-dialog',
				buttons: {
					'wikieditor-template-editor-dialog-submit': function() {
						// More user feedback
						var $templateDiv = $( this ).data( 'templateDiv' );
						context.fn.highlightLine( $templateDiv );

						var $templateText = $templateDiv.children( '.wikiEditor-template-text' );
						var templateModel = $templateText.data( 'model' );
						$( this ).find( '.wikiEditor-template-dialog-field-wrapper textarea' ).each( function() {
							// Update the value
							templateModel.setValue( $( this ).data( 'name' ), $( this ).val() );
						});
						//keep text consistent
						$.wikiEditor.modules.templateEditor.fn.updateModel( $templateText, templateModel );

						$( this ).dialog( 'close' );
					},
					'wikieditor-template-editor-dialog-cancel': function() {
						$(this).dialog( 'close' );
					}
				},
				open: function() {
					var $templateDiv = $( this ).data( 'templateDiv' );
					var $templateText = $templateDiv.children( '.wikiEditor-template-text' );
					var templateModel = $templateText.data( 'model' );
					// Update the model if we need to
					if ( $templateText.html() != $templateText.data( 'oldHTML' ) ) {
						templateModel = $.wikiEditor.modules.templateEditor.fn.updateModel( $templateText );
					}

					// Build the table
					// TODO: Be smart and recycle existing table
					var params = templateModel.getAllInitialParams();
					var $fields = $( this ).find( '.wikiEditor-template-dialog-fields' );
					// Do some bookkeeping so we can recycle existing rows
					var $rows = $fields.find( '.wikiEditor-template-dialog-field-wrapper' );
					for ( var paramIndex in params ) {
						var param = params[paramIndex];
						if ( typeof param.name == 'undefined' ) {
							// param is the template name, skip it
							continue;
						}
						var paramText = typeof param == 'string' ?
							param.name.replace( /[\_\-]/g, ' ' ) :
							param.name;
						var paramVal = templateModel.getValue( param.name );
						if ( $rows.length > 0 ) {
							// We have another row to recycle
							var $row = $rows.eq( 0 );
							$row.children( 'label' ).text( paramText );
							$row.children( 'textarea' )
								.data( 'name', param.name )
								.val( paramVal )
								.each( function() {
									$(this).css( 'height', $(this).val().length > 24 ? '4.5em' : '1.5em' );
								} );
							$rows = $rows.not( $row );
						} else {
							// Create a new row
							var $paramRow = $( '<div />' )
								.addClass( 'wikiEditor-template-dialog-field-wrapper' );
							$( '<label />' )
								.text( paramText )
								.appendTo( $paramRow );
							$( '<textarea />' )
								.data( 'name', param.name )
								.val( paramVal )
								.each( function() {
									$(this).css( 'height', $(this).val().length > 24 ? '4.5em' : '1.5em' );
								} )
								.data( 'expanded', false )
								.bind( 'cut paste keypress click change', function( e ) {
									// If this was fired by a tab keypress, let it go
									if ( e.keyCode == '9' ) return true;
									var $this = $( this );
									setTimeout( function() {
										var expanded = $this.data( 'expanded' );
										if ( $this.val().indexOf( '\n' ) != -1 || $this.val().length > 24 ) {
											if ( !expanded ) {
												$this.animate( { 'height': '4.5em' }, 'fast' );
												$this.data( 'expanded', true );
											}
										} else {
											if ( expanded ) {
												$this.animate( { 'height': '1.5em' }, 'fast' );
												$this.data( 'expanded', false );
											}
										}
									}, 0 );
								} )
								.appendTo( $paramRow );
							$paramRow
								.append( '<div style="clear:both"></div>' )
								.appendTo( $fields );
						}
					}

					// Remove any leftover rows
					$rows.remove();
					$fields.find( 'label' ).autoEllipsis();
					// Ensure our close button doesn't recieve the ui-state-focus class
					$( this ).parent( '.ui-dialog' ).find( '.ui-dialog-titlebar-close' )
						.removeClass( 'ui-state-focus' );

					// Set tabindexes on form fields if needed
					// First unset the tabindexes on the buttons and existing form fields
					// so the order doesn't get messed up
					var $needTabindex = $( this ).closest( '.ui-dialog' ).find( 'button, textarea' );
					if ( $needTabindex.not( '[tabindex]' ).length ) {
						// Only do this if there actually are elements missing a tabindex
						$needTabindex.removeAttr( 'tabindex' );
						$.wikiEditor.modules.dialogs.fn.setTabindexes( $needTabindex );
					}
				}
			}
		};
		// Lazy-create the dialog at this time
		context.$textarea.wikiEditor( 'addDialog', { 'templateEditor': dialog } );
		$( '#' + dialog.id )
			.data( 'templateDiv', $template )
			.dialog( 'open' );
	},
	/**
	 * Update a template's model and HTML
	 * @param $templateText Wrapper <span> containing the template text
	 * @param model Template model to use, will be generated if not set
	 * @return model object
	 */
	updateModel: function( $templateText, model ) {
		var context = $templateText.data( 'marker' ).context;
		var text;
		if ( typeof model == 'undefined' ) {
			text = context.fn.htmlToText( $templateText.html() );
		} else {
			text = model.getText();
		}
		// To keep stuff simple but not break it, we need to do encode newlines as <br>s
		$templateText.text( text );
		$templateText.html( $templateText.html().replace( /\n/g, '<br />' ) );
		$templateText.data( 'oldHTML', $templateText.html() );
		if ( typeof model == 'undefined' ) {
			model = new $.wikiEditor.modules.templateEditor.fn.model( text );
			$templateText.data( 'model', model );
		}
		return model;
	},

	/**
	 * Gets template display name
	 */
	getTemplateDisplayName: function ( model ) {
		var tName = model.getName();
		if( model.getValue( 'name' ) != '' ) {
			return tName + ': ' + model.getValue( 'name' );
		} else if( model.getValue( 'Name' ) != '' ) {
			return tName + ': ' + model.getValue( 'Name' );
		} else if( tName.toLowerCase() in $.wikiEditor.modules.templateEditor.nameMappings ) {
			return tName + ': ' + model.getValue( $.wikiEditor.modules.templateEditor.nameMappings[tName.toLowerCase()] );
		}
		return tName;
	},

	/**
	 * Builds a template model from given wikitext representation, allowing object-oriented manipulation of the contents
	 * of the template while preserving whitespace and formatting.
	 *
	 * @param wikitext String of wikitext content
	 */
	model: function( wikitext ) {

		/* Private members */

		var collapsible = true;

		/* Private Functions */

		/**
		 * Builds a Param object.
		 *
		 * @param name
		 * @param value
		 * @param number
		 * @param nameIndex
		 * @param equalsIndex
		 * @param valueIndex
		 */
		function Param( name, value, number, nameIndex, equalsIndex, valueIndex ) {
			this.name = name;
			this.value = value;
			this.number = number;
			this.nameIndex = nameIndex;
			this.equalsIndex = equalsIndex;
			this.valueIndex = valueIndex;
		}
		/**
		 * Builds a Range object.
		 *
		 * @param begin
		 * @param end
		 */
		function Range( begin, end ) {
			this.begin = begin;
			this.end = end;
		}
		/**
		 * Set 'original' to true if you want the original value irrespective of whether the model's been changed
		 *
		 * @param name
		 * @param value
		 * @param original
		 */
		function getSetValue( name, value, original ) {
			var valueRange;
			var rangeIndex;
			var retVal;
			if ( isNaN( name ) ) {
				// It's a string!
				if ( typeof paramsByName[name] == 'undefined' ) {
					// Does not exist
					return "";
				}
				rangeIndex = paramsByName[name];
			} else {
				// It's a number!
				rangeIndex = parseInt( name );
			}
			if ( typeof params[rangeIndex]  == 'undefined' ) {
				// Does not exist
				return "";
			}
			valueRange = ranges[params[rangeIndex].valueIndex];
			if ( typeof valueRange.newVal == 'undefined' || original ) {
				// Value unchanged, return original wikitext
				retVal = wikitext.substring( valueRange.begin, valueRange.end );
			} else {
				// New value exists, return new value
				retVal = valueRange.newVal;
			}
			if ( value != null ) {
				ranges[params[rangeIndex].valueIndex].newVal = value;
			}
			return retVal;
		};

		/* Public Functions */

		/**
		 * Get template name
		 */
		this.getName = function() {
			if( typeof ranges[templateNameIndex].newVal == 'undefined' ) {
				return wikitext.substring( ranges[templateNameIndex].begin, ranges[templateNameIndex].end );
			} else {
				return ranges[templateNameIndex].newVal;
			}
		};
		/**
		 * Set template name (if we want to support this)
		 *
		 * @param name
		 */
		this.setName = function( name ) {
			ranges[templateNameIndex].newVal = name;
		};
		/**
		 * Set value for a given param name / number
		 *
		 * @param name
		 * @param value
		 */
		this.setValue = function( name, value ) {
			return getSetValue( name, value, false );
		};
		/**
		 * Get value for a given param name / number
		 *
		 * @param name
		 */
		this.getValue = function( name ) {
			return getSetValue( name, null, false );
		};
		/**
		 * Get original value of a param
		 *
		 * @param name
		 */
		this.getOriginalValue = function( name ) {
			return getSetValue( name, null, true );
		};
		/**
		 * Get a list of all param names (numbers for the anonymous ones)
		 */
		this.getAllParamNames = function() {
			return paramsByName;
		};
		/**
		 * Get the initial params
		 */
		this.getAllInitialParams = function(){
			return params;
		};
		/**
		 * Get original template text
		 */
		this.getOriginalText = function() {
			return wikitext;
		};
		/**
		 * Get modified template text
		 */
		this.getText = function() {
			newText = "";
			for ( i = 0 ; i < ranges.length; i++ ) {
				if( typeof ranges[i].newVal == 'undefined' ) {
					newText += wikitext.substring( ranges[i].begin, ranges[i].end );
				} else {
					newText += ranges[i].newVal;
				}
			}
			return newText;
		};

		this.isCollapsible = function() {
			return collapsible;
		};

		/**
		 *  Update ranges if there's been a change in one or more 'segments' of the template.
		 *  Removes adjustment function so adjustment is only made once ever.
		 */

		this.updateRanges = function() {
			var adjustment = 0;
			for (var i = 0 ; i < ranges.length; i++ ) {
				ranges[i].begin += adjustment;
				if( typeof ranges[i].adjust != 'undefined' ) {
					adjustment += ranges[i].adjust();
					// NOTE: adjust should be a function that has the information necessary to calculate the length of
					// this 'segment'
					delete ranges[i].adjust;
				}
				ranges[i].end += adjustment;
			}
		};

		// Whitespace* {{ whitespace* nonwhitespace:
		if ( wikitext.match( /\s*{{\s*[^\s|]*:/ ) ) {
			collapsible = false; // is a parser function
		}
		/*
		 * Take all template-specific characters that are not particular to the template we're looking at, namely {|=},
		 * and convert them into something harmless, in this case 'X'
		 */
		// Get rid of first {{ with whitespace
		var sanatizedStr = wikitext.replace( /{{/, "  " );
		// Replace end
		endBraces = sanatizedStr.match( /}}\s*$/ );
		if ( endBraces ) {
			sanatizedStr = sanatizedStr.substring( 0, endBraces.index ) + "  " +
				sanatizedStr.substring( endBraces.index + 2 );
		}


		//treat HTML comments like whitespace
		while ( sanatizedStr.indexOf( '<!' ) != -1 ) {
			startIndex = sanatizedStr.indexOf( '<!' );
			endIndex = sanatizedStr.indexOf('-->') + 3;
			if( endIndex < 3 ){
				break;
			}
			sanatizedSegment = sanatizedStr.substring( startIndex,endIndex ).replace( /\S/g , ' ' );
			sanatizedStr =
				sanatizedStr.substring( 0, startIndex ) + sanatizedSegment + sanatizedStr.substring( endIndex );
		}

		// Match the open braces we just found with equivalent closing braces note, works for any level of braces
		while ( sanatizedStr.indexOf( '{{' ) != -1 ) {
			startIndex = sanatizedStr.indexOf( '{{' ) + 1;
			openBraces = 2;
			endIndex = startIndex;
			while ( (openBraces > 0)  && (endIndex < sanatizedStr.length) ) {
				var brace = sanatizedStr[++endIndex];
				openBraces += brace == '}' ? -1 : brace == '{' ? 1 : 0;
			}
			sanatizedSegment = sanatizedStr.substring( startIndex,endIndex ).replace( /[{}|=]/g , 'X' );
			sanatizedStr =
				sanatizedStr.substring( 0, startIndex ) + sanatizedSegment + sanatizedStr.substring( endIndex );
		}
		//links, images, etc, which also can nest
		while ( sanatizedStr.indexOf( '[[' ) != -1 ) {
			startIndex = sanatizedStr.indexOf( '[[' ) + 1;
			openBraces = 2;
			endIndex = startIndex;
			while ( (openBraces > 0)  && (endIndex < sanatizedStr.length) ) {
				var brace = sanatizedStr[++endIndex];
				openBraces += brace == ']' ? -1 : brace == '[' ? 1 : 0;
			}
			sanatizedSegment = sanatizedStr.substring( startIndex,endIndex ).replace( /[\[\]|=]/g , 'X' );
			sanatizedStr =
				sanatizedStr.substring( 0, startIndex ) + sanatizedSegment + sanatizedStr.substring( endIndex );
		}

		/*
		 * Parse 1 param at a time
		 */
		var ranges = [];
		var params = [];
		var templateNameIndex = 0;
		var doneParsing = false;
		oldDivider = 0;
		divider = sanatizedStr.indexOf( '|', oldDivider );
		if ( divider == -1 ) {
			divider = sanatizedStr.length;
			doneParsing = true;
			collapsible = false; //zero params
		}
		nameMatch = sanatizedStr.substring( 0, divider ).match( /[^\s]/ );
		if ( nameMatch != null ) {
			ranges.push( new Range( 0 ,nameMatch.index ) ); //whitespace and squiggles upto the name
			nameEndMatch = sanatizedStr.substring( 0 , divider ).match( /[^\s]\s*$/ ); //last nonwhitespace character
			templateNameIndex = ranges.push( new Range( nameMatch.index,
				nameEndMatch.index + 1 ) );
			templateNameIndex--; //push returns 1 less than the array
			ranges[templateNameIndex].old = wikitext.substring( ranges[templateNameIndex].begin,
				ranges[templateNameIndex].end );
		} else {
			ranges.push(new Range(0,0));
			ranges[templateNameIndex].old = "";
		}
		params.push( ranges[templateNameIndex].old ); //put something in params (0)
		/*
		 * Start looping over params
		 */
		var currentParamNumber = 0;
		var valueEndIndex = ranges[templateNameIndex].end;
		var paramsByName = [];
		while ( !doneParsing ) {
			currentParamNumber++;
			oldDivider = divider;
			divider = sanatizedStr.indexOf( '|', oldDivider + 1 );
			if ( divider == -1 ) {
				divider = sanatizedStr.length;
				doneParsing = true;
			}
			currentField = sanatizedStr.substring( oldDivider+1, divider );
			if ( currentField.indexOf( '=' ) == -1 ) {
				// anonymous field, gets a number

				//default values, since we'll allow empty values
				valueBeginIndex = oldDivider + 1;
				valueEndIndex = oldDivider + 1;

				valueBegin = currentField.match( /\S+/ ); //first nonwhitespace character
				if( valueBegin != null ){
					valueBeginIndex = valueBegin.index + oldDivider+1;
					valueEnd = currentField.match( /[^\s]\s*$/ ); //last nonwhitespace character
					if( valueEnd == null ){ //ie
						continue;
					}
					valueEndIndex = valueEnd.index + oldDivider + 2;
				}
				ranges.push( new Range( ranges[ranges.length-1].end,
					valueBeginIndex ) ); //all the chars upto now
				nameIndex = ranges.push( new Range( valueBeginIndex, valueBeginIndex ) ) - 1;
				equalsIndex = ranges.push( new Range( valueBeginIndex, valueBeginIndex ) ) - 1;
				valueIndex = ranges.push( new Range( valueBeginIndex, valueEndIndex ) ) - 1;
				params.push( new Param(
					currentParamNumber,
					wikitext.substring( ranges[valueIndex].begin, ranges[valueIndex].end ),
					currentParamNumber,
					nameIndex,
					equalsIndex,
					valueIndex
				) );
				paramsByName[currentParamNumber] = currentParamNumber;
			} else {
				// There's an equals, could be comment or a value pair
				currentName = currentField.substring( 0, currentField.indexOf( '=' ) );
				// Still offset by oldDivider - first nonwhitespace character
				nameBegin = currentName.match( /\S+/ );
				if ( nameBegin == null ) {
					// This is a comment inside a template call / parser abuse. let's not encourage it
					currentParamNumber--;
					continue;
				}
				nameBeginIndex = nameBegin.index + oldDivider + 1;
				// Last nonwhitespace and non } character
				nameEnd = currentName.match( /[^\s]\s*$/ );
				if( nameEnd == null ){ //ie
					continue;
				}
				nameEndIndex = nameEnd.index + oldDivider + 2;
				// All the chars upto now
				ranges.push( new Range( ranges[ranges.length-1].end, nameBeginIndex ) );
				nameIndex = ranges.push( new Range( nameBeginIndex, nameEndIndex ) ) - 1;
				currentValue = currentField.substring( currentField.indexOf( '=' ) + 1);
				oldDivider += currentField.indexOf( '=' ) + 1;

				//default values, since we'll allow empty values
				valueBeginIndex = oldDivider + 1;
				valueEndIndex = oldDivider + 1;

				// First nonwhitespace character
				valueBegin = currentValue.match( /\S+/ );
				if( valueBegin != null ){
					valueBeginIndex = valueBegin.index + oldDivider + 1;
					// Last nonwhitespace and non } character
					valueEnd = currentValue.match( /[^\s]\s*$/ );
					if( valueEnd == null ){ //ie
						continue;
					}
					valueEndIndex = valueEnd.index + oldDivider + 2;
				}
				// All the chars upto now
				equalsIndex = ranges.push( new Range( ranges[ranges.length-1].end, valueBeginIndex) ) - 1;
				valueIndex = ranges.push( new Range( valueBeginIndex, valueEndIndex ) ) - 1;
				params.push( new Param(
					wikitext.substring( nameBeginIndex, nameEndIndex ),
					wikitext.substring( valueBeginIndex, valueEndIndex ),
					currentParamNumber,
					nameIndex,
					equalsIndex,
					valueIndex
				) );
				paramsByName[wikitext.substring( nameBeginIndex, nameEndIndex )] = currentParamNumber;
			}
		}
		// The rest of the string
		ranges.push( new Range( valueEndIndex, wikitext.length ) );

		// Save vars
		this.ranges = ranges;
		this.wikitext = wikitext;
		this.params = params;
		this.paramsByName = paramsByName;
		this.templateNameIndex = templateNameIndex;
	} //model
}
}; } )( jQuery );
