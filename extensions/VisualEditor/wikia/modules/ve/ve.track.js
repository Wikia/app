/*!
 * VisualEditor tracking for Wikia
 */

/* global require */

require( ['wikia.tracker'], function ( tracker ) {
	var actions = tracker.ACTIONS,
		// These are topics used by MediaWiki, consider them reserved. Each topic should contain
		// any number of actions which should contain tracking parameters as they will be passed
		// to Wikia.Tracker. If you need to define these parameters dynamically, you may use a
		// function. Otherwise, a plain Object is fine.
		mwTopics = {
			'Edit': {
				'edit-link-click': {
					'action': actions.CLICK,
					'category': 'article',
					'label': 've-edit'
				},
				'section-edit-link-click': {
					'action': actions.CLICK,
					'category': 'article',
					'label': 've-section-edit'
				}
			},
			// TODO: support regex match or exploding on "." so we can track across "performance" etc.
			'performance.system.activation': function ( data ) {
				return {
					'action': actions.IMPRESSION,
					'label': 'edit-page',
					'value': data.duration
				};
			},
			'performance.user.saveComplete': function ( data ) {
				return {
					'action': actions.SUCCESS,
					'label': 'publish',
					'value': data.duration
				};
			}
		},
		// @see {@link nameToLabel} for more information
		nameToLabelMap = {
			'meta': 'page-settings',
			'transclusion': 'template',
			'wikiaMediaInsert': 'media-insert',
			'wikiaSourceMode': 'source'
		},
		rUppercase = /[A-Z]/g;

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
	 * @param {string} topic Event sub-category (like "tool", "button", etc.); this will be joined
	 * with data.label to form the whole label for the event.
	 * @param {Object} data The data to send to our internal tracking function.
	 */
	function track( topic, data ) {
		var mwEvent,
			params = {
				category: 'editor-ve',
				trackingMethod: 'both'
			};

		// MW events
		if ( topic !== 'wikia' ) {
			mwEvent = mwTopics[topic];
			// Only track things we care about
			if ( !mwEvent || ( data.action && !( mwEvent = mwEvent[data.action] ) ) ) {
				return;
			}
			data = $.isFunction( mwEvent ) ? mwEvent( data ) : mwEvent;
		} else {
			// Normalize tracking labels
			data.label = data.label.replace( rUppercase, upperToHyphenLower );
		}

		tracker.track( ve.extendObject( params, data ) );
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
	ve.trackSubscribeAll( track );
} );
