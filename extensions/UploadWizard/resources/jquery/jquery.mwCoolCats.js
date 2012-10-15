/** 
 * Simple predictive typing category adder for Mediawiki.
 * Relies on mw.Title, mw.api.category, $.fn.removeCtrl
 * Add to the page and then use getWikiText() to get wiki text representing the categories.
 *
 * N.B. Relies on the DOM to store the widget state.
 * On user action, list items are created, which have Titles as data properties.
 * To get the wikiText, we just select the list items again, get the Titles, convert to text, and return that.
 * This gets a bit complex as there is a hack for hidden categories too, and then another hack for default text
 * when the user hasn't entered any categories (not counting hidden categories!). 
 * This should probably not be going through the DOM, could be more MVC.
 */
( function ( $j ) { $j.fn.mwCoolCats = function( options ) {

	var catNsId = mw.config.get( 'wgNamespaceIds' ).category;

	/**
	 * Get content from our text field, and attempt to insert it as a category.
	 * May require confirmation from user if they appear to be adding a new category.
	 */
	function _processInput() {	
		var $input = $container.find( 'input' );
		var text = _stripText( $input.val() );
		if ( text === '' ) {
			return;
		}

		var title = new mw.Title( text, catNsId );
	
		var insertIt = function() {
			_insertCat( title );
			$input.val("");
		};

		var confirmIt = function() {
			var buttons = [
				{
					text: gM( 'mw-coolcats-confirm-new-cancel' ),
					click: function() {
						$( this ).dialog( "close" ); 
					}
				},
				{ 
					text: gM( 'mw-coolcats-confirm-new-ok' ),
					click: function() { 
						insertIt();
						$( this ).dialog( "close" ); 
					}
				}
			];
			$j( '<div></div>' )
				.msg( 'mw-coolcats-confirm-new', title.getMainText() )
				.dialog( {
					width: 500,
					zIndex: 200000,
					autoOpen: true,
					title: gM( 'mw-coolcats-confirm-new-title' ),
					modal: true,
					buttons: buttons
				} );
		};
		
		if( seenTitleText[ title.getMainText() ] ) {
			insertIt();
		} else {
 			settings.api.isCategory( title, function( isCategory ) {
				if ( isCategory ) {
					insertIt();
				} else {
					confirmIt();
				}
			} );
		}

	}

	/**
	 * Add a new category to the page
	 * @param {mw.Title} title of category -- should already be in category namespace
	 * @param {boolean} whether this category is visible to the user
	 */
	function _insertCat( title, isHidden ) {
		if ( _containsCat( title ) ) {
			return;
		}
		var $li = $j( '<li/>' ).addClass( 'cat' );
		var $anchor = $j( '<a/>' ).addClass( 'cat' ).append( title.getMainText() );
		$li.append( $anchor );
		$li.data( 'title', title );
		if ( isHidden ) {
			$li.hide().addClass( 'hidden' );
			// extra 'hidden' class is necessary to distinguish deliberately hidden categories from those 
			// which are hidden because the whole widget is closed
		} else {
			$anchor.attr( { target: "_blank", href: title.getUrl() } );
			$li.append( $j.fn.removeCtrl( null, 'mwe-upwiz-category-remove', function() { $li.remove(); } ) );
		}
		$container.find( 'ul' ).append( $li );
	}

	/**
	 * Get all the categories on the page as mw.Titles, optionally filtered
	 * @param selector {String} optional extra filter
	 * @return {Array of mw.Title}
	 */
	function _getCats( selector ) {
		if ( typeof selector === 'undefined' ) {
			selector = '*'; // fetch _ALL_ the categories!
		}
		return $container.find( 'ul li.cat' )
				.filter( selector )
				.map( function() { return $j( this ).data( 'title' ); } );
	}

	/**
	 * Check if we already have this category on the page
	 * @param {mw.Title}
	 * @return boolean, true if already on the page
	 */
	function _containsCat( title ) {
		var s = title.toString();
		return _getCats().filter( function() { return this.toString() == s; } ).length !== 0;
	}

	/**
	 * Normalize text
	 * @param {String}
	 * @return string stripped of some characters, trimmed
	 */
	function _stripText( s ) { 
		if ( typeof s !== 'string' ) {
			throw new Error( '_stripText() argument must be a string' );
		}
		return $j.trim( s.replace( /[\x00-\x1f\x3c\x3e\x5b\x5d\x7b\x7c\x7d\x7f]+/g, '' ) );
	}

	/**
	 * Fetch and display suggestions for categories, based on what the user has already typed
	 * into the text field
	 */
	function _fetchSuggestions() {
		var _input = this;
		// ignore bad characters, they will be stripped out
		var prefix = _stripText( $j( this ).val() );

		var ok = function( catList ) {
			$j( _input ).suggestions( 'suggestions', catList );
			$j.each( catList, function( i, category ) {
				seenTitleText[category] = 1;
			} );
		};

 		$j( _input ).data( 'request', settings.api.getCategoriesByPrefix( prefix, ok ) );
	}

	var defaults = {
		buttontext: 'Add',
		hiddenCats: [],
		missingCatsWikiText: null,
		cats: []
	};

	var settings = $j.extend( {}, defaults, options );
	if ( !settings.api ) { 
		throw new Error( "jQuery.mwCoolCats needs an 'api' argument" );
	}

	// a cache of suggestions we've seen, to check if the category they finally enter is already on the wiki or not.
	var seenTitleText = {};

	var $container;

	/**
	 * Initialize the text field(s) the widget was given to be category pickers.
	 */
	return this.each( function() {
		var _this = $j( this );
		
		_this.addClass( 'categoryInput' );

		_this.suggestions( {
			'fetch': _fetchSuggestions,
			'cancel': function() {
				var req = $j( this ).data( 'request' );
				// XMLHttpRequest.abort is unimplemented in IE6, also returns nonstandard value of "unknown" for typeof
				if ( req && ( typeof req.abort !== 'unknown' ) && ( typeof req.abort !== 'undefined' ) && req.abort ) {
					req.abort();
				}
			}
		} );
		_this.suggestions();

		_this.wrap('<div class="cat-widget"></div>');
		$container = _this.parent(); // set to the cat-widget class we just wrapped
		$container.prepend('<ul class="cat-list pkg"></ul>');
		$container.append( $j( '<button type="button" name="catbutton">'+settings.buttontext+'</button>' )
			.button()
			.click( function(e) {
				e.stopPropagation(); 
				e.preventDefault(); 
				_processInput();
				return false;
			})
		);

		//XXX ensure this isn't blocking other stuff needed.
		_this.parents('form').submit( function() {
			_processInput();
		});
		
		_this.keyup(function(e) { 
			if(e.keyCode == 13) { 
				e.stopPropagation(); 
				e.preventDefault(); 
				_processInput();
			} 
		});

		this.getWikiText = function() {
			var wikiText = _getCats().map( function() { return '[[' + this.getPrefixedText() + ']]'; } )
							.toArray()
							.join( "\n" );

			// if so configured, and there are no user-visible categories, add warning
			if ( settings.missingCatsWikiText !== null && ! ( _getCats( ':not(.hidden)' ).length ) ) {
				wikiText += '\n\n' + settings.missingCatsWikiText;
			}

			return wikiText;
		};

		// initialize with some categories, if so configured
		$j.each( settings.cats, function( i, cat ) { _insertCat( new mw.Title( cat, catNsId ) ); } );
		$j.each( settings.hiddenCats, function( i, cat ) { _insertCat( new mw.Title( cat, catNsId ), true ); } );

		_processInput();
	} );


}; } )( jQuery );
