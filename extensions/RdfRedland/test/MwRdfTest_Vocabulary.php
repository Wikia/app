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

require_once( 'Vocabulary.php' );

class MwRdf_Vocabulary_Test extends PHPUnit_Framework_TestCase {

	public function testNamespaceInheritance() {
		$ns = 'http://example.com/test/';
		$this->assertEquals( $ns, TestVocabularyClass::NAMESPACE );
		$this->assertEquals( $ns, TestVocabularyClass::getNS() );

		$ns = "http://www.w3.org/1999/02/22-rdf-syntax-ns#";
		$this->assertEquals( $ns, MwRdf_Vocabulary_Rdf::NAMESPACE );
		$this->assertEquals( $ns, MwRdf_Vocabulary_Rdf::getNS() );

		$ns = "http://www.w3.org/2000/01/rdf-schema#";
		$this->assertEquals( $ns, MwRdf_Vocabulary_RdfSchema::NAMESPACE );
		$this->assertEquals( $ns, MwRdf_Vocabulary_RdfSchema::getNS() );

		$ns = 'http://web.resource.org/cc/';
		$this->assertEquals( $ns, MwRdf_Vocabulary_CreativeCommons::NAMESPACE );
		$this->assertEquals( $ns, MwRdf_Vocabulary_CreativeCommons::getNS() );

		$ns = "http://purl.org/dc/elements/1.1/";
		$this->assertEquals( $ns, MwRdf_Vocabulary_DCMES::NAMESPACE );
		$this->assertEquals( $ns, MwRdf_Vocabulary_DCMES::getNS() );
	}
}

class TestVocabularyClass extends MwRdf_Vocabulary {

	const NAMESPACE = 'http://example.com/test/';

	public function getNS() {
		return self::NAMESPACE;
	}

	public $Right;
	public $Left;
	public $Under;
	public $Over;
}
