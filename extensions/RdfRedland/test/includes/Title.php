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

define( "NS_SPECIAL", "Special" );
define( "NS_TALK", "Talk" );

class Title {

	private static $IwPrefixes = array(
	'en' => "http://example.com/wiki/en/",
	'fr' => "http://example.com/wiki/fr/",
	'de' => "http://example.com/wiki/de/",
	'wp' => "http://en.wikipedia.org/"
	);

	private $parentCategories = array();
	private $text;
	private $namespace;
	private $interwiki;
	private $interwiki_url;
	private $exists = true;

	public static function legalChars() {
		return " %!\"$&'()*,\\-.\\/0-9:;=?@A-Z\\\\^_`a-z~\\x80-\\xFF+";
	}

	public static function newFromText( $text) {
		if ( ! $text ) return null;
		$text = str_replace( '_', ' ', $text);
		return new Title( $text );
	}

	public static function makeTitle( $ns, $text ) {
		return new Title( "$ns:$text" );
	}

	public function __construct( $text ) {
		$tokens = split( ':', $text );
		if ( count( $tokens ) == 1 ) {
			$this->text = $tokens[0];
			$this->namespace = '';
		} else {
			$prefix = array_shift( $tokens );
			if ( isset( self::$IwPrefixes[$prefix] ) ) {
				$this->interwiki = $prefix;
				$this->interwiki_url = self::$IwPrefixes[$prefix];
			} else {
				$this->namespace = $prefix;
			}
			$this->text = join( ':', $tokens );
		}
	}

	public function getText() {
		return $this->text;
	}

	public function setText( $text ) {
		$this->text = $text;
	}

	public function getInterwiki() {
		return $this->interwiki;
	}

	public function setExists( $bool ) {
		$this->exists = $bool;
	}

	public function getParentCategories() {
		return array_flip( $this->parentCategories );
	}

	public function setParentCategories( $cats ) {
		$this->parentCategories = $cats;
	}

	public function exists() {
		return $this->exists;
	}

	public function getNamespace() {
		return $this->namespace;
	}

	public function setNamespace( $ns ) {
		$this->namespace = $ns;
	}

	public function getDBKey() {
		$t = preg_replace( '/[ _]+/', '_', $this->text );
		return trim( $t, '_' );
	}

	public function getPrefixedDbKey() {
		if ( $this->namespace ) {
			return $this->namespace . ":" . $this->getDBKey();
		} else {
			return $this->getDBKey();
		}
	}

	public function getArticleId() {
		return $this->exists ? 1 : 0;
	}

	public function getPrefixedText() {
		return $this->namespace . ':' . $this->text;
	}

	public function getFullUrl( $query = null ) {
		if ( $this->interwiki ) {
			$url = $this->interwiki_url . $this->getPrefixedDbKey();
		} else {
			$url = "http://example.com/wiki/" . $this->getPrefixedDbKey();
			if ( $query ) $url .= "?$query";
		}
		return  $url;
	}

	public function getTalkPage() {
		$talk_page = clone( $this );
		if ( $this->getNamespace() == "" ) {
			$talk_page->setNamespace( "Talk" );
		} elseif ( $this->getNamespace() == "User" ) {
			$talk_page->setNamespace( "User_talk" );
		}
		return $talk_page;
	}

	public function getSubjectPage() {
		return self::newFromText( $this->getText() );
	}
}
