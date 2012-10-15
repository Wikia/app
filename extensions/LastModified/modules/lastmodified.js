/**
 * Wikimedia Foundation
 *
 * LICENSE
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * @author		Katie Horn <khorn@wikimedia.org>, Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/**
 * Run the last modified helper.
 *
 * This is the primary function for this script.
 *
 */
function extensionsLastModified() {

	// Get the last-modified-timestamp value
	var lastModifiedTimestamp = extensionsLastModifiedGetMetaLastModifiedTimestamp();
	//console.log( 'lastModifiedTimestamp: ' + lastModifiedTimestamp );

	// Get the last-modified-range value
	var displayRange = extensionsLastModifiedGetMetaRange();
	//console.log( 'displayRange: ' + displayRange );
	
	// Get the current timestamp and remove the milliseconds
	var nowStamp = extensionsLastModifiedGetUtcTimeStamp();
	//console.log( 'nowStamp: ' + nowStamp );

	// Get the difference in the time from when it was last edited.
	var modifiedDifference = nowStamp - lastModifiedTimestamp;
	//console.log( 'modifiedDifference: ' + modifiedDifference );

	// Get the last modified text
	var lastModifiedText = extensionsLastModifiedGetLastModifiedText( modifiedDifference, displayRange );
	//console.log( 'lastModifiedText: ' + lastModifiedText );
	
	// Insert the text on the web page
	extensionsLastModifiedInsertHtml( lastModifiedText );
}
/**
 * Get the UTC Timestamp without microseconds
 *
 * @return integer
 */
function extensionsLastModifiedGetUtcTimeStamp() {
	
	// Get the current Date object
	var now = new Date();
	//console.log( 'now: ' + now );
	
	return parseInt( now.getTime() / 1000 );
}

/**
 * Get the article history link
 *
 * @return string	Return the article title
 */
function extensionsLastModifiedGetArticleHistoryLink() {

	var href = $(location).attr('href');

	var query = '';
	
	if (href.indexOf('?') == -1) {
		query += '?';
	}
	else {
		query += '&amp;';
	}

	query += 'action=history';
	
	//console.log( 'href: ' + href );
	
	return href + query;
}

/**
 * Get the value from the meta tag: last-modified-timestamp
 *
 * @return integer
 */
function extensionsLastModifiedGetMetaLastModifiedTimestamp() {
	
	// Fetch the meta tag
	var metaTag = $("meta[name=last-modified-timestamp]");    

	// If the tag was found, parse the value
	if ( metaTag ) {
		
		return parseInt( metaTag.attr( 'content' ) );
	}
	
	return 0;
}

/**
 * Get the modified text. This takes advantage of internationalization.
 *
 * @param integer	modifiedDifference	The difference of time from now compared to last edited
 * @param integer	displayRange		The maximum unit of time to display for last updated
 *
 * displayRange
 * - 0: years	- display: years, months, days, hours, minutes, seconds  
 * - 1: months 	- display: months, days, hours, minutes, seconds  
 * - 2: days	- display: days, hours, minutes, seconds  
 * - 3: hours	- display: hours, minutes, seconds  
 * - 4: minutes	- display: minutes, seconds  
 * - 5: seconds	- display: seconds  
 *
 * @return string
 */
function extensionsLastModifiedGetLastModifiedText( modifiedDifference, displayRange ) {

	// Message to return
	var message = '';
	var myLastEdit = modifiedDifference;
	
	if ( modifiedDifference < 60 ) {

		// seconds
		message = ( mw.msg( 'lastmodified-seconds',  myLastEdit ) );
		
	}
	else if ( modifiedDifference < 3600 ) {

		// minutes
		if ( displayRange <= 4 ) {
			myLastEdit = parseInt( modifiedDifference / 60 );
			message = ( mw.msg( 'lastmodified-minutes', myLastEdit ) );
		}
		
	}
	else if ( modifiedDifference < 86400 ) {

		// hours
		if ( displayRange <= 3) {
			myLastEdit = parseInt( modifiedDifference / 3600 );
			message = ( mw.msg( 'lastmodified-hours', myLastEdit ) );
		}		
	}
	else if ( modifiedDifference < 2592000 ) {
		
		// days
		if ( displayRange <= 2) {
			myLastEdit = parseInt( modifiedDifference / 86400 );
			message = ( mw.msg( 'lastmodified-days', myLastEdit ) );
		}
		
	}
	else if ( modifiedDifference < 31536000 ) {

		// months
		if ( displayRange <= 1) {
			myLastEdit = parseInt( modifiedDifference / 2592000 );
			message = ( mw.msg( 'lastmodified-months', myLastEdit ) );
		}
	}
	else {

		// years
		if ( displayRange == 0) {
			myLastEdit = parseInt( modifiedDifference / 31536000 );
			message = ( mw.msg( 'lastmodified-years', myLastEdit ) );
		}		
	}
	
	return message;
}

/**
 * Get the value from the meta tag: last-modified-range
 *
 * @return integer
 */
function extensionsLastModifiedGetMetaRange() {

	// Fetch the meta tag
	var metaTag = $("meta[name=last-modified-range]");    

	// If the tag was found, parse the value
	if ( metaTag ) {
		
		return parseInt( metaTag.attr( 'content' ) );
	}
	
	return 0;
}

/**
 * Insert the last modified text with jQuery
 *
 * @param string	lastModifiedText	The string of text to display in the container.
 */
function extensionsLastModifiedInsertHtml( lastModifiedText ) {

	//http://en.wikipedia.org/w/index.php?title=San_Francisco&action=history
	
	// Get the article history link
	var historyLink = extensionsLastModifiedGetArticleHistoryLink();
	//console.log( 'historyLink: ' + historyLink );

	var html = '';
	
	html += '<div style="float: right; position: absolute; right: 10px; font-size: 85%;" class="lastmodified">';
	html += '<a href="' + historyLink + '" title="' + mw.msg( 'lastmodified-title-tag' ) + '">';
	html += lastModifiedText;
	html += '</a>';
	html += '</div>';
	
	$('#content').prepend( html );
}

/**
 * Display the last modified link on the page.
 *
 */
$(document).ready(function(){
	extensionsLastModified();	
});

