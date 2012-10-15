/*
 * Script for Article Feedback Extension
 */
( function( $ ) {

/* Load at the bottom of the article */
var $aftDiv = $( '<div id="mw-articlefeedbackv5"></div>' ).articleFeedbackv5();

// Put on bottom of article before #catlinks (if it exists)
// Except in legacy skins, which have #catlinks above the article but inside content-div.
var legacyskins = [ 'standard', 'cologneblue', 'nostalgia' ];
if ( $( '#catlinks' ).length && $.inArray( mw.config.get( 'skin' ), legacyskins ) < 0 ) {
	$aftDiv.insertBefore( '#catlinks' );
} else {
	// CologneBlue, Nostalgia, ...
	mw.util.$content.append( $aftDiv );
}

/* Add basic edit tracking */
if ( $aftDiv.articleFeedbackv5( 'clickTrackingOn' ) ) {
	var clickTrackingSession = $.cookie( 'clicktracking-session' );
	var editEventBase = $aftDiv.articleFeedbackv5( 'prefix', $aftDiv.articleFeedbackv5( 'bucketName' ) );
	$( 'span.editsection a, #ca-edit a' ).each( function() {
		var event = editEventBase;
		if ( $(this).is( '#ca-edit a' ) ) {
			event += '-edit_tab_link';
		} else {
			event += '-section_edit_link';
		}
		var href = $( this ).attr( 'href' );
		var editUrl = href + ( href.indexOf( '?' ) >= 0 ? '&' : '?' ) + $.param( {
			'articleFeedbackv5_click_tracking': 1,
			'articleFeedbackv5_ct_token': clickTrackingSession,
			'articleFeedbackv5_ct_event': event
		} );
		$(this).attr( 'href', $.trackActionURL( editUrl, event + '-click' ) );
	} );
}

/* Setup for feedback links */

// Click event
var clickFeedbackLink = function ( $link ) {
	var tracking_id = $aftDiv.articleFeedbackv5( 'bucketName' ) +
		'-trigger' + $link.data( 'linkId' ) +
		'-click-overlay';
	$aftDiv.articleFeedbackv5( 'trackClick', tracking_id );
	$aftDiv.articleFeedbackv5( 'toggleModal', $link );
};

// Bucketing
var linkBucket = function () {
	// Find out which link bucket they go in:
	// 1. Display buckets 0 or 5?  Always no link.
	// 2. Requested in query string (debug only)
	// 3. Random bucketing
	var displayBucket = $aftDiv.articleFeedbackv5( 'getBucketId' );
	if ( '5' == displayBucket || '0' == displayBucket ) {
		return '-';
	}
	var cfg = mw.config.get( 'wgArticleFeedbackv5LinkBuckets' );
	if ( !( 'buckets' in cfg ) ) {
		return '-';
	}
	var knownBuckets = cfg.buckets;
	var requested = mw.util.getParamValue( 'aftv5_link' );
	if ( $aftDiv.articleFeedbackv5( 'inDebug' ) && requested in knownBuckets ) {
		return requested;
	}
	return mw.user.bucket( 'ext.articleFeedbackv5-links', cfg );
}();
if ( $aftDiv.articleFeedbackv5( 'inDebug' ) ) {
	aft5_debug( 'Using link option ' + linkBucket );
}

// A: After the site tagline (below the article title)
if ( 'A' == linkBucket ) {
	var $sub = $( '<a href="#mw-articleFeedbackv5" id="articleFeedbackv5-sitesublink"></a>' )
		.data( 'linkId', 'A' )
		.text( mw.msg( 'articlefeedbackv5-sitesub-linktext' ) )
		.click( function ( e ) {
			e.preventDefault();
			clickFeedbackLink( $( e.target ) );
		} )
	// The link is going to be at different markup locations on different skins,
	// and it needs to show up if the site subhead (e.g., "From Wikipedia, the free
	// encyclopedia") is not visible for any reason.
	if ( $( '#siteSub' ).filter( ':visible' ).length ) {
		$( '#siteSub' ).append( ' ' ).append( $sub );
	} else if ( $( 'h1.pagetitle + p.subtitle' ).filter( ':visible' ).length ) {
		$( 'h1.pagetitle + p.subtitle' ).append( ' ' ).append( $sub );
	} else if ( $( '#mw_contentholder .mw-topboxes' ).length ) {
		$( '#mw_contentholder .mw-topboxes' ).after( $sub );
	} else if ( $( '#bodyContent' ).length ) {
		$( '#bodyContent' ).prepend( $sub );
	}
	$aftDiv.articleFeedbackv5( 'addToRemovalQueue', $sub );
}

// B: Below the titlebar on the right
if ( 'B' == linkBucket ) {
	var $tlk = $( '<a href="#mw-articleFeedbackv5" id="articleFeedbackv5-titlebarlink"></a>' )
		.data( 'linkId', 'B' )
		.text( mw.msg( 'articlefeedbackv5-titlebar-linktext' ) )
		.click( function ( e ) {
			e.preventDefault();
			clickFeedbackLink( $( e.target ) );
		} );
	if ( $( '#coordinates' ).length ) {
		$tlk.css( 'margin-top: 2.5em' );
	}
	$tlk.insertBefore( $aftDiv );
	$aftDiv.articleFeedbackv5( 'addToRemovalQueue', $tlk );
}

// C: Button fixed to right side
if ( 'C' == linkBucket ) {
	var $fixedTab = $( '\
		<div id="articleFeedbackv5-fixedtab" class="articleFeedbackv5-fixedtab">\
			<div id="articleFeedbackv5-fixedtabbox" class="articleFeedbackv5-fixedtabbox">\
				<a href="#mw-articleFeedbackv5" id="articleFeedbackv5-fixedtablink" class="articleFeedbackv5-fixedtablink"></a>\
			</div>\
		</div>' );
	$fixedTab.find( '#articleFeedbackv5-fixedtablink' )
		.data( 'linkId', 'C' )
		.attr( 'title', mw.msg( 'articlefeedbackv5-fixedtab-linktext' ) )
		.click( function( e ) {
			e.preventDefault();
			clickFeedbackLink( $( e.target ) );
		} );
	$fixedTab.insertBefore( $aftDiv );
	$aftDiv.articleFeedbackv5( 'addToRemovalQueue', $fixedTab );
}

// D: Button fixed to bottom right
if ( 'D' == linkBucket ) {
	var $bottomRightTab = $( '\
		<div id="articleFeedbackv5-bottomrighttab" class="articleFeedbackv5-bottomrighttab">\
			<div id="articleFeedbackv5-bottomrighttabbox" class="articleFeedbackv5-bottomrighttabbox">\
				<a href="#mw-articleFeedbackv5" id="articleFeedbackv5-bottomrighttablink" class="articleFeedbackv5-bottomrighttablink"></a>\
			</div>\
		</div>' );
	$bottomRightTab.find( '#articleFeedbackv5-bottomrighttablink' )
		.data( 'linkId', 'D' )
		.text( mw.msg( 'articlefeedbackv5-bottomrighttab-linktext' ) )
		.click( function( e ) {
			e.preventDefault();
			clickFeedbackLink( $( e.target ) );
		} );
	$bottomRightTab.insertBefore( $aftDiv );
	$aftDiv.articleFeedbackv5( 'addToRemovalQueue', $bottomRightTab );
}

// E: Button fixed to bottom center
// NOT IMPLEMENTED

// F: Button fixed to left side
// NOT IMPLEMENTED

// G: Button below logo
// NOT IMPLEMENTED

// H: Link on each section bar
if ( 'H' == linkBucket ) {
	var $wrp = $( '<span class="articleFeedbackv5-sectionlink-wrap"></span>' )
		.html( '&nbsp;[<a href="#mw-articlefeedbackv5" class="articleFeedbackv5-sectionlink"></a>]' );
	$wrp.find( 'a.articleFeedbackv5-sectionlink' )
		.data( 'linkId', 'H' )
		.text( mw.msg( 'articlefeedbackv5-section-linktext' ) )
		.click( function ( e ) {
			e.preventDefault();
			clickFeedbackLink( $( e.target ) );
		} );
	$( 'span.editsection' ).append( $wrp );
	$aftDiv.articleFeedbackv5( 'addToRemovalQueue', $wrp );
}

// Add toolbox link
if ( '5' == $aftDiv.articleFeedbackv5( 'getBucketId' ) ) {
	var $tbx = $( '<li id="t-articlefeedbackv5"><a href="#mw-articlefeedbackv5"></a></li>' )
		.find( 'a' )
			.text( mw.msg( 'articlefeedbackv5-bucket5-toolbox-linktext' ) )
			.click( function ( e ) {
				// Just set the link ID -- this should act just like AFTv4
				$aftDiv.articleFeedbackv5( 'setLinkId', 'TBX' );
			} )
		.end();
	$( '#p-tb' ).find( 'ul' ).append( $tbx );
} else {
	var $tbx = $( '<li id="t-articlefeedbackv5"><a href="#mw-articlefeedbackv5"></a></li>' )
		.find( 'a' )
			.text( mw.msg( 'articlefeedbackv5-toolbox-linktext' ) )
			.data( 'linkId', 'TBX' )
			.click( function ( e ) {
				e.preventDefault();
				clickFeedbackLink( $( e.target ) );
			} )
		.end();
	$( '#p-tb' ).find( 'ul' ).append( $tbx );
	$aftDiv.articleFeedbackv5( 'addToRemovalQueue', $tbx );
}

} )( jQuery );
