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
class MwRdf_Vocabulary_Rdf extends MwRdf_Vocabulary {

	//base uri
	const NAMESPACE = "http://www.w3.org/1999/02/22-rdf-syntax-ns#";
	public function getNS() { return self::NAMESPACE; }

	// Terms
	public $Alt;
	public $Bag;
	public $Property;
	public $Seq;
	public $Statement;
	public $List;
	public $nil;
	public $type;
	public $rest;
	public $first;
	public $subject;
	public $predicate;
	public $object;
	public $Description;
	public $ID;
	public $about;
	public $aboutEach;
	public $aboutEachPrefix;
	public $bagID;
	public $resource;
	public $parseType;
	public $Literal;
	public $Resource;
	public $li;
	public $nodeID;
	public $datatype;
	public $seeAlso;
	public $a;

	// a special alias to be reassigned to type
	public function __construct() {
		parent::__construct();
		$this->a = $this->type;
	}
}
