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

require_once( 'Special/QueryPageInterface.php' );
require_once( 'Special/QueryPage.php' );
require_once( 'SetupRdf.php' );

class MwRdf_SpecialPageFunction_Test extends MwRdfTestCase {

	private $article;
	private $format = 'turtle';
	private $konqueror_http_accept = '"text/html, image/jpeg, image/png, text/*, image/*, */*"';
	private $firefox_http_accept = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';

	public function setUp() {
		global $wgRequest, $wgOut, $wgRightsUrl, $wgUser,
		$wgRdfModelMakers, $wgRdfVocabularies, $wgRightsUrl;

		MwRdfTest::setupStorage();

		$wgRdfModelMakers = array( 'MwRdf_CreativeCommons_Modeler',
			'MwRdf_LinksFrom_Modeler',
			'MwRdf_LinksTo_Modeler',
			'MwRdf_InPage_Modeler',
			'MwRdf_DCmes_Modeler',
			'MwRdf_History_Modeler',
			'MwRdf_Image_Modeler',
			'MwRdf_Categories_Modeler',
			'MwRdf_Interwiki_Modeler' );

		$wgRdfVocabularies = array(
			'rdf'      => 'MwRdf_Vocabulary_Rdf',
			'rdfs'     => 'MwRdf_Vocabulary_RdfSchema',
			'dc'       => 'MwRdf_Vocabulary_DCMES',
			'dcterms'  => 'MwRdf_Vocabulary_DCTerms',
			'dctype'   => 'MwRdf_Vocabulary_DCMiType',
			'cc'       => 'MwRdf_Vocabulary_CreativeCommons' );

		$wgUser = MwRdfTest::createUserWithRealName();
		$wgRightsUrl = 'http://example.com/ns/copyright/';
		$wgRequest = $this;
		$wgOut = $this;

		$this->article = MwRdfTest::createSpecialPageTestArticle();
		$this->target = $this->article->getTitle()->getPrefixedDBKey();
	}

	public function prepareRequest( $http_accept = null, $modelnames = null ) {
		global $_REQUEST, $_SERVER;
		$_SERVER['CONTEXT'] = 'phpunit test';
		$_SERVER['HTTP_ACCEPT'] = $http_accept ? $http_accept : $this->konqueror_http_accept;
		$_REQUEST['modelnames'] = $modelnames;
	}

	public function getVal( $name ) {
		switch ( $name ) {
			case 'target' :
				return $this->target;
			case 'format' :
				return $this->format;
			default :
				return null;
		}
	}

	public function disable() { return true; }
	public function sendCacheControl() { return true; }
	public function setRobotPolicy() { return true; }
	public function parse( $string ) { return $string; }
	public function addHTML( $html ) { return $this->html .= $html; }

	public function testSpecialPageShowForm() {
		$this->format = null; # no format: function should show form
		$this->target = null;
		$this->prepareRequest();
		wfRdfSpecialPage( null );
		$this->assertRegExp( "/<select[^>]+name='modelnames\[\]'[^>]*>/", $this->html );
	}

	public function testSpecialPageWithKonqeurorAccepts() {
		$this->prepareRequest( $this->konqueror_http_accept );
		wfRdfSpecialPage( null );
	}

	public function testSpecialPageWithMozillaAccepts() {
		$this->prepareRequest( $this->firefox_http_accept );
		wfRdfSpecialPage( null );
	}

	public function testSpecialPageProducesTurtle() {
		$this->format = 'turtle';
		$this->prepareRequest();
		$text = wfRdfSpecialPage( null );
		$this->assertNotNull( $text );
		$this->assertNotEquals( "", $text );
	}

	public function testSpecialPageProducesRDFXML() {
		$this->format = 'rdfxml';
		$this->prepareRequest();
		$text = wfRdfSpecialPage( null );
		$this->assertNotNull( $text );
		$this->assertNotEquals( "", $text );
	}

	public function testSpecialPageProducesTriples() {
		$this->format = 'ntriples';
		$this->prepareRequest();
		$text = wfRdfSpecialPage( null );
		$this->assertNotNull( $text );
		$this->assertNotEquals( "", $text );
	}

	public function testSpecialPageProducesParsableTurtle() {
		$this->format = 'turtle';
		$this->prepareRequest();
		$text = wfRdfSpecialPage( null );
		$this->assertStringIsParsableTurtle( $text );
	}

	public function testSpecialPageProducesParsableRDFXML() {
		$this->format = 'rdfxml';
		$this->prepareRequest();
		$text = wfRdfSpecialPage( null );
		$this->assertStringIsParsableRDFXML( $text );
	}

	public function testSpecialPageProducesParsableTriples() {
		$this->format = 'ntriples';
		$this->prepareRequest();
		$text = wfRdfSpecialPage( null );
		$this->assertStringIsParsableTriples( $text );
	}

	public function testSpecialPageProducesCorrectDefaultModel() {
		$this->format = 'turtle';
		$parser = MwRdf::Parser( 'turtle' );
		$this->prepareRequest();
		$text = wfRdfSpecialPage( null );
		$model = MwRdf::Model();
		$model->loadStatementsFromString( $parser, $text );
		$expect = MwRdfTest::createExpectedDefaultSpecialPageModel();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testSpecialPageProducesCorrectInPageModel() {
		$this->format = 'turtle';
		$parser = MwRdf::Parser( 'turtle' );
		$this->prepareRequest( null, array( 'inpage' ) );
		$text = wfRdfSpecialPage( null );
		$model = MwRdf::Model();
		$model->loadStatementsFromString( $parser, $text );
		$expect = MwRdfTest::createExpectedInPageModel();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testSpecialPageProducesCorrectHistoryModel() {
		$this->format = 'turtle';
		$parser = MwRdf::Parser( 'turtle' );
		$this->prepareRequest( null, array( 'history' ) );
		$text = wfRdfSpecialPage( null );
		$model = MwRdf::Model();
		$model->loadStatementsFromString( $parser, $text );
		$expect = MwRdfTest::createExpectedHistoryModel();
		$this->assertModelEqualsModel( $expect, $model );
	}
}

class MwRdf_QueryPage_Test extends PHPUnit_Framework_TestCase {

	private $html;

	private $list;

	public function setUp() {
		global $wgUser, $wgOut, $wgContLang;
		$wgUser = User::newFromName( MwRdfTest::$username);
		$wgOut = $this;
		$wgContLang = $this;
	}

	public function getNsText() { return ''; }

	public function getNsIndex() { return 0; }

	public function setRobotPolicy() { return true; }

	public function getCode() { return ''; }

	public function ucfirst( $par ) { return $par; }

	public function lc( $par ) { return $par; }

	public function setSyndicated() { return true; }

	public function specialPage( $par ) {
		return 'http://example.com';
	}

	public function listToText( $s ) {
		$this->list = $s;
		return implode( ':', $s );
	}

	public function addHTML( $html ) {
		$this->html .= $html;
	}

	public function testQueryPage() {

		$page = new RdfTitleQueryPage();
		$query = MwRdf::Query( $page->getQuery(),
		$page->getBaseUrl(),
		$page->getQueryLanguage() );
		$res = $query->execute( MwRdf::StoredModel() );
		$count = 0;
		foreach ( $res as $statement ) {
			$count++;
		}
		$this->assertNotEquals( 0, $count );
		$this->assertNotEquals( 1, $count );

		$page->doQuery( 0, 50 );
		$this->assertContains( "THIS IS A HEADER\n", $this->html, $this->html );
		$this->assertContains( "up to <b>$count</b> results", $this->html, $this->html );
		$this->assertContains( "<li>url, title</li>", $this->html, $this->html );
		$this->assertContains( "(previous 50) (next 50)", $this->html, $this->html );

		$this->html = '';
		$page->doQuery( 0, 5 );
		$this->assertContains( "THIS IS A HEADER\n", $this->html, $this->html );
		$this->assertContains( "up to <b>$count</b> results", $this->html, $this->html );
		$this->assertContains( "<li>url, title</li>", $this->html, $this->html );
		$this->assertContains( "(previous 5)", $this->html, $this->html );
		$this->assertContains( "<ol start='1' class='special'><li>url, title</li>\n<li>url, title</li>\n<li>url, title</li>\n<li>url, title</li>\n<li>url, title</li>\n</ol>", $this->html, $this->html );
	}
}

class RdfTitleQueryPage extends RdfQueryPage {

	public function getName() { return "Testsearch"; }

	public function isExpensive() { return false; }

	public function isSyndicated() { return false; }

	public function getQueryLanguage() { return 'sparql'; }

	public function getBaseUrl() { return null; }

	public function getPageHeader() { return "THIS IS A HEADER\n"; }

	public function formatResult( $skin, $result ) {
		$keys = array_keys( $result );
		return join( ', ', $keys );
	}

	public function getQuery() {
		$ns = MwRdf::Vocabulary( 'dc' )->getNS();
		return "
			PREFIX dc: <$ns>
			SELECT ?url ?title
			WHERE { ?url dc:title ?title } ";
	}
}
