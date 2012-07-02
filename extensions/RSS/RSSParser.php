<?php

class RSSParser {
	protected $maxheads = 32;
	protected $reversed = false;
	protected $highlight = array();
	protected $filter = array();
	protected $filterOut = array();
	protected $itemTemplate;
	protected $url;
	protected $etag;
	protected $lastModified;
	protected $xml;
	protected $error;
	protected $displayFields = array( 'author', 'title', 'encodedContent', 'description' );

	/**
	 * @var RSSData
	 */
	public $rss;

	public $client;

	/**
	 * Convenience function that takes a space-separated string and returns an array of words
	 * @param $str String: list of words
	 * @return Array words found
	 */
	private static function explodeOnSpaces( $str ) {
		$found = preg_split( '# +#', $str );
		return is_array( $found ) ? $found : array();
	}

	/**
	 * Take a bit of WikiText that looks like
	 *   <rss max=5>http://example.com/</rss>
	 * and return an object that can produce rendered output.
	 */
	function __construct( $url, $args ) {
		$this->url = $url;

		# Get max number of headlines from argument-array
		if ( isset( $args['max'] ) ) {
			$this->maxheads = $args['max'];
		}

		# Get reverse flag from argument array
		if ( isset( $args['reverse'] ) ) {
			$this->reversed = true;
		}

		# Get date format from argument array
		# FIXME: not used yet
		if ( isset( $args['date'] ) ) {
			$this->date = $args['date'];
		}

		# Get highlight terms from argument array
		if ( isset( $args['highlight'] ) ) {
			# mapping to lowercase here so the regex can be case insensitive below.
			$this->highlight = self::explodeOnSpaces( $args['highlight'] );
		}

		# Get filter terms from argument array
		if ( isset( $args['filter'] ) ) {
			$this->filter = self::explodeOnSpaces( $args['filter'] );
		}

		if ( isset( $args['filterout'] ) ) {
			$this->filterOut = self::explodeOnSpaces( $args['filterout'] );
		}

		// 'template' is the pagename of a user's itemTemplate including
		// a further pagename for the feedTemplate
		// In that way everything is handled via these two pages
		// and no default pages or templates are used.
		
		// 'templatename' is an optional pagename of a user's feedTemplate
		// In that way it substitutes $1 (default: RSSPost) in MediaWiki:Rss-item

		if ( isset( $args['template'] ) ) {
			$itemTemplateTitleObject = Title::newFromText( $args['template'], NS_TEMPLATE );
			$itemTemplateArticleObject = new Article( $itemTemplateTitleObject, 0 );
			$this->itemTemplate = $itemTemplateArticleObject->fetchContent();
		} else {
			if ( isset( $args['templatename'] ) ) {
				$feedTemplatePagename = $args['templatename'];
			} else {

				// compatibility patch for rss extension
				
				$feedTemplatePagename = 'RSSPost';
				$feedTemplateTitleObject = Title::newFromText( $feedTemplatePagename, NS_TEMPLATE );

				if ( !$feedTemplateTitleObject->exists() ) {
					$feedTemplatePagename = Title::makeTitleSafe( NS_MEDIAWIKI, 'Rss-feed' );
				}
			}

			// MediaWiki:Rss-item = {{ feedTemplatePagename | title = {{{title}}} | ... }}

			// if the attribute parameter templatename= is not present
			// then it defaults to
			// {{ Template:RSSPost | title = {{{title}}} | ... }} - if Template:RSSPost exists from pre-1.9 versions
			// {{ MediaWiki:Rss-feed | title = {{{title}}} | ... }} - otherwise

			$this->itemTemplate = wfMsgNoTrans( 'rss-item', $feedTemplatePagename );

		}
	}

	/**
	 * Return RSS object for the given URL, maintaining caching.
	 *
	 * NOTES ON RETRIEVING REMOTE FILES:
	 * No attempt will be made to fetch remote files if there is something in cache.
	 *
	 * NOTES ON FAILED REQUESTS:
	 * If there is an HTTP error while fetching an RSS object, the cached version
	 * will be returned, if it exists.
	 *
	 * @return Status object
	 */
	function fetch() {
		if ( !isset( $this->url ) ) {
			return Status::newFatal( 'rss-fetch-nourl' );
		}

		// Flow
		// 1. check cache
		// 2. if there is a hit, make sure its fresh
		// 3. if cached obj fails freshness check, fetch remote
		// 4. if remote fails, return stale object, or error
		$key = wfMemcKey( 'rss', $this->url );
		$cachedFeed = $this->loadFromCache( $key );
		if ( $cachedFeed !== false ) {
			wfDebugLog( 'RSS', 'Outputting cached feed for ' . $this->url );
			return Status::newGood();
		}
		wfDebugLog( 'RSS', 'Cache Failed, fetching ' . $this->url . ' from remote.' );

		$status = $this->fetchRemote( $key );
		return $status;
	}

	/**
	 * Retrieve the URL from the cache
	 * @param $key String: lookup key to associate with this item
	 * @return boolean
	 */
	protected function loadFromCache( $key ) {
		global $wgMemc, $wgRSSCacheCompare;

		$data = $wgMemc->get( $key );
		if ( !is_array( $data ) ) {
			return false;
		}

		list( $etag, $lastModified, $rss ) =
			$data;

		if ( !isset( $rss->items ) ) {
			return false;
		}

		wfDebugLog( 'RSS', "Got '$key' from cache" );

		# Now that we've verified that we got useful data, keep it around.
		$this->rss = $rss;
		$this->etag = $etag;
		$this->lastModified = $lastModified;

		// We only care if $wgRSSCacheCompare is > 0
		if ( $wgRSSCacheCompare && time() - $wgRSSCacheCompare > $lastModified ) {
			wfDebugLog( 'RSS', 'Content is old enough that we need to check cached content' );
			return false;
		}

		return true;
	}

	/**
	 * Store these objects (i.e. etag, lastModified, and RSS) in the cache.
	 * @param $key String: lookup key to associate with this item
	 * @return boolean
	 */
	protected function storeInCache( $key ) {
		global $wgMemc, $wgRSSCacheAge;

		if ( !isset( $this->rss ) ) {
			return false;
		}
		$r = $wgMemc->set( $key,
			array( $this->etag, $this->lastModified, $this->rss ),
			$wgRSSCacheAge );

		wfDebugLog( 'RSS', "Stored '$key' as in cache? $r");
		return true;
	}

	/**
	 * Retrieve a feed.
	 * @param $key String:
	 * @param $headers Array: headers to send along with the request
	 * @return Status object
	 */
	protected function fetchRemote( $key, array $headers = array()) {
		global $wgRSSFetchTimeout, $wgRSSUserAgent, $wgRSSProxy;

		if ( $this->etag ) {
			wfDebugLog( 'RSS', 'Used etag: ' . $this->etag );
			$headers['If-None-Match'] = $this->etag;
		}
		if ( $this->lastModified ) {
			$lm = gmdate( 'r', $this->lastModified );
			wfDebugLog( 'RSS', "Used last modified: $lm" );
			$headers['If-Modified-Since'] = $lm;
		}

		$client = HttpRequest::factory( $this->url, array( 
			'timeout' => $wgRSSFetchTimeout,
			'proxy' => $wgRSSProxy

		) );
		$client->setUserAgent( $wgRSSUserAgent );
		foreach ( $headers as $header => $value ) {
			$client->setHeader( $header, $value );
		}

		$fetch = $client->execute();
		$this->client = $client;

		if ( !$fetch->isGood() ) {
			wfDebug( 'RSS', 'Request Failed: ' . $fetch->getWikiText() );
			return $fetch;
		}

		$ret = $this->responseToXML( $key );
		return $ret;
	}

	/**
	 * Render the entire feed so that each item is passed to the
	 * template which the MediaWiki then displays.
	 *
	 * @param $parser the parser param to pass to recursiveTagParse()
	 * @param $frame the frame param to pass to recursiveTagParse()
	 */
	function renderFeed( $parser, $frame ) {
	
		$renderedFeed = '';
		
		if ( isset( $this->itemTemplate ) && isset( $parser ) && isset( $frame ) ) {
		
			$headcnt = 0;
			if ( $this->reversed ) {
				$this->rss->items = array_reverse( $this->rss->items );
			}

			foreach ( $this->rss->items as $item ) {
				if ( $this->maxheads > 0 && $headcnt >= $this->maxheads ) {
					continue;
				}

				if ( $this->canDisplay( $item ) ) {
					$renderedFeed .= $this->renderItem( $item ) . "\n";
					$headcnt++;
				}
			}

			$renderedFeed = $parser->recursiveTagParse( $renderedFeed, $frame );

        	}
        	
		return $renderedFeed;
	}

	/**
	 * Render each item, filtering it out if necessary, applying any highlighting.
	 *
	 * @param $item Array: an array produced by RSSData where keys are the names of the RSS elements
	 */
	protected function renderItem( $item ) {

		$renderedItem = $this->itemTemplate;

		// $info will only be an XML element name, so we're safe using it.
		// $item[$info] is handled by the XML parser --
		// and that means bad RSS with stuff like
		// <description><script>alert("hi")</script></description> will find its
		// rogue <script> tags neutered.

		foreach ( array_keys( $item ) as $info ) {
			if ( $info != 'link' ) {
				$txt = $this->highlightTerms( $this->escapeTemplateParameter( $item[ $info ] ) );
			} else {
				$txt = $this->sanitizeUrl( $item[ $info ] );
			}
			$renderedItem = str_replace( '{{{' . $info . '}}}', $txt, $renderedItem );
		}

		// nullify all remaining info items in the template
		// without a corresponding info in the current feed item

		$renderedItem = preg_replace( "!{{{[^}]+}}}!U", "", $renderedItem );

		return $renderedItem;
	}

	/**
	 * Sanitize a URL for inclusion in wikitext. Escapes characters that have 
	 * a special meaning in wikitext, replacing them with URL escape codes, so
	 * that arbitrary input can be included as a free or bracketed external
	 * link and both work and be safe.
	 */
	protected function sanitizeUrl( $url ) {
		# Remove control characters
		$url = preg_replace( '/[\000-\037\177]/', '', $url );
		# Escape other problematic characters
		$i = 0;
		$out = '';
		for ( $i = 0; $i < strlen( $url ); $i++ ) {
			$boringLength = strcspn( $url, '<>"[|]\ {', $i );
			if ( $boringLength ) {
				$out .= substr( $url, $i, $boringLength );
				$i += $boringLength;
			}
			if ( $i < strlen( $url ) ) {
				$out .= rawurlencode( $url[$i] );
			}
		}
		return $out;
	}

	/**
	 * Sanitize user input for inclusion as a template parameter.
	 * Unlike in wfEscapeWikiText() as of r77127, this escapes }} in addition
	 * to the other kinds of markup, to avoid user input ending a template 
	 * invocation.
	 */
	protected function escapeTemplateParameter( $text ) {
		return str_replace(
			array( '[',     '|',      ']',     '\'',    'ISBN ',     
				'RFC ',     '://',     "\n=",     '{{',           '}}' ),
			array( '&#91;', '&#124;', '&#93;', '&#39;', 'ISBN&#32;', 
				'RFC&#32;', '&#58;//', "\n&#61;", '&#123;&#123;', '&#125;&#125;' ),
			htmlspecialchars( $text )
		);
	}

	/**
	 * Parse an HTTP response object into an array of relevant RSS data
	 *
	 * @param $key String: the key to use to store the parsed response in the cache
	 * @return parsed RSS object (see RSSParse) or false
	 */
	protected function responseToXML( $key ) {
		wfDebugLog( 'RSS', "Got '" . $this->client->getStatus() . "', updating cache for $key" );
		if ( $this->client->getStatus() === 304 ) {
			# Not modified, update cache
			wfDebugLog( 'RSS', "Got 304, updating cache for $key" );
			$this->storeInCache( $key );
		} else {
			$this->xml = new DOMDocument;
			$raw_xml = $this->client->getContent();

			if( $raw_xml == '' ) {
				return Status::newFatal( 'rss-parse-error', 'No XML content' );
			}

			wfSuppressWarnings();
			$this->xml->loadXML( $raw_xml );
			wfRestoreWarnings();

			$this->rss = new RSSData( $this->xml );

			// if RSS parsed successfully
			if ( $this->rss && !$this->rss->error ) {
				$this->etag = $this->client->getResponseHeader( 'Etag' );
				$this->lastModified =
					strtotime( $this->client->getResponseHeader( 'Last-Modified' ) );

				wfDebugLog( 'RSS', 'Stored etag (' . $this->etag . ') and Last-Modified (' .
					$this->client->getResponseHeader( 'Last-Modified' ) . ') and items (' .
					count( $this->rss->items ) . ')!' );
				$this->storeInCache( $key );
			} else {
				return Status::newFatal( 'rss-parse-error', $this->rss->error );
			}
		}
		return Status::newGood();
	}

	/**
	 * Determine if a given item should or should not be displayed
	 *
	 * @param $item Array: associative array that RSSData produced for an <item>
	 * @return boolean
	 */
	protected function canDisplay( array $item ) {
		$check = '';

		/* We're only going to check the displayable fields */
		foreach ( $this->displayFields as $field ) {
			if ( isset( $item[$field] ) ) {
				$check .= $item[$field];
			}
		}

		if ( $this->filter( $check, 'filterOut' ) ) {
			return false;
		}
		if ( $this->filter( $check, 'filter' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Filters items in or out if the match a string we're looking for.
	 *
	 * @param $text String: the text to examine
	 * @param $filterType String: "filterOut" to check for matches in the
	 * 								filterOut member list.
	 *								Otherwise, uses the filter member list.
	 * @return Boolean: decision to filter or not.
	 */
	protected function filter( $text, $filterType ) {
		if ( $filterType === 'filterOut' ) {
			$filter = $this->filterOut;
		} else {
			$filter = $this->filter;
		}

		if ( count( $filter ) == 0 ) {
			return $filterType !== 'filterOut';
		}

		/* Using : for delimiter here since it'll be quoted automatically. */
		$match = preg_match( ':(' . implode( '|', array_map( 'preg_quote', $filter ) ) . '):i', $text ) ;
		if ( $match ) {
			return true;
		}
		return false;
	}

	/**
	 * Highlight the words we're supposed to be looking for
	 *
	 * @param $text String: the text to look in.
	 * @return String with matched text highlighted in a <span> element
	 */
	protected function highlightTerms( $text ) {
		if ( count( $this->highlight ) === 0 ) {
			return $text;
		}

		RSSHighlighter::setTerms( $this->highlight );
		$highlight = ':'. implode( '|', array_map( 'preg_quote', array_values( $this->highlight ) ) ) . ':i';
		return preg_replace_callback( $highlight, 'RSSHighlighter::highlightThis', $text );
	}
}


class RSSHighlighter {
	static $terms = array();

	/**
	 * Set the list of terms to match for the next highlighting session
	 * @param $terms Array: list of words to match.
	 */
	static function setTerms( array $terms ) {
		self::$terms = array_flip( array_map( 'strtolower', $terms ) );
	}

	/**
	 * Actually replace the supplied list of words with HTML code to highlight the words.
	 * @param $match Array: list of matched words to highlight.
	 * 						The words are assigned colors based upon the order
	 * 						they were supplied in setTerms()
	 * @return String word wrapped in HTML code.
	 */
	static function highlightThis( $match ) {
		$styleStart = "<span style='font-weight: bold; background: none repeat scroll 0%% 0%% rgb(%s); color: %s;'>";
		$styleEnd   = '</span>';

		# bg colors cribbed from Google's highlighting of search terms
		$bgcolor = array( '255, 255, 102', '160, 255, 255', '153, 255, 153',
			'255, 153, 153', '255, 102, 255', '136, 0, 0', '0, 170, 0', '136, 104, 0',
			'0, 70, 153', '153, 0, 153' );
		# Spelling out the fg colors instead of using processing time to create this list
		$color = array( 'black', 'black', 'black', 'black', 'black',
			'white', 'white', 'white', 'white', 'white' );

		$index = self::$terms[strtolower( $match[0] )] % count( $bgcolor );

		return sprintf( $styleStart, $bgcolor[$index], $color[$index] ) . $match[0] . $styleEnd;
	}
}
