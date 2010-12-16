/* TemplateEditor module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.templateEditor = {
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
		'msie': [['>=', 8]],
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
					// Create a model for the template
					var model = new $.wikiEditor.modules.templateEditor.fn.model(
					        context.fn.getContents().substring( tokenArray[beginIndex].offset,
							tokenArray[endIndex].offset
						)
					);
					markers.push( {
						start: tokenArray[beginIndex].offset,
						end: tokenArray[endIndex].offset,
						type: 'template',
						anchor: 'wrap',
						//splitPs: model.isCollapsible(),
						splitPs: false,
						afterWrap: $.wikiEditor.modules.templateEditor.fn.stylize,
						beforeUnwrap: function( node ) {
							// FIXME: $( node ).data( 'display' ) doesn't exist any more
							//$( node ).data( 'display' ).remove();
						},
						onSkip: function() { }, // TODO update template info
						getAnchor: function( ca1, ca2 ) {
							// FIXME: Relies on the current <span> structure that is likely to die
							return $( ca1.parentNode ).is( 'span.wikiEditor-template-text' ) ?
								ca1.parentNode : null;
						},
						model: model
					} );
				} else { //else this was an unmatched opening
					tokenArray[beginIndex].label = 'TEMPLATE_FALSE_BEGIN';
					tokenIndex = beginIndex;
				}
			}//if opentemplates
		}
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
	stylize: function( wrappedTemplate ) {
		$( wrappedTemplate ).each( function() {
			if ( typeof $(this).data( 'setupDone' ) != 'undefined' ) {
				// We have a model, so all this init stuff has already happened
				return;
			}
			var model = $(this).data( 'marker' ).model;
			
			//check if model is collapsible
			if ( !model.isCollapsible() ) {
				$(this).addClass( 'wikiEditor-template-text' );
				return;
			}
			
			var $template = $( this )
				.wrap( '<span class="wikiEditor-template"></span>' )
				.addClass( 'wikiEditor-template-text wikiEditor-nodisplay' )
				.parent()
				.addClass( 'wikiEditor-template-collapsed' )
				.data( 'model', model );
			
			$( '<span />' )
			.addClass( 'wikiEditor-template-name wikiEditor-noinclude' )
			.text( model.getName() )
			.mousedown(toggleWikiTextEditor)
			//.mousedown( function(){createDialog( $template );} ) //have to pass template so model stays in sync
			.prependTo( $template );
			
			/*
			var $options = $( '<ul />' )
			.addClass( 'wikiEditor-template-modes wikiEditor-noinclude' )
			.append( $( '<li />' )
				.addClass( 'wikiEditor-template-action-wikiText' )
				.append( $( '<img />' ).attr( 'src',
					$.wikiEditor.imgPath + 'templateEditor/' + 'wiki-text.png' ) )
				.mousedown( toggleWikiTextEditor ) )
			.insertAfter( $template.find( '.wikiEditor-template-name' ) );
			*/
			$(this).data( 'setupDone', true );
			
			function toggleWikiTextEditor(){
				var $template = $( this ).closest( '.wikiEditor-template' );
				$template
					.toggleClass( 'wikiEditor-template-expanded' )
					.toggleClass( 'wikiEditor-template-collapsed' );
				var $wikitext = $template.children('.wikiEditor-template-text');
				$wikitext.toggleClass('wikiEditor-nodisplay');
				
				//if we just collapsed this
				if( $template.hasClass('wikiEditor-template-collapsed') ) {
					var model = new $.wikiEditor.modules.templateEditor.fn.model(
						$template.children( '.wikiEditor-template-text' ).text()
					);
					$template.data( 'model' , model );
					$template.children( '.wikiEditor-template-name' ).text( model.getName() );
				}
				else{ //we just expanded this
					$wikitext.text($template.data('model').getText());
				}
				
				return false;
			};
		
			// Expand
			function expandTemplate( $displayDiv ) {
				// Housekeeping
				$displayDiv.removeClass( 'wikiEditor-template-collapsed' );
				$displayDiv.addClass( 'wikiEditor-template-expanded' );
				// remove mousedown hander from the entire thing
				$displayDiv.unbind( 'mousedown' );
				//$displayDiv.text( model.getText() );
				$keyValueTable = $( '<table />' )
					.appendTo( $displayDiv );
				$header_row = $( '<tr />' )
					.appendTo( $keyValueTable );
				$( '<th />' )
					.attr( 'colspan', '2' )
					.text( model.getName() )
					.appendTo( $header_row );
				for( param in model.getAllParamNames() ){
					$keyVal_row = $( '<tr />' )
						.appendTo( $keyValueTable );
					
					$( '<td />' )
						.text( param )
						.appendTo( $keyVal_row );
					$( '<td />' )
						.text( model.getValue( param ) )
						.appendTo( $keyVal_row );
				}
			};
			// Collapse
			function collapseTemplate( $displayDiv ) {
				// Housekeeping
				$displayDiv.addClass( 'wikiEditor-template-collapsed' );
				$displayDiv.removeClass( 'wikiEditor-template-expanded' );
				$displayDiv.text( model.getName() );
			};
			
			
			function createDialog( $templateDiv ){
				var $wikitext = $templateDiv.children('.wikiEditor-template-text');
				//TODO: check if template model has been changed
				var templateModel = new $.wikiEditor.modules.templateEditor.fn.model( $wikitext.text() );
				$templateDiv.data('model', templateModel);
				var $dialog = $("<div></div>");
				var $title =
					$("<div>" + templateModel.getName() + "</div>").addClass('wikiEditor-template-dialog-title');
				var $table = $("<table></table>")
						  .addClass('wikiEditor-template-dialog-table')
						  .appendTo($dialog);
				var allInitialParams = templateModel.getAllInitialParams();
				for( var paramIndex in allInitialParams ){
					var param = allInitialParams[paramIndex];
					if(typeof param.name == 'undefined'){continue;} //param 0 is the name
					var $paramRow = $("<tr></tr>")
							.addClass('wikiEditor-template-dialog-row');
					var $paramName = $("<td></td>")
										.addClass('wikiEditor-template-dialog-name')
										.text( param.name );
					var $paramVal = $("<td></td>")
										.addClass('wikiEditor-template-dialog-value');
					var $paramInput =$("<input></input>")
										.data('name', param.name)
										.val( templateModel.getValue(param.name) );
					$paramVal.append($paramInput);
					$paramRow.append($paramName).append($paramVal);
					$table.append($paramRow);
				}
				//click handler for values
				$("<button></button>").click(function(){
					$('.wikiEditor-template-dialog-value input').each( function(){
						templateModel.setValue( $(this).data('name'), $(this).val() );
					});
					//keep text consistent
					$wikitext.text( templateModel.getText() );
					
					$dialog.dialog('close');
					
				}).text("OK").appendTo($dialog);
				$dialog.dialog(); //opens dialog
				return false;
			};
			
			
			
			
			function toggleWikiText( ) {
				var $template = $( this ).closest( '.wikiEditor-template' );
				$template
					.toggleClass( 'wikiEditor-template-collapsed' )
					.toggleClass( 'wikiEditor-template-expanded' )
					.children( '.wikiEditor-template-text, .wikiEditor-template-name, .wikiEditor-template-modes' )
					.toggleClass( 'wikiEditor-nodisplay' );
				
				//if we just collapsed this
				if( $template.hasClass('wikiEditor-template-collapsed') ) {
					var model = new $.wikiEditor.modules.templateEditor.fn.model(
						$template.children( '.wikiEditor-template-text' ).text()
					);
					$template.data( 'model' , model );
					$template.children( '.wikiEditor-template-name' ).text( model.getName() );
				}
				else{ //else we just expanded this
					$template.children( '.wikiEditor-template-text' ).children('.wikiEditor-template-inner-text').text( 
							$template.data('model')
							.getText()
							.replace(/\{\{/, '')
							.replace(/\}\}$/, '')
					);
					
				}
				return false;
			}
			
		function noEdit() {
			return false;
		}
		
		});
		
	},
	
	
	/**
	 * Gets templateInfo node from templateInfo extension, if it exists
	 */
	getTemplateInfo: function ( templateName ){
		var templateInfo = '';
		//API call here
		return $( templateInfo );
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
		}
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
		}
		
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
		if ( wikitext.match( /\s*{{\s*\S*:/ ) ) {
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
				valueBegin = currentField.match( /\S+/ ); //first nonwhitespace character
				if( valueBegin == null ){ //ie
					continue;
				}
				valueBeginIndex = valueBegin.index + oldDivider+1;
				valueEnd = currentField.match( /[^\s]\s*$/ ); //last nonwhitespace character
				if( valueEnd == null ){ //ie
					continue;
				}
				valueEndIndex = valueEnd.index + oldDivider + 2;
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
				// First nonwhitespace character
				valueBegin = currentValue.match( /\S+/ );
				if( valueBegin == null ){ //ie
					continue;
				}
				valueBeginIndex = valueBegin.index + oldDivider + 1;
				// Last nonwhitespace and non } character
				valueEnd = currentValue.match( /[^\s]\s*$/ );
				if( valueEnd == null ){ //ie
					continue;
				}
				valueEndIndex = valueEnd.index + oldDivider + 2;
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
