/**
 * jquery.moodbar.js
 * JavaScript interface for the MoodBar backend.
 *
 * @author Andrew Garrett
 */
( function( $ ) {
	$.moodBar = {
		/**
		 * Submit a MoodBar feedback item.
		 * @param fbProps Object: Properties for the FeedbackItem:
		 *  - comment: The comments submitted
		 *  - bucket: A bucket, for A/B testing.
		 *  - anonymize: Boolean, whether or not to mark as anonymous
		 *  - callback: A function, accepts a single 'fbProps' parameter, to call when the
		 *    request completes.
		 *  - type: A string.
		 * @return jqXHR
		 */
		'submit': function( fbProps ) {
			var	clientData = $.client.profile(),
				fb = $.extend( {
					'page': mw.config.get( 'wgPageName' ),
					'editmode': mw.config.get( 'wgAction' ) == 'edit' ? 1 : 0
				}, fbProps ),
				apiRequest = {
					'action': 'moodbar',
					'page': fb.page,
					'comment': fb.comment,
					'anonymize': fb.anonymize,
					'useragent': clientData.name + '/' + clientData.versionNumber,
					'system': clientData.platform,
					'bucket': fb.bucket,
					'type': fb.type,
					'token': mw.user.tokens.get('editToken'),
					'format': 'json'
				};
				
				// API treats any value as true.
				if ( fb.editmode ) {
					apiRequest.editmode = true;
				}

			return $.ajax( {
				type: 'post',
				url: mw.util.wikiScript( 'api' ),
				data: apiRequest,
				success: fb.callback,
				dataType: 'json'
			} );
		}, 

		/* ajax method to set user email. 
		 * called when user email address is not sent.
		 */
		'setEmail': function( mbProps ) {			
			var apiRequest = {
				'action': 'moodbarsetuseremail',
				'mbaction': 'setemail', 
				'email': mbProps.email,
				'token': mw.user.tokens.get('editToken'),
				'format':'json'
			};
			return $.ajax( {
				type: 'post',
				url: mw.util.wikiScript( 'api' ),
				data: apiRequest,
				success: mbProps.callback,
				dataType: 'json' 
			} );
		}, 

		'resendVerification': function (mbProps) {
			var apiRequest = {
				'action': 'moodbarsetuseremail',
				'mbaction': 'resendverification', 
				'token': mw.user.tokens.get('editToken'),
				'format':'json'
			};
			return $.ajax( {
				type: 'post',
				url: mw.util.wikiScript( 'api' ),
				data: apiRequest,
				success: mbProps.callback,
				dataType: 'json' 
			} );
		}
	};
} ) ( jQuery );
