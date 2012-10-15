<?php
/**
 * MediaWiki Wikilog extension
 * Copyright © 2008-2010 Juliano F. Ravasi
 * http://www.mediawiki.org/wiki/Extension:Wikilog
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

/**
 * @file
 * @ingroup Extensions
 * @author Juliano F. Ravasi < dev juliano info >
 */

if ( !defined( 'MEDIAWIKI' ) )
	die();

class WikilogLinksUpdate
{
	private $mId;
	private $mTitle;
	private $mDb;
	private $mOptions;
	private $mAuthors;
	private $mTags;

	function __construct( &$lupd, $parserOutput ) {
		$this->mId = $lupd->mId;
		$this->mTitle = $lupd->mTitle;
		$this->mDb = $lupd->mDb;
		$this->mOptions = $lupd->mOptions;
		$this->mAuthors = $parserOutput->getAuthors();
		$this->mTags = $parserOutput->getTags();
	}

	function doUpdate() {
		global $wgUseDumbLinkUpdate;
		
		if ( $wgUseDumbLinkUpdate ) {
			$this->doDumbUpdate();
		} else {
			$this->doIncrementalUpdate();
		}
	}

	private function doIncrementalUpdate() {
		# Authors
		$existing = $this->getExistingAuthors();
		$this->incrTableUpdate( 'wikilog_authors',
			'wla_page', 'wla_author_text',
			$this->getAuthorDeletions( $existing ),
			$this->getAuthorInsertions( $existing )
		);

		# Tags
		$existing = $this->getExistingTags();
		$this->incrTableUpdate( 'wikilog_tags',
			'wlt_page', 'wlt_tag',
			$this->getTagDeletions( $existing ),
			$this->getTagInsertions( $existing )
		);
	}

	private function doDumbUpdate() {
		$this->dumbTableUpdate( 'wikilog_authors', 'wla_page', $this->getAuthorInsertions() );
		$this->dumbTableUpdate( 'wikilog_tags',    'wlt_page', $this->getTagInsertions()    );
	}

	private function dumbTableUpdate( $table, $from, $insertions ) {
		$this->mDb->delete( $table, array( $from => $this->mId ), __METHOD__ );
		if ( count( $insertions ) ) {
			$this->mDb->insert( $table, $insertions, __METHOD__, 'IGNORE' );
		}
	}

	private function incrTableUpdate( $table, $from, $to, $deletions, $insertions ) {
		if ( count( $deletions ) ) {
			$where = array(
				$from => $this->mId,
				"$to IN (" . $this->mDb->makeList( array_keys( $deletions ) ) . ")"
			);
			$this->mDb->delete( $table, $where, __METHOD__ );
		}
		if ( count( $insertions ) ) {
			$this->mDb->insert( $table, $insertions, __METHOD__, 'IGNORE' );
		}
	}
	
	private function getAuthorInsertions( $existing = array() ) {
		$arr = array();
		$diffs = array_diff_key( $this->mAuthors, $existing );
		foreach ( $diffs as $author_text => $author ) {
			$arr[] = array(
				'wla_page'			=> $this->mId,
				'wla_author'		=> $author,
				'wla_author_text'	=> $author_text
			);
		}
		return $arr;
	}

	private function getTagInsertions( $existing = array() ) {
		$arr = array();
		$diffs = array_diff_key( $this->mTags, $existing );
		foreach ( $diffs as $tag => $dummy ) {
			$arr[] = array(
				'wlt_page'   => $this->mId,
				'wlt_tag'    => $tag
			);
		}
		return $arr;
	}

	private function getAuthorDeletions( $existing ) {
		return array_diff_key( $existing, $this->mAuthors );
	}

	private function getTagDeletions( $existing ) {
		return array_diff_key( $existing, $this->mTags );
	}

	private function getExistingAuthors() {
		$res = $this->mDb->select( 'wikilog_authors', array( 'wla_page', 'wla_author' ),
			array( 'wla_page' => $this->mId ), __METHOD__, $this->mOptions );
		$arr = array();
		while ( $row = $this->mDb->fetchObject( $res ) ) {
			$arr[$row->wla_author] = 1;
		}
		$this->mDb->freeResult( $res );
		return $arr;
	}

	private function getExistingTags() {
		$res = $this->mDb->select( 'wikilog_tags', array( 'wlt_page', 'wlt_tag' ),
			array( 'wlt_page' => $this->mId ), __METHOD__, $this->mOptions );
		$arr = array();
		while ( $row = $this->mDb->fetchObject( $res ) ) {
			$arr[$row->wlt_tag] = 1;
		}
		$this->mDb->freeResult( $res );
		return $arr;
	}


	/**
	 *  MediaWiki hooks.
	 */
	#
	static function LinksUpdate( &$lupd ) {
		if ( isset( $lupd->mParserOutput->mExtWikilog ) ) {
			$u = new WikilogLinksUpdate( $lupd, $lupd->mParserOutput->mExtWikilog );
			$u->doUpdate();
		}
		return true;
	}
}
