<?php

define( 'MW_AGGREGATOR_VERSION', 1 );

global $wgAggregatorExpiry;
global $wgExtensionFunctions;


/// Don't poll remote feeds more often than every 30 minutes
$wgAggregatorExpiry = 1800;

$wgExtensionFunctions[] = 'wfAggregatorSetup';

function wfAggregatorSetup() {
	global $wgParser;
	$wgParser->setHook( 'aggregator', 'wfAggregatorHook' );
	
	// Magpie
	if( defined( 'MAGPIE_OUTPUT_ENCODING' ) ) {
		if( stricmp( MAGPIE_OUTPUT_ENCODING, 'UTF-8' ) ) {
			die( 'Must set MAGPIE_OUTPUT_ENCODING to "UTF-8".' );
		}
	} else {
		define( 'MAGPIE_OUTPUT_ENCODING', 'UTF-8' );
	}
	require_once 'rss_fetch.inc';
	
	// Wiki pieces
	require_once 'SpecialPage.php';
	require_once 'Feed.php';
	SpecialPage::addPage( new SpecialPage( 'Aggregator', /*perm*/false, /*listed*/ true, /*function*/ false, /*file*/ false ) );
}

/**
 * Parser extension hook
 */
function wfAggregatorHook( $text, $options=array(), $parser=null ) {
	if( isset( $options['name'] ) ) {
		$name = $options['name'];
	} else {
		return "(Aggregator: You must provide a name.)";
	}
	
	$items = isset( $options['items'] ) ? intval( $options['items'] ) : 5;
	$export = isset( $options['export'] ) ? intval( $options['export'] ) : 0;
	
	if( $export ) {
		// Slap some pretty links on the page
		$parser->addOutputHandler( new AggregatorOutput( $name, $export ) );
	}
	
	if( $items ) {
		$parser->addOutputHandler( new AggregatorStyleHandler() );
		$aggro = new Aggregator( $options['name'] );
		return $aggro->inline( $items );
	} else {
		return "";
	}
}

class AggregatorStyleHandler {
	function apply( $outputPage ) {
		global $wgScriptPath;
		$outputPage->addScript( wfElement( 'link', array(
			'rel' => 'stylesheet',
			'type' => 'text/css',
			'href' => "$wgScriptPath/extensions/Aggregator/inline-feed.css" ) ) );
	}
}

/**
 * Parser output handler extension
 */
class AggregatorOutput {
	var $mVersion = MW_AGGREGATOR_VERSION;
	
	function __construct( $name ) {
		$this->mName = $name;
	}
	
	function apply( $outputPage ) {
		$outputPage->addScript(
			$this->_feedLink( 'rss', 'application/rss+xml' ) .
			$this->_feedLink( 'atom', 'application/atom+xml' ) );
	}
	
	function _feedLink( $type, $mime ) {
		$special = wfAggregatorFeedPage( $this->mName, $type );
		$link = wfElement( 'link', array(
			'rel' => 'alternate',
			'type' => $mime,
			'href' => $special->getLocalUrl() ) );
		return $link;
	}
}

function wfAggregatorFeedPage( $name, $type ){
	return Title::makeTitleSafe( NS_SPECIAL, "Aggregator/$type/$name" );
}


/**
 * Special page management interface
 */
function wfSpecialAggregator( $par=null ) {
	$bits = explode( '/', $par, 2 );
	if( count( $bits ) < 2 ) {
		// editor form not yet implemented
	} else {
		list( $type, $target ) = $bits;
		return wfAggregatorFeed( $target, $type );
	}
}

/**
 * Spit out a re-exported feed
 */
function wfAggregatorFeed( $target, $type ) {
	global $wgFeedClasses, $wgOut;
	$wgOut->disable();
	
	$aggro = new Aggregator( $target );
	$aggro->outputFeed( $type, 10 );
}

function wfAggregatorFeedError( $message ) {
	wfHttpError( 400, "Bad request", $message );
}



class Aggregator {
	public function __construct( $target ) {
		$this->mName = $target;
	}
	
	/**
	 * Output inline HTML suitable for inclusion in page output
	 * WARNING: HTML from the feed is not sanitized!
	 */
	public function inline( $count ) {
		$items = $this->collect( $count );
		return "<div class=\"feed\">" .
			implode( "\n", array_map( array( $this, 'inlineFormat' ), $items ) ) .
			"</div>";
	}
	
	private function inlineFormat( $item ) {
		global $wgContLang;
		if( $item->getUrl() ) {
			$title = '<a href="' . $item->getUrl() . '">' .
				$item->getTitle() . '</a>';
		} else {
			$title = $item->getTitle();
		}
		return '<div class="feed-item">' .
			'<div class="feed-title">' . $title . '</div>' .
			'<div class="feed-byline">by ' . $item->getAuthor() . ' at ' .
				$wgContLang->timeanddate( $item->getDate() ) . '</div>' .
			'<div class="feed-description">' . $item->Description . '</div>' .
			'</div>';
	}
	
	/**
	 * Send feed output...
	 * @param string $type feed type ('rss', 'atom')
	 * @param int $items
	 */
	public function outputFeed( $type, $count ) {
		global $wgFeedClasses;
		if( !isset( $wgFeedClasses[$type] ) ) {
			return wfAggregatorFeedError( "Requested feed type \"$type\" not recognized." );
		}
		
		$special = wfAggregatorFeedPage( $this->mName, $type );
		$feed = new $wgFeedClasses[$type]( 'my cool feed', 'my feed rocks',
			$special->getFullUrl() );

		$items = $this->collect( $count );
		$feed->outHeader();
		foreach( $items as $item ) {
			$feed->outItem( $item );
		}
		$feed->outFooter();
	}
	
	/**
	 * Fetch the list of feeds in this group
	 */
	public function getFeedUrls() {
		$fname = __CLASS__ . '::' . __FUNCTION__;
		
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select( 'feed',
			array( 'feed_url' ),
			array( 'feed_group' => $this->mName ),
			$fname );
		while( $row = $dbr->fetchObject( $result ) ) {
			$urls[] = $row->feed_url;
		}
		$dbr->freeResult( $result );
		return $urls;
	}
	
	private function updateFeeds() {
		$fname = __CLASS__ . '::' . __FUNCTION__;
		global $wgAggregatorExpiry;
		
		$dbr = wfGetDB( DB_SLAVE );
		$cutoff = wfTimestamp( TS_MW, time() - $wgAggregatorExpiry );
		$result = $dbr->select( 'feed',
			array( 'feed_url' ),
			array(
				'feed_group' => $this->mName,
				'feed_touched IS NULL OR feed_touched < ' .
					$dbr->addQuotes( $dbr->timestamp( $cutoff ) ) ),
			$fname );
		
		while( $row = $dbr->fetchObject( $result ) ) {
			// Magpie
			require_once 'rss_fetch.inc';
			
			wfDebug( "$fname checking $row->feed_url\n" );
			$feed = fetch_rss( $row->feed_url );
			$this->saveItems( $row->feed_url, $feed->items );
		}
		$dbr->freeResult( $result );
	}
	
	private function saveItems( $url, $items ) {
		$fname = __CLASS__ . '::' . __FUNCTION__;
		wfDebug( "$fname saving items from $url\n" );
		
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		
		$this->clearItems( $dbw, $url );
		$this->insertItems( $dbw, $url, $items );
		$this->touchFeed( $dbw, $url );
		
		$dbw->commit();
	}
	
	private function clearItems( $dbw, $url ) {
		$fname = __CLASS__ . '::' . __FUNCTION__;
		$dbw->delete( 'feeditem', array( 'fi_feed' => $url ), $fname );
	}
	
	private function insertItems( $dbw, $url, $items ) {
		$fname = __CLASS__ . '::' . __FUNCTION__;
		$save = array();
		foreach( $items as $item ) {
			$save[] = $this->formatSaveRow( $dbw, $url, $item );
		}
		$dbw->insert( 'feeditem', $save, $fname, array( 'IGNORE' ) );
	}
	
	private function touchFeed( $dbw, $url ) {
		$fname = __CLASS__ . '::' . __FUNCTION__;
		$dbw->update( 'feed',
			array( 'feed_touched' => $dbw->timestamp() ),
			array( 'feed_url' => $url ),
			$fname );
	}
	
	private function formatSaveRow( $db, $feedUrl, $item ) {
		if( isset( $item['atom_content'] ) ) {
			$content = $item['atom_content'];
		} elseif( isset( $item['description'] ) ) {
			$content = $item['description'];
		} elseif( isset( $item['summary'] ) ) {
			$content = $item['summary'];
		} else {
			$content = null;
		}
		
		if( isset( $item['author'] ) ) {
			$author = $item['author'];
		} elseif( isset( $item['dc']['creator'] ) ) {
			$author = $item['dc']['creator'];
		} else {
			$author = null;
		}
		
		return array(
			'fi_feed'        => $feedUrl,
			'fi_title'       => @$item['title'],
			'fi_content'     => $content,
			'fi_url'         => @$item['link'],
			'fi_date'        => $db->timestamp( @$item['date_timestamp'] ),
			'fi_author'      => $author,
			'fi_comments'    => @$item['comments'] );
	}
	
	/**
	 * Fetch the top $count items from this feed set.
	 * Returns as FeedItem objects.
	 */
	private function collect( $count ) {
		$fname = __CLASS__ . '::' . __FUNCTION__;
		$this->updateFeeds();
		
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select( 'feeditem',
			array( 'fi_feed', 'fi_title', 'fi_content', 'fi_url',
				'fi_date', 'fi_author', 'fi_comments' ),
			array( 'fi_feed' => $this->getFeedUrls() ),
			$fname,
			array( 'ORDER BY' => 'fi_date DESC', 'LIMIT' => $count ) );

		$result = $dbr->select(
			array( 'feed', 'feeditem' ),
			array(
				'fi_feed', 'fi_title', 'fi_content', 'fi_url',
				'fi_date', 'fi_author', 'fi_comments' ),
			array(
				'feed_group' => $this->mName,
				'feed_url=fi_feed' ),
			$fname,
			array( 'ORDER BY' => 'fi_date DESC', 'LIMIT' => $count ) );
		
		$items = array();
		while( $row = $dbr->fetchObject( $result ) ) {
			$items[] = new FeedItem( $row->fi_title,
				$row->fi_content,
				$row->fi_url,
				$row->fi_date,
				$row->fi_author,
				$row->fi_comments );
		}
		$dbr->freeResult( $result );
		return $items;
	}
}

