<?php

/**
 * Add a <subpages /> tag which produces a linked list of all subpages of the current page
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0 or later
 */
 
if( defined( 'MEDIAWIKI' ) ) {

	$wgExtensionFunctions[] = 'efSubpageList';
	$wgExtensionCredits['parserhook'][] = array( 'name' => 'Subpage List', 'author' => 'Rob Church' );

	function efSubpageList() {
		global $wgParser;
		$wgParser->setHook( 'subpages', 'efRenderSubpageList' );
	}
	
	function efRenderSubpageList( $input, $args, &$parser ) {
		$list = new SubpageList( $parser );
		$list->options( $args );
		return $list->render();
	}
	
	class SubpageList {
	
		var $parser;
		var $title;
		
		var $token = '*';
		
		function SubpageList( &$parser ) {
			$this->parser =& $parser;
			$this->title =& $parser->getTitle();
		}
		
		function options( $options ) {
			if( isset( $options['type'] ) ) {
				$type = strtolower( $options['type'] );
				if( $type == 'ol' || $type == '#' )
					$this->token = '#';
			}
		}
		
		function render() {
			wfProfileIn( 'SubpageList::render' );
			$pages = $this->getTitles();
			if( count( $pages ) > 0 ) {
				$list = $this->makeList( $pages );
				$html = $this->parse( $list );
			} else {
				$html = '';
			}
			wfProfileOut( 'SubpageList::render' );
			return "<div class=\"subpagelist\">{$html}</div>";
		}
		
		function getTitles() {
			wfProfileIn( 'SubpageList::getTitles' );
			
			$dbr =& wfGetDB( DB_SLAVE );
			$page = $dbr->tableName( 'page' );
			
			$ns = $this->title->getNamespace();
			$like = $dbr->addQuotes( $this->title->getDBkey() . '/%' );
			$sql = "SELECT page_title FROM {$page} WHERE page_namespace = {$ns} AND page_is_redirect=0 AND page_title LIKE {$like}";
			$res = $dbr->query( $sql, 'SubpageList::getTitles' );
			
			$titles = array();
			while( $row = $dbr->fetchObject( $res ) ) {
				$title = Title::makeTitleSafe( $ns, $row->page_title );
				if( is_object( $title ) )
					$titles[] = $title;
			}
			
			$dbr->freeResult( $res );
			wfProfileOut( 'SubpageList::getTitles' );
			return $titles;
		}
		
		function makeList( $titles ) {
			wfProfileIn( 'SubpageList::makeList' );
			$list = array();
			foreach( $titles as $title )
				$list[] = $this->token . $this->makeListItem( $title );
			wfProfileOut( 'SubpageList::makeList' );
			return implode( "\n", $list );
		}
		
		function makeListItem( $title ) {
			$link = ' [[' . $title->getPrefixedText() . '|';
			
			$chop = count( explode( '/', $this->title->getText() ) );
			$parts = explode( '/', $title->getText() );
			for( $i = 0; $i < $chop; $i++ )
				array_shift( $parts );
			
			$link .= implode( '/', $parts ) . ']]';
			return $link;
		}
		
		function parse( $text ) {
			wfProfileIn( 'SubpageList::parse' );
			$options =& $this->parser->getOptions();
			$output = $this->parser->parse( $text, $this->title, $options, true, false );
			wfProfileOut( 'SubpageList::parse' );
			return $output->getText();
		}
	
	}
	
} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}


