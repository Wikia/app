( function( mw, $ ) {
	/** 
	 * Merge in the default video attributes supported by embedPlayer:
	 */
	mw.mergeConfig( 'EmbedPlayer.Attributes', {
		// A apiTitleKey for looking up subtitles, credits and related videos
		"data-mwtitle" : null,
	
		// The apiProvider where to lookup the title key
		"data-mwprovider" : null
	});
	
	// Add mediaWiki player support to target embedPlayer 
	$( mw ).bind( 'newEmbedPlayerEvent', function( event, embedPlayer ){
		mw.addMediaWikiPlayerSupport( embedPlayer );
	});
	
	/**
	 * Closure function wraps mediaWiki embedPlayer bindings
	 */
	mw.addMediaWikiPlayerSupport = function( embedPlayer ){
		// Set some local variables: 
		if( ! embedPlayer['data-mwtitle'] ){			
			return false;
		} else {
			var apiTitleKey = embedPlayer['data-mwtitle'];
			// legacy support ( set as attribute ) 
			embedPlayer.apiTitleKey = apiTitleKey;
		}
		// Set local apiProvider via config if not defined
		var apiProvider = embedPlayer['data-mwprovider'];
		if( !apiProvider ){
			apiProvider = mw.getConfig( 'EmbedPlayer.ApiProvider' );
		}
		
		/**
		 * Loads mediaWiki sources for a given embedPlayer
		 * @param {function} callback Function called once player sources have been added 
		 */
		function loadPlayerSources( callback ){
			// Setup the request
			var request = {
				'prop': 'imageinfo',
				// In case the user added File: or Image: to the apiKey:
				'titles': 'File:' + unescape( apiTitleKey ).replace( /^(File:|Image:)/ , '' ),
				'iiprop': 'url|size|dimensions|metadata',
				'iiurlwidth': embedPlayer.getWidth(),
				'redirects' : true // automatically resolve redirects
			};

			// Run the request:
			mw.getJSON( mw.getApiProviderURL( apiProvider ), request, function( data ){
				if ( data.query.pages ) {
					for ( var i in data.query.pages ) {
						if( i == '-1' ) {
							callback( false );
							return ;
						}
						var page = data.query.pages[i];
					}
				} else {
					callback( false );
					return ;
				}
				// Make sure we have imageinfo:
				if( ! page.imageinfo || !page.imageinfo[0] ){
					callback( false );
					return ;
				}
				var imageinfo = page.imageinfo[0];
				
				// TODO these should call public methods rather than update internals: 
				
				// Update the poster
				embedPlayer.poster = imageinfo.thumburl;

				// Add the media src
				embedPlayer.mediaElement.tryAddSource(
					$('<source />')
					.attr( 'src', imageinfo.url )
					.get( 0 )
				);

				// Set the duration
				if( imageinfo.metadata[2]['name'] == 'length' ) {
					embedPlayer.duration = imageinfo.metadata[2]['value'];
				}

				// Set the width height
				// Make sure we have an accurate aspect ratio
				if( imageinfo.height != 0 && imageinfo.width != 0 ) {
					embedPlayer.height = parseInt( embedPlayer.width * ( imageinfo.height / imageinfo.width ) );
				}

				// Update the css for the player interface
				$( embedPlayer ).css( 'height', embedPlayer.height);

				callback();
			});
		}
	

		/**
		* Build a clip credit from the resource wikiText page
		*
		* TODO parse the resource page template
		*
		* @param {String} resourceHTML Resource wiki text page contents
		*/
		function doCreditLine( resourceHTML, articleUrl ){
			// Get the title string ( again a "Title" like js object could help out here. ) 		
			var titleStr = embedPlayer.apiTitleKey.replace(/_/g, ' ');
			
			// Setup the initial credits line:
			var $creditLine = $( '<div />');		
			
			// Add the title: 
			$creditLine.append(
				$('<span>').html(
					gM( 'mwe-embedplayer-credit-title' ,
						// We use a div container to easily get at the built out link
						$('<div>').append(
							$('<a/>').attr({
								'href' : articleUrl,
								'title' : titleStr
							})
							.text( titleStr )							
						).html()
					)
				)
			);
			
			// Parse some data from the page info template if possible: 			
			var $page = $( resourceHTML );
			
			// Look for author:
			var $author = $page.find('#fileinfotpl_aut');
			if( $author.length ){
				// Get the real author sibling of fileinfotpl_aut 
				$author = $author.next().find('p');
				// Remove white space:
				$author.find('br').remove();
				
				// Update link to be absolute per page url context: 
				var $links = $author.find('a');
				if( $links.length ) {
					var authUrl = $author.find('a').attr('href');
					authUrl = mw.absoluteUrl( authUrl,  articleUrl );
					$author.find('a').attr('href', 
						authUrl
					)
				}
				$creditLine.append( $( '<br />' ),
					gM('mwe-embedplayer-credit-author', $author.html() )
				)
			}
			
			// Look for date:
			var $date =$page.find('#fileinfotpl_date');
			if( $date.length ){
				// Get the real date sibling of fileinfotpl_date 
				$date = $date.next().find('p');
				
				// remove white space:
				$date.find('br').remove();
				$creditLine.append(  $( '<br />' ),
					gM('mwe-embedplayer-credit-date', $date.html() )
				)
			}
			

			// Build out the image and credit line
			var imgWidth = ( embedPlayer.controlBuilder.getOverlayWidth() < 250 )? 45 : 120;
			return $( '<div/>' ).addClass( 'creditline' )
				.append(
					$('<a/>').attr({
						'href' : articleUrl,
						'title' : titleStr
					}).html(
						$('<img/>').attr( {
							'border': 0,
							'src' : embedPlayer.poster
						} ).css( {
							'width' : imgWidth
						} )
					)
				)
				.append(
					$creditLine
				);
		};
		
		/**
		 * Issues a request to populate the credits box
		 */
		var $creditsCache = false;
		function showCredits( $target, callback ){
			if( $creditsCache ){
				$target.html( $creditsCache );
				callback( true );
				return;
			}
			// Setup shortcuts:
			var apiUrl = mw.getApiProviderURL( apiProvider );
			var fileTitle = 'File:' + unescape( apiTitleKey).replace(/^File:|^Image:/, '');
			
			// Get the image page ( cache for 1 hour )
			var request = {
				'action': 'parse',
				'page': fileTitle,
				'smaxage' : 3600,
				'maxage' : 3600
			};
			var articleUrl = '';
			mw.getJSON( apiUrl, request, function( data ){
				descUrl = apiUrl.replace( 'api.php', 'index.php');
				descUrl+= '?title=' + fileTitle;
				if ( data && data.parse && data.parse.text && data.parse.text['*'] ) {
					// TODO improve provider 'concept' to support page title link 
					$creditsCache = doCreditLine( data.parse.text['*'], descUrl );
				} else {
					$creditsCache = doCreditLine( false, descUrl)
				}
				$target.html( $creditsCache );
				callback( true );
			} );
		};
		/**
		 * Adds embedPlayer Bindings
		 */				
		// Show credits when requested
		$( embedPlayer ).bind('ShowCredits', function( event, $target, callback){
			// Only request the credits once: 
			showCredits( $target, callback);			
		});
				
		$( embedPlayer ).bind( 'checkPlayerSourcesEvent', function(event, callback){
			// Only load source if none are available:
			if( embedPlayer.mediaElement.sources.length == 0 ){
				loadPlayerSources( callback );
			} else {
				// No source to load, issue callback directly
				callback();
			}
		});
		
		$( embedPlayer ).bind( 'GetShareIframeSrc', function(event, callback){
			// Check the embedPlayer title key: 
			var title =  $( embedPlayer).attr( 'data-mwtitle');
			// TODO Check the provider key and use that hosts title page entry point!
			var provider =  $( embedPlayer).attr( 'data-mwprovider');
			
			var iframeUrl = false;
			if( mw.getConfig('wgServer') && mw.getConfig('wgArticlePath') ){
				iframeUrl =  mw.getConfig('wgServer') + 
					mw.getConfig('wgArticlePath').replace( /\$1/, 'File:' + 
						unescape( embedPlayer.apiTitleKey ).replace( /^(File:|Image:)/ , '' ) ) +
					'?' + 'embedplayer=yes';
			}
			callback( iframeUrl );
		});
	};
		
} )( window.mediaWiki, window.jQuery );
