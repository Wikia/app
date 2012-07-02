/**
 * JavasSript for the IncludeWP  extension.
 * @see http://www.mediawiki.org/wiki/Extension:Push
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function($) { $( document ).ready( function() {
	
	// Compatibility with pre-RL code.
	// Messages will have been loaded into wgPushMessages.
	if ( typeof mediaWiki === 'undefined' ) {
		mediaWiki = new Object();
		
		mediaWiki.msg = function() {
			message = window.wgIncWPMessages[arguments[0]];
			
			for ( var i = arguments.length - 1; i > 0; i-- ) {
				message = message.replace( '$' + i, arguments[i] );
			}
			
			return message;
		}
	}
	
	// Variable to store the HTML of rendered pages in.
	var pages = {};
	
	// Find all inclusion requests and obtain the wikitext from the remote wiki.
	$.each($(".includewp-loading"), function(i,v) {
		loadPage( $(v) );
	});		
	
	/**
	 * Make a JSONP call to the remote wiki to obtain the page wikitext.
	 * 
	 * @param jQuery sender
	 */
	function loadPage( sender ) {
		$.getJSON(
			window.wgIncWPWikis[sender.attr( 'wiki' )].path + '/api.php?callback=?',
			{
				'action': 'query',
				'format': 'json',
				'prop': 'revisions',
				'rvprop':'timestamp|content',
				'titles': sender.attr( 'page' ),
				'redirects': 1
			},
			function( data ) {
				if ( data.query ) {
					for ( pageWikiID in data.query.pages ) {
						getPlaintext( sender, data.query.pages[pageWikiID].revisions[0]["*"] );
						break;
					}
				}
				else {
					sender.html( '<b>' + mediaWiki.msg( 'includewp-loading-failed' ) + '</b>' );
				}
			}
		);		
	}
	
	/**
	 * Send the obtained wikitext to the local API to strip out stuff we
	 * don't want (such as external links and infoboxes), and parse the
	 * remainder to HTML. 
	 * 
	 * @param jQuery sender
	 * @param string rawWikiText
	 */
	function getPlaintext( sender, rawWikiText ) {
		var pageId = sender.attr( 'pageid' );
		var pageName = sender.attr( 'page' );
		
		$.post(
			wgScriptPath + '/api.php',
			{
				'action': 'includewp',
				'format': 'json',
				'text': rawWikiText,
				'pagename': pageName
			},
			function( data ) {
				var plainText = data.shift();
				if ( plainText ) {
					sender.slideUp( 'slow' );
					pages[pageName] = plainText;
					showPageFragment( pageName, pageId );
					showCopyright( pageName, pageId );
				}
				else {
					sender.html( '<b>' + mediaWiki.msg( 'includewp-loading-failed' ) + '</b>' );
				}
			},
			'json'
		);
	}
	
	/**
	 * Show a fragment (number of paragraphes) of the text, and display a link
	 * that will show the full page.
	 * 
	 * @param string pageName
	 * @param integer pageId
	 */
	function showPageFragment( pageName, pageId ) {
		var paragraphs = getPageParagraphs( pageName, $( '#includewp-loading-' + pageId ).attr( 'paragraphs' ) );
		
		$( '#includewp-article-' + pageId ).html( paragraphs === false ? pages[pageName] : paragraphs );
		
		// Remove any possible TOC, as we don't want it to show up for page fragments.
		$('.toc').remove();
		
		if ( paragraphs !== false ) {
			$( '#includewp-article-' + pageId ).append( $( '<a />' ).text( mediaWiki.msg( 'includewp-show-full-page' ) )
				.addClass( 'incwp-more' ).attr( 'href', '#' ).click( function() { showFullPage( pageName, pageId ) } ) );
		}
	}
	
	/**
	 * Returns the text of the first x paragraphes.
	 * 
	 * @param string pageName
	 * @param integer paragraphAmount
	 * 
	 * @return string
	 */
	function getPageParagraphs( pageName, paragraphAmount ) {
		var textSize = 0;
		var pSize = 4;
		
		while ( paragraphAmount-- > 0 ) {
			var paragraphEnd = pages[pageName].substr( textSize ).search( '</p>' );
			
			if ( paragraphEnd == -1 ) {
				return false;
			}
			
			textSize += paragraphEnd + pSize;
		}

		return pages[pageName].substr( 0, textSize );
	}

	/**
	 * Show the full page, and a link to only show the fragment.
	 * 
	 * @param string pageName
	 * @param integer pageId
	 */	
	function showFullPage( pageName, pageId ) {
		$( '#includewp-article-' + pageId ).html( pages[pageName] )
			.append( $( '<a />' ).text( mediaWiki.msg( 'includewp-show-fragment' ) )
				.addClass( 'incwp-less' ).attr( 'href', '#' ).click( function() { showPageFragment( pageName, pageId ) } ) );		
	}
	
	/**
	 * Adds a copyright disclaimer underneat the actual article.
	 * 
	 * @param string pageName
	 * @param integer pageId
	 */
	function showCopyright( pageName, pageId ) {
		var wiki = window.wgIncWPWikis[$( '#includewp-loading-' + pageId ).attr( 'wiki' )];
		
		var licenceHtml = mediaWiki.msg(
				'includewp-licence-notice',
				wiki.name,
				wiki.url + '/' + pageName,
				pageName,
				wiki.licenceurl,
				wiki.licencename,
				wiki.url + '/' + pageName + '?action=history'
		);
		
		$( '#includewp-copyright-' + pageId ).html( licenceHtml );
	}
	
} ); })(jQuery);