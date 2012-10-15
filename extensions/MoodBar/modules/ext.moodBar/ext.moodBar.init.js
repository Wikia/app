/**
 * Initialization script for the MoodBar MediaWiki extension
 *
 * @author Timo Tijhof, 2011
 * @author Rob Moen, 2011
 */
( function( $ ) {

	var mb = mw.moodBar = {

		conf: mw.config.get( 'mbConfig' ),		
		userData: {}, //set by getUserInfo

		cookiePrefix: function() {
			return 'ext.moodBar@' + mb.conf.bucketConfig.version + '-';
		},

		isDisabled: function() {
			var cookieDisabled = ($.cookie( mb.cookiePrefix() + 'disabled' ) == '1');
			var browserDisabled = false;
			var clientInfo = $.client.profile();
			
			if ( clientInfo.name == 'msie' && clientInfo.versionNumber < 7 ) {
				browserDisabled = true;
			}
			
			return cookieDisabled || browserDisabled;
		},

		ui: {
			// jQuery objects
			pMoodbar: null,
			trigger: null,
			overlay: null
		},

		init: function() {
			var ui = mb.ui;

			mb.conf.bucketKey = mw.user.bucket(
				'moodbar-trigger',
				mb.conf.bucketConfig
			);

			// Create portlet
			ui.pMoodbar = $( '<div id="p-moodbar"></div>' );

			// Create trigger
			ui.trigger = $( '<a>' )
				.attr( 'href', '#' )
				.attr( 'title', mw.msg( 'tooltip-p-moodbar-trigger-' + mb.conf.bucketKey ) )
				.text( mw.msg( 'moodbar-trigger-' + mb.conf.bucketKey, mw.config.get( 'wgSiteName' ) ) );

			// Insert trigger into portlet
			ui.trigger
				.wrap( "<span>" ).attr('id', 'p-moodbar-el') // absolute id for bg to work in ie7
				.parent()
				.appendTo( ui.pMoodbar );
			
			// Inject portlet into document, when document is ready
			$( mb.inject );

		},

		inject: function() {
			$( '#mw-head' ).append( mb.ui.pMoodbar );
		}
	};

	if ( !mb.isDisabled() ) {
		mb.init();
	}

} )( jQuery );
