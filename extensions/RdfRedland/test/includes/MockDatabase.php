<?php
if (!defined('MEDIAWIKI')) die();
/**
 * MwRdf.php -- RDF framework for MediaWiki
 * Copyright 2005,2006 Evan Prodromou <evan@wikitravel.org>
 * Copyright 2007 Mark Jaroski
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA *
 * @author Evan Prodromou <evan@wikitravel.org>
 * @author Mark Jaroski <mark@geekhive.net>
 * @package MediaWiki
 * @subpackage Extensions
 */

class TotallyFakeDatabase {

	private static $pagelinks = array(
		array( 'pl_namespace' => '',     'pl_title' => 'Link1' ),
		array( 'pl_namespace' => 'User', 'pl_title' => 'Page1' ),
		array( 'pl_namespace' => '',     'pl_title' => 'Link2' ),
		array( 'pl_namespace' => 'User', 'pl_title' => 'Page2' )
	);

	private static $imagelinks = array(
		array( 'il_to' => 'Some_image.png' )
	);

	// array('rev_id', 'rev_timestamp', 'rev_user', 'rev_user_text'),
	private static $page_revision = array(
		array('rev_id' => 0, 'rev_timestamp' => 1, 'rev_user' => 0, 'rev_user_text' => null)
	);

	private $cols;
	private $count;

	public function __construct() {
		$this->count = 0;
	}

	public function select( $table, $cols, $where_clause, $fname = null, $options = array() ) {
		$this->cols = $cols;
		if ( "$table" == "Array" )
		$table = join( " ", $table );
		switch ( $table ) {
			case 'pagelinks' :
				return self::$pagelinks;
				break;
			case 'imagelinks' :
				return self::$imagelinks;
				break;
			case 'page revision' :
				return self::$page_revision;
				break;
			default :
				throw new Exception( "Table '$table' not found" );
		}
	}

	public function fetchObject( $res ) {
		if ( ! isset( $res[$this->count] ) ) return false;
		$obj = new Row();
		foreach ( $this->cols as $attr ) {
			$obj->$attr = $res[$this->count][$attr];
		}
		$this->count++;
		return $obj;
	}

	public function freeResult( $res ) {
		$this->count = 0;
	}

	public function addQuotes() {
	}

}

class Row {}
