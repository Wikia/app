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
 * A (mostly) abstract class which provides a little syntactic sugar
 * for defining vocabularies. To define a vocabulary using this
 * interface simply declare a base URI as the constant NAMESPACE, then
 * add terms for each of the vocabulary's terms.  Just make sure that
 * the term name exactly matches the term text.
 */
abstract class MwRdf_Vocabulary {

	const NAMESPACE = '';

	public function getNS() {
		self::NAMESPACE;
	}

	public function __construct() {
		foreach ( $this as $key => $value ) {
			$this->$key = MwRdf::UriNode( $this->getNS(). $key );
		}
	}

	public function listTerms() {
		$list = array();
		foreach( $this as $key => $value ) {
			$list[] = $key;
		}
		return $list;
	}
}
