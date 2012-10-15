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

class User {

	private static $Map = array(
		0 => array( null, null, false ),
		1 => array( "TestUserWithoutRealName", null, true ),
		2 => array( "TestUserWithRealName", "Real Name", true ),
		3 => array( "TestUserWithoutRealNameOrPage", null, false )
	);

	private $name;
	private $id;
	private $realName;
	private $hasPage;

	public function __construct( $id, $name = null ) {
		if ( $name ) $this->name = $name;
		if ( $id ) $this->id = $id;
		foreach ( self::$Map as $key => $vals ) {
			if ( $id && $id == $key ) {
				$this->name = $vals[0];
				$this->realName = $vals[1];
				$this->hasPage = $vals[2];
			} elseif ( $name && $name == $vals[0] ) {
				$this->id = $key;
				$this->realName = $vals[1];
				$this->hasPage = $vals[2];
			}
		}
	}

	public static function newFromName( $name ) {
		return new User( null, $name );
	}

	public static function whoIsReal( $id ) {
		$vals = self::$Map[$id];
		return $vals[1];
	}

	public static function whoIs( $id ) {
		$vals = self::$Map[$id];
		return $vals[0];
	}

	function getId() {
		return $this->id;
	}

	function addToDatabase() { return; }

	function setRealName( $text ) {
		$this->realName = $text;
	}

	function saveSettings() { return; }

	function getName() {
		return $this->name;
	}

	function getRealName() {
		return $this->realName;
	}

	function getUserPage() {
		if ( $this->id == 0 ) return;
		if ( $this->name ) {
			$title = Title::newFromText( $this->name );
		} else {
			$title = Title::newFromText( '208.77.188.166' );
		}
		$title->setNamespace( "User" );
		$title->setExists( $this->hasPage );
		return $title;
	}

	public function getSkin() {
		return new TestSkin();
	}
}

class TestSkin {

	public function makeSpecialUrl( $page ) {
		$title = Title::newFromText( $page, NS_SPECIAL );
		return $title->getFullURL();
	}

	function makeLinkObj( $nt, $text= '', $query = '', $trail = '', $prefix = '' ) {
		global $wgUser;
		if ( ! is_object($nt) )
			throw new Exception( "The title argument must be a title" );
		$url = $nt->getFullUrl();
		if ( ! $text ) $text = $nt->getPrefixedText();

		return "<a href='$url'>$text</a>";
	}
}
