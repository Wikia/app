/*!
 * VisualEditor tracking for Wikia
 */

/* global require */

require( ['wikia.tracker'], function ( tracker ) {
	var actions = tracker.ACTIONS,
		nameToLabelMap = {
			'meta': 'page-settings',
			'transclusion': 'template',
			'wikiaMediaInsert': 'media-insert',
			'wikiaSourceMode': 'source'
		},
		rSpecialChars = /[A-Z]/g;

	/**
	 * Convert symbolic names to tracking labels, falling back to the symbolic name if there is
	 * nothing else to map it to.
	 *
	 * @example
	 * "meta" -> "page-settings"
	 *
	 * @method
	 * @param {string} name The symbolic name
	 * @returns {string} The converted label
	 */
	function nameToLabel( name ) {
		return nameToLabelMap[name] || name;
	}

	/**
	 * Editor tracking function.
	 *
	 * @method
	 * @param {string} [name] Used by MediaWiki to distinguish tracking events.
	 * @param {Object} data The data to send to our internal tracking function.
	 */
	function track( name, data ) {
		var params = {
			category: 'editor-ve',
			trackingMethod: 'both'
		};

		// Handle MW tracking calls
		if ( typeof name === 'string' ) {
			switch( data.action ) {
				case 'edit-link-click':
					params.action = actions.CLICK;
					params.category = 'article';
					params.label = 've-edit';
					break;
				case 'page-edit-impression':
					params.action = actions.IMPRESSION;
					params.label = 'edit-page';
					break;
				case 'page-save-attempt':
					params.action = actions.CLICK;
					params.label = 'button-publish';
					break;
				case 'page-save-success':
					params.action = actions.SUCCESS;
					params.label = 'publish';
					params.value = data.latency;
					break;
				case 'section-edit-link-click':
					params.action = actions.CLICK;
					params.category = 'article';
					params.label = 've-section-edit';
					break;
				default:
					// Don't track
					return;
			}
		} else {
			ve.extendObject( params, name );

			// Normalize label values
			params.label = params.label.replace( rSpecialChars, upperToHyphenLower );
		}

		tracker.track( params );
	}

	/**
	 * Convert a string from lazyCamelCase to lowercase-hyphen style.
	 *
	 * @method
	 * @param {string} match The matched string to convert.
	 * @returns {string} The converted string.
	 */
	function upperToHyphenLower( match ) {
		return '-' + match.toLowerCase();
	}

	// Exports
	ve.track.actions = actions;
	ve.track.nameToLabel = nameToLabel;
	ve.trackRegisterHandler( track );
} );
