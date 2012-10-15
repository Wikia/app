/**
 * Narayam
 * Input field rewriter tool for web pages
 * @author Junaid P V ([[user:Junaidpv]])(http://junaidpv.in)
 * @date 2010-12-18 (Based on naaraayam transliteration tool I first wrote on 2010-05-19)
 * @version 3.0
 * Last update: 2010-11-28
 * License: GPLv3
 */

/**
 * NOTE: For documentation on writing schemes and rulesets, see the
 * documentation for addScheme().
 */

( function( $ ) {
$.narayam = new ( function() {
	/* Private members */

	// Reference to this object
	var that = this;
	// jQuery array holding all text inputs Narayam applies to
	var $inputs = $( [] );
	// Whether Narayam is enabled
	var enabled = false;
	// Registered schemes
	var schemes = {};
	// List of scheme names, ordered for presentation purposes
	// Schemes not in this list won't be allowed to register
	// This object is formatted as { 'schemename': '', 'schemename2': '', ... }
	// for easy searching
	var availableSchemes = mw.config.get( 'wgNarayamAvailableSchemes' ) || {};
	// All input methods. This will be used for selecting input methods from languages
	// other than uselang- optionally
	var allImes = mw.config.get( 'wgNarayamAllSchemes' ) || {};
	// Currently selected scheme
	var currentScheme = null;
	// Shortcut key for turning Narayam on and off
	var shortcutKey = getShortCutKey();
	// Number of recent input methods to be shown
	var recentItemsLength = mw.config.get( 'wgNarayamRecentItemsLength' );

	/* Private functions */

	/**
	 * Transliterate a string using the current scheme
	 * @param str String to transliterate
	 * @param keyBuffer The key buffer
	 * @param useExtended Whether to use the extended part of the scheme
	 * @return Transliterated string, or str if no applicable transliteration found.
	 */
	this.transliterate = function( str, keyBuffer, useExtended ) {
		var rules = currentScheme.extended_keyboard && useExtended ?
			currentScheme.rules_x : currentScheme.rules;
		for ( var i = 0; i < rules.length; i++ ) {
			var regex = new RegExp( rules[i][0] + '$' );
			if ( regex.test( str ) // Input string match
				&&
				(
					rules[i][1].length === 0 // Keybuffer match not required
					||
					( // Keybuffer match specified, so it should be met
						rules[i][1].length > 0
						&& rules[i][1].length <= keyBuffer.length
						&& new RegExp( rules[i][1] + '$' ).test( keyBuffer )
					)
				)
			) {
				return str.replace( regex, rules[i][2] );
			}
		}
		// No matches, return the input
		return str;
	}

	/**
	 * Get the n characters in str that immediately precede pos
	 * Example: lastNChars( "foobarbaz", 5, 2 ) == "ba"
	 * @param str String to search in
	 * @param pos Position in str
	 * @param n Number of characters to go back from pos
	 * @return Substring of str, at most n characters long, immediately preceding pos
	 */
	this.lastNChars = function( str, pos, n ) {
		if ( n === 0 ) {
			return '';
		} else if ( pos <= n ) {
			return str.substr( 0, pos );
		} else {
			return str.substr( pos - n, n );
		}
	}

	/**
	 * Find the point at which a and b diverge, i.e. the first position
	 * at which they don't have matching characters.
	 * @param a String
	 * @param b String
	 * @return Position at which a and b diverge, or -1 if a == b
	 */
	this.firstDivergence = function( a, b ) {
		var minLength = a.length < b.length ? a.length : b.length;
		for ( var i = 0; i < minLength; i++ ) {
			if ( a.charCodeAt( i ) !== b.charCodeAt( i ) ) {
				return i;
			}
		}
		return -1;
	}

	/**
	 * Check whether a keypress event corresponds to the shortcut key
	 * @param e Event object
	 * @return bool
	 */
	function isShortcutKey( e ) {
		return e.altKey == shortcutKey.altKey &&
			e.ctrlKey == shortcutKey.ctrlKey &&
			e.shiftKey == shortcutKey.shiftKey &&
			String.fromCharCode( e.which ) == shortcutKey.key;
	}

	/**
	 * Get the shortcut key for the tool, depending on OS, browser
	 * @return shortcutKey
	 */
	function getShortCutKey() {
		var defaultShortcut = {
			altKey: false,
			ctrlKey: true,
			shiftKey: false,
			cmdKey: false,
			key: 'M'
		};
		// Browser sniffing to determine the available shortcutKey
		// Refer: mediawiki.util.js and en.wikipedia.org/wiki/Access_key
		var profile = $.client.profile();
		// Safari/Konqueror on any platform, but not Safari on Windows
		// or any browser on Mac except chrome and opera
		if ( !( profile.platform == 'win' && profile.name == 'safari' ) &&
			 ( profile.name == 'safari'|| profile.platform == 'mac' || profile.name == 'konqueror' )
			 && !( profile.name == 'opera' || profile.name == 'chrome' ) ) {
			defaultShortcut.key = 'G';
		}
		// For Opera in OSX, shortcut is control+command+m.
		if ( profile.name == 'opera' && profile.platform == 'mac' ) {
			defaultShortcut.cmdKey = true;
		}
		return defaultShortcut;
	}

	/**
	 * Get a description of the shortcut key, e.g. "Ctrl-M"
	 * @return string
	 */
	function shortcutText() {
		var text = '';
		// TODO: Localize these things (in core, too)
		if ( shortcutKey.ctrlKey ) {
			text += 'Ctrl-';
		}
		if ( shortcutKey.shiftKey ) {
			text += 'Shift-';
		}
		if ( shortcutKey.altKey ) {
			text += 'Alt-';
		}
		if ( shortcutKey.cmdKey ) {
			text += 'Command-';
		}
		text += shortcutKey.key.toUpperCase();
		return text;
	}

	/**
	 * Change visual appearance of element (text input, textarea) according
	 * to the current state of Narayam
	 */
	function changeVisual( $element ) {
		if ( enabled ) {
			$element.addClass( 'narayam-input' );
		} else {
			$element.removeClass( 'narayam-input' );
		}
	}

	/**
	 * Replace text part from startPos to endPos with peri
	 * This function is specifically for webkit browsers,
	 * because of bug: https://bugs.webkit.org/show_bug.cgi?id=66630
	 * TODO: remove when webkit bug is handled in jQuery.textSelection.js
	 *
	 * @param $element jQuery object to wich replacement to be taked place
	 * @param startPos Starting position of text range to be replaced
	 * @param endPos Ending position of text range to be replaced
	 * @param peri String to be substituted
	 */
	function replaceString( $element, startPos, endPos, peri ) {
		// Take entire text of the element
		var text = $element.val();
		var pre = text.substring( 0, startPos );
		var post = text.substring( endPos, text.length );

		// Then replace
		$element.val( pre + peri + post );
	}

	/**
	 * Keydown event handler. Handles shortcut key presses
	 * @param e Event object
	 */
	function onkeydown( e ) {
		// If the current scheme uses the alt key, ignore keydown for Alt+? combinations
		if ( enabled && currentScheme.extended_keyboard && e.altKey && !e.ctrlKey ) {
			e.stopPropagation();
			return false; // Not in original code -- does this belong here?
		} else if ( isShortcutKey( e ) ) {
			that.toggle();
			changeVisual( $( this ) );
			e.stopPropagation();
			return false;
		}
		return true;
	}

	/**
	 * Keypress event handler. This is where the real work happens
	 * @param e Event object
	 */
	function onkeypress( e ) {
		if ( !enabled ) {
			return true;
		}

		if ( e.which == 8 ) { // Backspace
			// Blank the keybuffer
			$( this ).data( 'narayamKeyBuffer', '' );
			return true;
		}

		// Leave ASCII control characters alone, as well as anything involving
		// Alt (except for extended keymaps), Ctrl and Meta
		if ( e.which < 32 || ( e.altKey && !currentScheme.extended_keyboard ) || e.ctrlKey || e.metaKey ) {
			return true;
		}

		var $this = $( this );
		var c = String.fromCharCode( e.which );
		// Get the current caret position. The user may have selected text to overwrite,
		// so get both the start and end position of the selection. If there is no selection,
		// startPos and endPos will be equal.
		var pos = $this.textSelection( 'getCaretPosition', { 'startAndEnd': true } );
		var startPos = pos[0];
		var endPos = pos[1];
		// Get the last few characters before the one the user just typed,
		// to provide context for the transliteration regexes.
		// We need to append c because it hasn't been added to $this.val() yet
		var input = that.lastNChars( $this.val(), startPos, currentScheme.lookbackLength ) + c;
		var keyBuffer = $this.data( 'narayamKeyBuffer' );
		var replacement = that.transliterate( input, keyBuffer, e.altKey );

		// Update the key buffer
		keyBuffer += c;
		if ( keyBuffer.length > currentScheme.keyBufferLength ) {
			// The buffer is longer than needed, truncate it at the front
			keyBuffer = keyBuffer.substring( keyBuffer.length - currentScheme.keyBufferLength );
		}
		$this.data( 'narayamKeyBuffer', keyBuffer );

		// textSelection() magic is expensive, so we avoid it as much as we can
		if ( replacement == input ) {
			return true;
		}
		// Drop a common prefix, if any
		// TODO: Profile this, see if it's any faster
		var divergingPos = that.firstDivergence( input, replacement );
		input = input.substring( divergingPos );
		replacement = replacement.substring( divergingPos );

		$this.textSelection( 'encapsulateSelection', {
			peri: replacement,
			replace: true,
			selectPeri: false,
			selectionStart: startPos - input.length + 1,
			selectionEnd: endPos
		} );

		e.stopPropagation();
		return false;
	}

	/**
	 * Focus event handler.
	 * @param e Event object
	 */
	function onfocus( e ) {
		if ( !$( this ).data( 'narayamKeyBuffer' ) ) {
			// First-time focus on the input field
			// So, initialise a key buffer for it
			$( this ).data( 'narayamKeyBuffer', '' );
		}
		changeVisual( $( this ) );
	}

	/**
	 * Blur event handler.
	 * @param e Event object
	 */
	function onblur( e ) {
		$( this ).removeClass( 'narayam-input' );
	}


	/* Public functions */

	/**
	 * Add more inputs to apply Narayam to
	 * @param inputs A jQuery object holding one or more input or textarea elements,
	 *               or an array of DOM elements, or a single DOM element, or a selector
	 */
	this.addInputs = function( inputs ) {
		if ( typeof( inputs ) === "string" ) {
			// If a string is passed, it is a CSS selector
			// We can use jQuery's .live() instead of .bind()
			// So Narayam can work on elements added later to DOM too
			$( inputs )
				.live( 'keydown', onkeydown )
				.live( 'keypress', onkeypress )
				.live( 'focus', onfocus )
				.live( 'blur', onblur );
		} else {
			var $newInputs = $( inputs );
			$inputs = $inputs.add( $newInputs );
			$newInputs
				.bind( 'keydown.narayam', onkeydown )
				.bind( 'keypress.narayam', onkeypress )
				.bind( 'focus', onfocus )
				.bind( 'blur', onblur );
		}
	};

	/**
	 * Enable Narayam
	 */
	this.enable = function() {
		if ( !enabled ) {
			$.cookie( 'narayam-enabled', '1', { path: '/', expires: 30 } );
			$( '#narayam-toggle' ).prop( 'checked', true );
			$( 'li#pt-narayam' )
				.removeClass( 'narayam-inactive' )
				.addClass( 'narayam-active' );
			enabled = true;
		}
	};

	/**
	 * Disable Narayam
	 */
	this.disable = function() {
		if ( enabled ) {
			$.cookie( 'narayam-enabled', '0', { path: '/', expires: 30 } );
			$( '#narayam-toggle' ).prop( 'checked', false );
			$( 'li#pt-narayam' )
				.removeClass( 'narayam-active' )
				.addClass( 'narayam-inactive' );
			enabled = false;
		}
	};

	/**
	 * Toggle the enabled/disabled state
	 */
	this.toggle = function() {
		if ( enabled ) {
			that.disable();
		} else {
			that.enable();
		}
	};

	this.enabled = function() {
		return enabled;
	};

	/**
	 * Add a transliteration scheme. Schemes whose name is not in
	 * wgNarayamAvailableSchemes will be ignored.
	 *
	 * A scheme consists of rules used for transliteration. A rule is an
	 * array of three strings. The first string is a regex that is matched
	 * against the input string (the last few characters before the cursor
	 * followed by the character the user entered), the second string is a
	 * regex that is matched against the end of the key buffer (the last
	 * few keys the user pressed), and the third string is the replacement
	 * string (may contain placeholders like $1 for subexpressions). You do
	 * not need to add $ to the end of either of the regexes so they match
	 * at the end, this is done automagically.
	 *
	 * The transliteration algorithm processes the rules in the order they
	 * are specified, and applies the first rule that matches. For a rule
	 * to match, both the first and second regex have to match (the first
	 * for the input, the second for the key buffer). Most rules do not use
	 * the keybuffer and specify an empty string as the second regex.
	 *
	 * The scheme data object must have the following keys:
	 * namemsg: Message key for the name of the scheme
	 * extended_keyboard: Whether this scheme has an extended ruleset (bool)
	 * lookbackLength: Number of characters before the cursor to include
	 *                 when matching the first regex of each rule. This is
	 *                 usually the maximum number of characters a rule
	 *                 regex can match minus one.
	 * keyBufferLength: Length of the key buffer. May be zero if not needed
	 * rules: Array of rules, which themselves are arrays of three strings.
	 * rules_x: Extended ruleset. This is used instead of the normal
	 *          ruleset when Alt is held. This key is only required if
	 *          extended_keyboard is true
	 *
	 * NOTE: All keys are REQUIRED (except rules_x when not used). Missing
	 *       keys may result in JS errors.
	 *
	 * @param name Name of the scheme, must be unique
	 * @param data Object with scheme data.
	 * @return True if added, false if not
	 */
	this.addScheme = function( name, data ) {
		schemes[name] = data;
		return true;
	};

	/**
	 * Get the transliteration rules for the given input method name.
	 * @param name String
	 */
	this.getScheme = function( name ) {
		return schemes[name];
	};

	/**
	 * Change the current transliteration scheme
	 * @param name String
	 */
	this.setScheme = function( name ) {
		var recent = $.cookie( 'narayam-scheme' ) || [];
		if ( typeof recent === "string" ) {
			recent = recent.split( "," );
		}
		recent = $.grep( recent, function( value ) {
			 return value != name;
		} );
		recent.unshift( name );
		recent = recent.slice( 0, recentItemsLength );
		recent = recent.join( "," );
		$.cookie( 'narayam-scheme', recent, { path: '/', expires: 30 } );
		if ( name in schemes ) {
			currentScheme = schemes[name];
		} else {
			// load the rules dynamically.
			mw.loader.using( "ext.narayam.rules." + name, function() {
				currentScheme = schemes[name];
			} );
		}
		return true;
	};

	/**
	 * Set up Narayam. This adds the scheme dropdown, binds the handlers
	 * and initializes the enabled/disabled state and selected scheme
	 * from a cookie or wgNarayamEnabledByDefault
	 */
	this.setup = function() {
		that.buildMenu();
		// Restore state from cookies
		var recent = $.cookie( 'narayam-scheme' );
		var lastScheme = null;
		if ( typeof recent === "string" ) {
			lastScheme = recent.split( "," )[0];
		}
		if ( lastScheme ) {
			that.setScheme( lastScheme );
			$( '#narayam-' + lastScheme ).prop( 'checked', true );
		} else {
			//if no saved input scheme, select the first.
			var $firstScheme = $( 'input.narayam-scheme:first' );
			that.setScheme( $firstScheme.val() );
			$firstScheme.prop( 'checked', true );

		}
		var enabledCookie = $.cookie( 'narayam-enabled' );
		if ( enabledCookie == '1' || ( mw.config.get( 'wgNarayamEnabledByDefault' ) && enabledCookie !== '0' ) ) {
			that.enable();
		} else {
			$( 'li#pt-narayam' ).addClass( 'narayam-inactive' );
		}
		// Renew the narayam-enabled cookie. narayam-scheme is renewed by setScheme()
		if ( enabledCookie ) {
			$.cookie( 'narayam-enabled', enabledCookie, { path: '/', expires: 30 } );
		}

	};
	/**
	 * Construct the menu item, for the given scheme name.
	 */
	this.buildMenuItem = function( scheme ) {
		var $input = $( '<input type="radio" name="narayam-input-method" class="narayam-scheme" />' );
		$input.attr( 'id', 'narayam-' + scheme ).val( scheme );

		var $narayamMenuItemLabel = $( '<label>' )
			.attr( 'for' ,'narayam-' + scheme )
			.append( $input )
			.append( mw.message( 'narayam-' + scheme ).escaped() );

		var $narayamMenuItem = $( '<li>' )
			.append( $input )
			.append( $narayamMenuItemLabel );

		return $narayamMenuItem;
	};

	/**
	 * prepare the menu list for all the input methods.
	 * @return The div containing the constructed menu.
	 */
	this.buildMenuItems = function() {
		var haveSchemes = false;
		// Build schemes option list
		var $narayamMenuItems = $( '<ul>' );
		var count = 1;
		var seen = [];

		var recent = $.cookie( "narayam-scheme" ) || [];
		if ( typeof recent === "string" ) {
			recent = recent.split( "," );
		}

		// Prepare the recent inputmethods menu items
		for ( var i = 0; i < recent.length; i++ ) {
			var scheme = recent[i];
			if ( $.inArray( scheme, seen ) > -1 ) { continue; }
			seen.push( scheme );
			if ( count++ > recentItemsLength ) { break; }
			var $narayamMenuItem = that.buildMenuItem( scheme );
			$narayamMenuItem.addClass( 'narayam-recent-menu-item' );
			$narayamMenuItems.append( $narayamMenuItem );
		}

		// menu items for the language of wiki.
		var requested = [mw.config.get( 'wgUserVariant' ), mw.config.get( 'wgContentLanguage' ), mw.config.get( 'wgUserLanguage' )];
		$( 'textarea[lang]' ).each( function( index ) {
			requested.push( this.lang );
		});
		for ( var i = 0; i < requested.length; i++ ) {
			var lang = requested[i];
			var langschemes = allImes[lang];
			if ( !langschemes ) continue;
			for ( var scheme in langschemes ) {
				haveSchemes = true;
				if ( $.inArray( scheme, seen ) !== -1 ) { continue; }
				seen.push( scheme );
				var $narayamMenuItem = that.buildMenuItem( scheme );
				$narayamMenuItems.append( $narayamMenuItem );
			}
		}

		if ( !haveSchemes ) {
			// No schemes available, don't show the tool
			return null;
		}

		// Build enable/disable checkbox and label
		var $checkbox = $( '<input type="checkbox" id="narayam-toggle" />' );
		$checkbox
			.attr( 'title', mw.msg( 'narayam-checkbox-tooltip' ) )
			.click( that.toggle );

		var $label = $( '<label>' ).attr( 'for', 'narayam-toggle' );
		$label
			.text( mw.msg( 'narayam-toggle-ime', shortcutText() ) )
			.prepend( $checkbox )
			.prop( 'title', mw.msg( 'narayam-checkbox-tooltip' ) );

		var $moreLink = $( '<a>' )
			.text( mw.msg( 'narayam-more-imes' ) )
			.prop( 'href', '#' )
			.click( function( event ) {
				$('.narayam-scheme-dynamic-item').toggle( 'fast' );
				if ( $('li.narayam-more-imes-link').hasClass( 'open' ) ) {
					$('li.narayam-more-imes-link').removeClass( 'open' );
				} else {
					$('li.narayam-more-imes-link').addClass( 'open' );
				}
				event.stopPropagation();
			} );

		$narayamMenuItems.append( $( '<li>' )
			.addClass( 'narayam-more-imes-link' )
			.append( $moreLink )
		);

		for ( var lang in allImes ) {
			var langschemes = allImes[lang];
			for ( var langscheme in langschemes ) {
				// Do not repeat the input methods in more input methods section.
				// If already shown on recent items.
				if ( $.inArray( langscheme, seen ) > -1 ) { continue; }

				var $narayamMenuItem = that.buildMenuItem( langscheme );
				$narayamMenuItem.addClass( 'narayam-scheme-dynamic-item' );
				$narayamMenuItems.append( $narayamMenuItem );
			}
		}

		// Event listener for scheme selection - dynamic loading of rules.
		$narayamMenuItems.delegate( 'input:radio', 'click', function( ) {
			that.setScheme( $( this ).val() );
			if ( $( this ).parent().hasClass( 'narayam-scheme-dynamic-item' ) ){
				// rebuild the menu items with recent items.
				$( '#narayam-menu' ).html( $.narayam.buildMenuItems() );
				$( '#narayam-menu-items' ).css( 'left', $( 'li#pt-narayam' ).offset().left );
				$( '#narayam-' + $( this ).val() ).prop( 'checked', true );
				if ( enabled ) {
					$( '#narayam-toggle' ).prop( 'checked', true );
				}
			}
		} );

		var helppage = mw.config.get( 'wgNarayamHelpPage' );
		if ( helppage ) {
			var $link = $( '<a>' )
				.text( mw.msg( 'narayam-help' ) )
				.prop( 'href',  helppage )
				.prop( 'target', '_blank' );
			var $li = $( '<li>' ).addClass( 'narayam-help-link' );
			$narayamMenuItems.append( $li.append( $link ) );
		}

		$narayamMenuItems.prepend( $( '<li>' ).append( $label ) );

		return $( '<div>' )
			.attr( 'id', 'narayam-menu-items' )
			.addClass( 'menu-items' )
			.append( $narayamMenuItems );
	}


	/**
	 * Construct the menu for Narayam
	 */
	this.buildMenu = function() {
		// Remove the menu if already exists
		if( $( 'li#pt-webfont' ).length > 0 ) {
			$( 'li#pt-narayam' ).remove();
			$( 'div#narayam-menu' ).remove();
		}
		var $menuItemsDiv = that.buildMenuItems();
		if( $menuItemsDiv == null ) {
			return;
		}
		var $menu = $( '<div>' )
			.attr( 'id', 'narayam-menu' )
			.addClass( 'narayam-menu' );
		var $link = $( '<a>' )
			.prop( 'href', '#' )
			.text( mw.msg( 'narayam-menu' ) )
			.attr( 'title', mw.msg( 'narayam-menu-tooltip' ) );

		$menu.append( $menuItemsDiv );
		var $li = $( '<li>' ).attr( 'id', 'pt-narayam' ).append( $link );

		// If rtl, add to the right of top personal links. Else, to the left
		var rtlEnv = $( 'body' ).hasClass( 'rtl' );
		var positionFunction = rtlEnv ? "append" : "prepend";
		$( '#p-personal ul:first' )[positionFunction]( $li );
		$( 'body' ).prepend( $menu );
		$menu.hide();
		$li.click( function( event ) {
			var menuSide, menuOffset, distanceToEdge;

			if ( rtlEnv ) {
				distanceToEdge = $li.outerWidth() + $li.offset().left;
				if ( $menuItemsDiv.outerWidth() > distanceToEdge ) {
					menuSide = 'left';
					menuOffset = $li.offset().left;
				} else {
					menuSide = 'right';
					menuOffset = $(window).width() - distanceToEdge;
				}
			} else {
				distanceToEdge = $(window).width() - $li.offset().left;
				if ( $menuItemsDiv.outerWidth() > distanceToEdge ) {
					menuSide = 'right';
					menuOffset = distanceToEdge - $li.outerWidth();
				} else {
					menuSide = 'left';
					menuOffset = $li.offset().left;
				}
			}

			$menuItemsDiv.css( menuSide, menuOffset );

			if( $menu.hasClass( 'open' ) ){
				$menu.removeClass( 'open' );
				$menu.hide();
			} else {
				$( 'div.open' ).removeClass( 'open' );
				$menu.addClass( 'open' );
				$menu.show();
				event.stopPropagation();
			}
		} );

		$( 'html' ).click( function() {
			$menu.removeClass( 'open' );
			$menu.hide();
		} );
 		$menu.click( function( event ) {
			event.stopPropagation();
		} );

		// Workaround for IE bug - activex components like input fields
		// coming on top of everything.
		// TODO: is there a better solution other than hiding it on hover?
		if ( $.browser.msie ) {
			$( '#narayam-menu' ).hover( function() {
				$( '#searchform' ).css( 'visibility', 'hidden' );
			}, function() {
				$( '#searchform' ).css( 'visibility', 'visible' );
			});
		}
		$('.narayam-scheme-dynamic-item').hide();

		// Narayam controls setup complete, returns true
		return true;
	};
} )();

} )( jQuery );
