<?php
/**
 * Copyright (C) 2008 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
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
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

class TitleKey {
	static $deleteIds = array();
	
	// Active functions...
	static function deleteKey( $id ) {
		$db = wfGetDB( DB_MASTER );
		$db->delete( 'titlekey',
			array( 'tk_page' => $id ),
			__METHOD__ );
	}

	static function setKey( $id, $title ) {
		self::setBatchKeys( array( $id => $title ) );
	}
	
	static function setBatchKeys( $titles ) {
		$rows = array();
		foreach( $titles as $id => $title ) {
			$rows[] = array(
				'tk_page' => $id,
				'tk_namespace' => $title->getNamespace(),
				'tk_key' => self::normalizeTitle( $title ),
			);
		}
		$db = wfGetDB( DB_MASTER );
		$db->replace( 'titlekey', array( 'tk_page' ),
			$rows,
			__METHOD__ );
	}
	
	
	// Normalization...
	static function normalizeTitle( $title ) {
		return self::normalize( $title->getText() );
	}
	
	static function normalize( $text ) {
		global $wgContLang;
		return $wgContLang->caseFold( $text );
	}


	// Hook functions....

	static function updateDeleteSetup( $article, $user, $reason ) {
		$title = $article->mTitle->getPrefixedText();
		self::$deleteIds[$title] = $article->getID();
		return true;
	}

	static function updateDelete( $article, $user, $reason ) {
		$title = $article->mTitle->getPrefixedText();
		if( isset( self::$deleteIds[$title] ) ) {
			self::deleteKey( self::$deleteIds[$title] );
		}
		return true;
	}

	static function updateInsert( $article, $user, $text, $summary, $isMinor, $isWatch, $section, $flags, $revision ) {
		self::setKey( $article->getId(), $article->getTitle() );
		return true;
	}
	
	static function updateMove( $from, $to, $user, $fromid, $toid ) {
		// FIXME
		self::setKey( $toid, $from );
		self::setKey( $fromid, $to );
		return true;
	}

	static function testTables( &$tables ) {
		$tables[] = 'titlekey';
		return true;
	}

	static function updateUndelete( $title, $isnewid ) {
		$article = new Article($title);
		$id = $article->getID();
		self::setKey( $id, $title );
		return true;
	}
	
	/**
	 * Apply schema updates as necessary.
	 * If creating the titlekey table for the first time,
	 * will populate the table with all titles in the page table.
	 *
	 * Status info is sent to stdout.
	 */
	public static function schemaUpdates( $updater = null ) {
		$updater->addExtensionUpdate( array( array( __CLASS__, 'runUpdates' ) ) );
		return true;
	}

	public static function runUpdates( $updater ) {
		$db = $updater->getDB();
		if( $db->tableExists( 'titlekey' ) ) {
			$updater->output( "...titlekey table already exists.\n" );
		} else {
			$updater->output( "Creating titlekey table..." );
			$sourcefile = $db->getType() == 'postgres' ? '/titlekey.pg.sql' : '/titlekey.sql';
			$err = $db->sourceFile( dirname( __FILE__ ) . $sourcefile );
			if( $err !== true ) {
				throw new MWException( $err );
			}

			$updater->output( "ok.\n" );
			$task = $updater->maintenance->runChild( 'RebuildTitleKeys' );
			$task->execute();
		}
	}

	/**
	 * Override the default OpenSearch backend...
	 * @param string $search term
	 * @param int $limit max number of items to return
	 * @param array &$results out param -- list of title strings
	 */
	static function prefixSearchBackend( $ns, $search, $limit, &$results ) {
		$results = self::prefixSearch( $ns, $search, $limit );
		return false;
	}
	
	static function prefixSearch( $namespaces, $search, $limit ) {
		$ns = array_shift( $namespaces ); // support only one namespace
		if( in_array( NS_MAIN, $namespaces ) )
			$ns = NS_MAIN; // if searching on many always default to main 
		
		$key = self::normalize( $search );
		
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select(
			array( 'titlekey', 'page' ),
			array( 'page_namespace', 'page_title' ),
			array(
				'tk_page=page_id',
				'tk_namespace' => $ns,
				'tk_key ' . $dbr->buildLike( $key, $dbr->anyString() ),
			),
			__METHOD__,
			array(
				'ORDER BY' => 'tk_key',
				'LIMIT' => $limit ) );
		
		// Reformat useful data for future printing by JSON engine
		$srchres = array();
		foreach( $result as $row ) {
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );
			$srchres[] = $title->getPrefixedText();
		}
		$result->free();
		
		return $srchres;
	}
	
	/**
	 * Find matching titles after the default 'go' search exact match fails.
	 * This'll let 'mcgee' match 'McGee' etc.
	 * @param string $term
	 * @param Title outparam &$title
	 */
	static function searchGetNearMatch( $term, &$title ) {
		$temp = Title::newFromText( $term );
		if( $temp ) {
			$match = self::exactMatchTitle( $temp );
			if( $match ) {
				// Yay!
				$title = $match;
				return false;
			}
		}
		// No matches. :(
		return true;
	}
	
	static function exactMatchTitle( $title ) {
		$ns = $title->getNamespace();
		return self::exactMatch( $ns, $title->getText() );
	}
	
	static function exactMatch( $ns, $text ) {
		$key = self::normalize( $text );
		
		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow(
			array( 'titlekey', 'page' ),
			array( 'page_namespace', 'page_title' ),
			array(
				'tk_page=page_id',
				'tk_namespace' => $ns,
				'tk_key' => $key,
			),
			__METHOD__ );
		
		if( $row ) {
			return Title::makeTitle( $row->page_namespace, $row->page_title );
		} else {
			return null;
		}
	}
}
