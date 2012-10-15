/*
 * Script for Article Feedback Extension
 */

/**
 * Global debug function
 *
 * @param any Output message
 */
aft5_debug = function( any ) {
	if ( typeof console != 'undefined' ) {
		console.log( any );
	}
}

/*** Main entry point ***/
jQuery( function( $ ) {

	var ua = navigator.userAgent.toLowerCase();
	// Rule out MSIE 6, iPhone, iPod, iPad, Android
	if(
		(ua.indexOf( 'msie 6' ) != -1) ||
		/*(ua.indexOf( 'msie 7' ) != -1) ||*/
		(ua.indexOf( 'firefox/2') != -1) ||
		(ua.indexOf( 'firefox 2') != -1) ||
		(ua.indexOf( 'android' ) != -1) ||
		(ua.indexOf( 'iphone' ) != -1) ||
		(ua.indexOf( 'ipod' ) != -1 ) ||
		(ua.indexOf( 'ipad' ) != -1)
	) {
		return;
	}

	// Load check, is this page ArticleFeedbackv5-enabled ?
	// Keep in sync with ApiArticleFeedbackv5.php
	if (
		// Only on pages in namespaces where it is enabled
		$.inArray( mw.config.get( 'wgNamespaceNumber' ), mw.config.get( 'wgArticleFeedbackv5Namespaces', [] ) ) > -1
		// Existing pages
		&& mw.config.get( 'wgArticleId' ) > 0
		// View pages
		&& ( mw.config.get( 'wgAction' ) == 'view' || mw.config.get( 'wgAction' ) == 'purge' )
		// If user is logged in, showing on action=purge is OK,
		// but if user is logged out, action=purge shows a form instead of the article,
		// so return false in that case.
		&& !( mw.config.get( 'wgAction' ) == 'purge' && mw.user.anonymous() )
		// Current revision
		&& mw.util.getParamValue( 'diff' ) == null
		&& mw.util.getParamValue( 'oldid' ) == null
		// Not disabled via preferences
		&& !mw.user.options.get( 'articlefeedback-disable' )
		// Not viewing a redirect
		&& mw.util.getParamValue( 'redirect' ) != 'no'
		// Not viewing the printable version
		&& mw.util.getParamValue( 'printable' ) != 'yes'
	) {
		// Collect categories for intersection tests
		// Clone the arrays so we can safely modify them
		var categories = {
			'include': [].concat( mw.config.get( 'wgArticleFeedbackv5Categories', [] ) ),
			'exclude': [].concat( mw.config.get( 'wgArticleFeedbackv5BlacklistCategories', [] ) ),
			'current': [].concat( mw.config.get( 'wgCategories', [] ) )
		};

		var enable = false;
		for( var i = 0; i < categories['current'].length; i++ ) {
			// Categories are configured with underscores, but article's categories are returned with
			// spaces instead. Revert to underscores here for sane comparison.
			categories['current'][i] = categories['current'][i].replace(/\s/gi, '_');
			// Check exclusion - exclusion overrides everything else
			if( $.inArray( categories['current'][i], categories.exclude ) > -1 ) {
				// Blacklist overrides everything else
				return;
			}
			if( $.inArray( categories['current'][i], categories.include ) > -1 ) {
				// One match is enough for include, however we are iterating on the 'current'
				// categories, and others might be blacklisted - so continue iterating
				enable = true;
			}
		}

		// Lazy loading
		if ( enable ) {
			mw.loader.load( 'ext.articleFeedbackv5' );
			// Load the IE-specific module
			if( navigator.appVersion.indexOf( 'MSIE 7' ) != -1 ) {
				mw.loader.load( 'ext.articleFeedbackv5.ie' );
			}
		}
	}
} );
