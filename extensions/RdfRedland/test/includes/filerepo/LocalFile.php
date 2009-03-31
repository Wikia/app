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

class Image {

	public static $HistoryDB = array(
	'Some_image.png' => array(
	array( 3, "TestUserWithRealName", 1 ),
	array( 0, null, 1 ),
	array( 2, "TestUserWithRealName", 1 )
	),
	'SingleAuthorImage.png' => array(
	array( 3, "TestUserWithRealName", 1 )
	)
	);

	public $text;
	public $exists = true;
	public $namespace = 'Image';
	public $mimetype = 'image';
	public $time = 1;
	public $count;
	public $history;

	public function __construct( $text ) {
		$this->text = $text;
		$this->time = 1;
		$tokens = split( '\.', $text );
		$ext = array_pop( $tokens );
		switch ( $ext ) {
			case 'png' :
				$this->mimetype = 'image/png';
				break;
			case 'jpg' :
				$this->mimetype = 'image/jpeg';
				break;
			case 'jpeg' :
				$this->mimetype = 'image/jpeg';
				break;
			default :
				$this->mimetype = 'image';
				break;
		}
		$this->history = self::$HistoryDB[$this->text];
		$this->count = 0;
	}

	public static function newFromName( $text ) {
		if ( ! $text ) return null;
		return new Image( $text );
	}

	public function exists() {
		return $this->exists;
	}

	public function getURL() {
		return 'http://example.com/wiki/Image:' . $this->text;
	}

	public function getMimeType() {
		return $this->mimetype;
	}

	public function nextHistoryLine() {
		if ( ! isset( $this->history[$this->count] ) ) return false;
		$line = new HistLine();
		$line->img_user      = $this->history[$this->count][0];
		$line->img_user_text = $this->history[$this->count][1];
		$line->img_timestamp = $this->history[$this->count][2];
		$this->count++;
		return $line;
	}
}

class HistLine {
}
