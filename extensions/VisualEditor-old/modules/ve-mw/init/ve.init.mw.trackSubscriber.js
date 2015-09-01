/*!
 * VisualEditor MediaWiki event subscriber.
 *
 * Subscribes to ve.track() events and routes them to mw.track().
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

( function () {

	var lastEventWithAction = {},
		editingSessionId = mw.user.generateRandomSessionId();

	function getDefaultTiming( action, data, now ) {
		switch ( action ) {
			case 'init':
				// Account for second opening
				return now - Math.max(
					Math.floor( window.mediaWikiLoadStart ),
					lastEventWithAction.saveSuccess || 0,
					lastEventWithAction.abort || 0
				);
			case 'ready':
				return now - lastEventWithAction.init;
			case 'saveIntent':
				return now - lastEventWithAction.ready;
			case 'saveAttempt':
				return now - lastEventWithAction.saveIntent;
			case 'saveSuccess':
			case 'saveFailure':
				// HERE BE DRAGONS: the caller must compute these themselves
				// for sensible results. Deliberately sabotage any attempts to
				// use the default by returning -1
				mw.log.warn( 've.init.mw.trackSubscriber: Do not rely on default timing value for saveSuccess/saveFailure' );
				return -1;
			case 'abort':
				switch ( data.type ) {
					case 'preinit':
						return now - lastEventWithAction.init;
					case 'nochange':
					case 'switchwith':
					case 'switchwithout':
					case 'abandon':
						return now - lastEventWithAction.ready;
					case 'abandonMidsave':
						return now - lastEventWithAction.saveAttempt;
				}
		}
		mw.log.warn( 've.init.mw.trackSubscriber: Unrecognized action', action );
		return -1;
	}

	ve.trackSubscribeAll( function ( topic, data ) {
		data = data || {};
		var newData, action,
			now = Math.floor( ve.now() ),
			prefix = topic.slice( 0, topic.indexOf( '.' ) );

		if ( prefix === 'mwtiming' ) {
			// Add type for save errors; not in the topic for stupid historical reasons
			if ( topic === 'mwtiming.performance.user.saveError' ) {
				topic += '.' + data.type;
			}
			// Map mwtiming.foo --> timing.ve.foo.mobile
			topic = 'timing.ve.' + topic.slice( 'mwtiming.'.length ) + '.' + data.targetName;
			data = data.duration;
		} else if ( prefix === 'mwedit' ) {
			// Edit schema
			action = topic.split( '.' )[1];
			if ( action === 'init' ) {
				// Regenerate editingSessionId
				editingSessionId = mw.user.generateRandomSessionId();
			}
			newData = $.extend( {
				version: 1,
				action: action,
				editor: 'visualeditor',
				platform: 'desktop', // FIXME
				integration: ve.init.target && ve.init.target.constructor.static.integrationType || 'page',
				'page.id': mw.config.get( 'wgArticleId' ),
				'page.title': mw.config.get( 'wgPageName' ),
				'page.ns': mw.config.get( 'wgNamespaceNumber' ),
				'page.revid': mw.config.get( 'wgRevisionId' ),
				'page.length': -1, // FIXME
				editingSessionId: editingSessionId,
				'user.id': mw.user.id(),
				'user.editCount': mw.config.get( 'wgUserEditCount', 0 )
			}, data );

			if ( mw.user.anonymous() ) {
				newData['user.class'] = 'IP';
			}

			newData['action.' + action + '.type'] = data.type;
			newData['action.' + action + '.mechanism'] = data.mechanism;
			newData['action.' + action + '.timing'] = data.timing !== undefined ?
				Math.floor( data.timing ) : getDefaultTiming( action, data, now );
			// Remove renamed properties
			delete newData.type;
			delete newData.mechanism;
			delete newData.timing;

			data = newData;
			topic = 'event.Edit';
			lastEventWithAction[action] = now;
		}

		//mw.track( topic, data );
	} );

} )();
