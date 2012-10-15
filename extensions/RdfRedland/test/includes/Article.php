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

/*
 * This is a mock of the MediaWiki Article class which implements only
 * those methods which are used by MwRdf and the various Model Makers.
 * Various set accessors are also implemented to allow construction of mock
 * Article objects.
 */
class Article {

	private $contributors = array();
	private $user;
	private $time;
	private $content;
	private $title;

	public function __construct( $title ) {
		$this->title = $title;
		switch ( $title->getPrefixedDBKey() ) {
			case 'Modeling_test_article' :
				$this->user = MwRdfTest::createUserWithRealName();
				$this->content = MwRdfTest::InPageWikitext();
				$this->time = 1; // 1 January 1970, 1 second after midnight UTC
				break;
			default :
				$this->time = 1; // 1 January 1970, 1 second after midnight UTC
		}
	}

	public function Article( $title ) {
		$this->__construct( $title );
	}

	public function getContent() {
		return $this->content;
	}

	public function setContent( $text ) {
		$this->content = $text;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getContributors() {
		return $this->contributors;
	}

	public function addContributor( $user ) {
		$this->contributors[] = array( $user->getId(),
		$user->getName(),
		$user->getRealName() );
	}

	public function getUser() {
		if ( $this->user ) return $this->user->getId();
		return 0;
	}

	public function setUser( $user ) {
		$this->user = $user;
	}

	public function getTimestamp() {
		return $this->time;
	}
}
