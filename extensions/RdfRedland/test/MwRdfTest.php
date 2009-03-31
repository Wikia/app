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

require_once( 'Rdf.php' );

class MwRdfTest {

	public static $Runtime;

	public function InPageWikitext() {
		$turtle = MwRdfTest::expectedInPageTurtle();
		return <<<EOF

<rdf>
	$turtle
</rdf>

EOF;
	}

	public function expectedInPageTurtle() {
		return <<<EOF
@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix dc: <http://purl.org/dc/elements/1.1/> .
@prefix ex: <http://example.org/stuff/1.0/> .

<http://www.w3.org/TR/rdf-syntax-grammar>
dc:title "RDF/XML Syntax Specification (Revised)" ;
ex:editor [
ex:fullname "Dave Beckett";
ex:homePage <http://purl.org/net/dajobe/>
] .
		EOF;
	}

	public function expectedTalkDCMESTurtle() {
		return <<<EOF
@prefix    rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix     dc: <http://purl.org/dc/elements/1.1/> .
@prefix dctype: <http://purl.org/dc/dcmitype/> .

<http://example.com/wiki/Talk:Modeling_test_article>
dc:title "Modeling test article";
dc:publisher "Test wiki";
dc:language "en"^^dc:ISO639-2;
dc:subject <http://example.com/wiki/Modeling_test_article>;
dc:type dctype:Text;
dc:format "text/html"^^dc:IMT;
dc:date "1970-01-01T00:00:01Z"^^dc:W3CDTF;
dc:creator "Real Name";
dc:rights <http://example.com/ns/copyright/> .

EOF;
	}

	public function expectedDCMESTurtle() {
		return <<<EOF
@prefix    rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix     dc: <http://purl.org/dc/elements/1.1/> .
@prefix dctype: <http://purl.org/dc/dcmitype/> .

<http://example.com/wiki/Modeling_test_article>
dc:title "Modeling test article";
dc:publisher "Test wiki";
dc:language "en"^^dc:ISO639-2;
dc:type dctype:Text;
dc:format "text/html"^^dc:IMT;
dc:date "1970-01-01T00:00:01Z"^^dc:W3CDTF;
dc:creator "Real Name";
dc:rights <http://example.com/ns/copyright/> .

<http://example.com/wiki/Talk:Modeling_test_article>
dc:subject <http://example.com/wiki/Modeling_test_article>.

EOF;
	}

	public function expectedDCMESTurtleWithContribs() {
		return <<<EOF
@prefix    rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix     dc: <http://purl.org/dc/elements/1.1/> .
@prefix dctype: <http://purl.org/dc/dcmitype/> .

<http://example.com/wiki/Modeling_test_article>
dc:title "Modeling test article";
dc:publisher "Test wiki";
dc:language "en"^^dc:ISO639-2;
dc:type dctype:Text;
dc:format "text/html"^^dc:IMT;
dc:date "1970-01-01T00:00:01Z"^^dc:W3CDTF;
dc:contributor "anonymous";
dc:contributor <http://example.com/wiki/User:TestUserWithoutRealName>;
dc:contributor "";
dc:creator "Real Name";
dc:rights <http://example.com/ns/copyright/> .

<http://example.com/wiki/Talk:Modeling_test_article>
dc:subject <http://example.com/wiki/Modeling_test_article>.

EOF;
	}


	public function expectedCcTurtle() {
		return <<<EOF
@prefix    rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix     dc: <http://purl.org/dc/elements/1.1/> .
@prefix dctype: <http://purl.org/dc/dcmitype/> .
@prefix     cc: <http://web.resource.org/cc/> .

<http://example.com/wiki/Modeling_test_article>
rdf:type cc:Work;
cc:license <http://example.com/ns/copyright/> .

<http://example.com/ns/copyright/>
rdf:type cc:License .

EOF;
	}

	public function expectedLinksFromTurtle() {
		return <<<EOF
@prefix    rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix     dc: <http://purl.org/dc/elements/1.1/> .
@prefix dctype: <http://purl.org/dc/dcmitype/> .
@prefix dcterms: <http://purl.org/dc/terms/> .
@prefix     cc: <http://web.resource.org/cc/> .

<http://example.com/wiki/Modeling_test_article>
dcterms:references <http://example.com/wiki/Link1>;
dcterms:references <http://example.com/wiki/Link2>;
dcterms:references <http://example.com/wiki/User:Page2>;
dcterms:references <http://example.com/wiki/User:Page1> .


EOF;
	}

	public function expectedImageTurtle() {
		return <<<EOF
@prefix    rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix     dc: <http://purl.org/dc/elements/1.1/> .
@prefix dctype: <http://purl.org/dc/dcmitype/> .
@prefix dcterms: <http://purl.org/dc/terms/> .
@prefix     cc: <http://web.resource.org/cc/> .

<http://example.com/wiki/Modeling_test_article>
dcterms:hasPart <http://example.com/wiki/Image:Some_image.png> .

<http://example.com/wiki/Image:Some_image.png>
dc:creator <http://example.com/wiki/User:TestUserWithRealName>;
dc:format "image/png"^^dc:IMT;
dc:date "1970-01-01T00:00:01Z"^^dc:W3CDTF;
dc:contributor "anonymous";
dc:contributor "Real Name";
dc:type dctype:Image .

EOF;
	}


	public function expectedHistoryTurtle() {
		return <<<EOF
@prefix    rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix     dc: <http://purl.org/dc/elements/1.1/> .
@prefix dctype: <http://purl.org/dc/dcmitype/> .
@prefix dcterms: <http://purl.org/dc/terms/> .
@prefix     cc: <http://web.resource.org/cc/> .

<http://example.com/wiki/Modeling_test_article>
dcterms:hasVersion <http://example.com/wiki/Modeling_test_article?oldid=0> .

<http://example.com/wiki/Modeling_test_article?oldid=0>
dcterms:isVersionOf <http://example.com/wiki/Modeling_test_article>;
dc:creator "anonymous";
dc:date "1970-01-01T00:00:01Z"^^dc:W3CDTF;
dc:language "en"^^dc:ISO639-2 .

EOF;
	}

	public function expectedDefaultSpecialPageTurtle() {
		return <<<EOF
@prefix    rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix     dc: <http://purl.org/dc/elements/1.1/> .
@prefix dctype: <http://purl.org/dc/dcmitype/> .
@prefix dcterms: <http://purl.org/dc/terms/> .

<http://example.com/wiki/Modeling_test_article>
dc:title "Modeling test article";
dc:publisher "Test wiki";
dc:language "en"^^dc:ISO639-2;
dc:type dctype:Text;
dc:format "text/html"^^dc:IMT;
dc:date "1970-01-01T00:00:01Z"^^dc:W3CDTF;
dc:creator "Real Name";
dc:rights <http://example.com/ns/copyright/>;
dcterms:references <http://example.com/wiki/Link1>;
dcterms:references <http://example.com/wiki/Link2>;
dcterms:references <http://example.com/wiki/User:Page2>;
dcterms:references <http://example.com/wiki/User:Page1> .

<http://example.com/wiki/Talk:Modeling_test_article>
dc:subject <http://example.com/wiki/Modeling_test_article>.

EOF;
	}

	public function interwikiWikitext() {
		return <<<EOF
[[fr:Modeling_test_article]]
[[de:Modeling_test_article]]
[[wp:Modeling_test_article]]

EOF;
	}

	public function expectedInterwikiTurtle() {
		return <<<EOF
@prefix    rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix    rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
@prefix     dc: <http://purl.org/dc/elements/1.1/> .
@prefix dctype: <http://purl.org/dc/dcmitype/> .
@prefix dcterms: <http://purl.org/dc/terms/> .
@prefix     cc: <http://web.resource.org/cc/> .

<http://example.com/wiki/Modeling_test_article>
dcterms:hasVersion <http://example.com/wiki/fr/Modeling_test_article>;
dcterms:hasVersion <http://example.com/wiki/de/Modeling_test_article>;
rdfs:seeAlso <http://en.wikipedia.org/Modeling_test_article> .

<http://example.com/wiki/fr/Modeling_test_article>
dc:language "fr"^^dc:ISO639-2 .

<http://example.com/wiki/de/Modeling_test_article>
dc:language "de"^^dc:ISO639-2 .

EOF;
	}

	public function expectedCategoriesTurtle() {
		return <<<EOF
@prefix    rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix     dc: <http://purl.org/dc/elements/1.1/> .
@prefix dctype: <http://purl.org/dc/dcmitype/> .
@prefix dcterms: <http://purl.org/dc/terms/> .
@prefix     cc: <http://web.resource.org/cc/> .
@prefix    cat: <http://example.com/wiki/Category:> .

<http://example.com/wiki/Modeling_test_article>
dc:subject cat:Red, cat:Green, cat:Blue .

EOF;
	}

	public function badTitleText() {
		return "";
	}

	public function createTestArticle( $title_text, $text,
	$cats, $user,
	$contribs = array() ) {
		$title = new Title( $title_text );
		$title->setParentCategories( $cats );
		$article = new Article( $title);
		$article->setContent( $text );
		$article->setUser( $user );
		foreach ( $contribs as $user ) {
			$article->addContributor( $user );
		}
		return $article;
	}

	public function createTalkPage() {
		$title = new Title( "Talk:Modeling test article");
		$user = self::createUserWithRealName();
		$article = new Article( $title );
		$article->setContent( " " );
		$article->setUser( $user );
		return $article;
	}

	public function createStorageTestArticle() {
		$text = self::InPageWikitext();
		$title = new Title( "Storage test article");
		$cats = array( "Category:Red", "Category:Blue" );
		$title->setParentCategories( $cats );
		$article = new Article( $title );
		$article->setContent( $text );
		$user = self::createUserWithRealName();
		$article->setUser( $user );
		return $article;
	}

	public function createspecialpagetestarticle() {
		$text = self::InPageWikitext();
		$title = new Title( "Modeling test article");
		$cats = array( "Category:Red", "Category:Blue" );
		$title->setParentCategories( $cats );
		$article = new Article( $title );
		$article->setContent( $text );
		$user = new User(2);
		$article->setUser( $user );
		return $article;
	}

	public function createTestTitle( $text ) {
		return new Title( $text );
	}

	public function createExpectedModel( $text ) {
		$model = MwRdf::Model();
		$parser = MwRdf::Parser('turtle');
		$model->loadStatementsFromString( $parser, $text );
		return $model;
	}

	public function createExpectedDefaultSpecialPageModel() {
		return self::createExpectedModel( self::expectedDefaultSpecialPageTurtle() );
	}

	public function createExpectedInPageModel() {
		return self::createExpectedModel( self::expectedInPageTurtle() );
	}

	public function createExpectedTalkDcmesModel() {
		return self::createExpectedModel( self::expectedTalkDCMESTurtle() );
	}

	public function createExpectedDcmesModel() {
		return self::createExpectedModel( self::expectedDCMESTurtle() );
	}

	public function createExpectedDcmesModelWithContributors() {
		return self::createExpectedModel( self::expectedDCMESTurtleWithContribs() );
	}

	public function createExpectedCcModel() {
		return self::createExpectedModel( self::expectedCCTurtle() );
	}

	public function createExpectedLinksFromModel() {
		return self::createExpectedModel( self::expectedLinksFromTurtle() );
	}

	public function createExpectedImageModel() {
		return self::createExpectedModel( self::expectedImageTurtle() );
	}

	public function createExpectedHistoryModel() {
		return self::createExpectedModel( self::expectedHistoryTurtle() );
	}

	public function createExpectedInterwikiModel() {
		return self::createExpectedModel( self::expectedInterwikiTurtle() );
	}

	public function createExpectedCategoriesModel() {
		return self::createExpectedModel( self::expectedCategoriesTurtle() );
	}

	public function createAnonymousUser() {
		return new User(0); // mock User class
	}
	public function createUserWithoutRealNameWithPage() {
		return new User(1);
	}

	public function CreateUserWithoutRealNameWithPage_PageNode() {
		$user = new User(1);
		$page = $user->getUserPage();
		return MwRdf::UriNode( $page->getFullUrl() );
	}

	public function createUserWithoutRealNameOrPage() {
		return new User(3);
	}

	public function createUserWithRealName() {
		return new User(2);
	}

	public function setupGlobals() {
		global $wgRightsPage, $wgRightsUrl;
		$wgRightsPage = null;
		$wgRightsUrl = 'http://example.com/ns/copyright/';
	}

	public function setupStorage() {
		global $wgRdfStoreType, $wgRdfStoreName, $wgRdfStoreOptions;
		$tmpdir = "/tmp/mwrdftest";
		if ( ! is_dir( $tmpdir ) ) mkdir($tmpdir);
		$wgRdfStoreType = "hashes";
		$wgRdfStoreName = 'mwrdfteststore' . time();
		$wgRdfStoreOptions = "hash-type='bdb',dir='$tmpdir',contexts='yes'";
		MwRdf::ReloadConfiguration();
		MwRdf::Store();
	}

	public function clearHooks() {
		global $wgHooks;
		if ( isset( $wgHooks['ArticleSave' ] ) ) {
			$key = array_search( 'MwRdfOnArticleSave', $wgHooks['ArticleSave'] );
			unset( $wgHooks['ArticleSave'][$key] );
		}
		if ( isset( $wgHooks['ArticleSaveComplete' ] ) ) {
			$key = array_search( 'MwRdfOnArticleSaveComplete', $wgHooks['ArticleSaveComplete'] );
			unset( $wgHooks['ArticleSaveComplete'][$key] );
		}
		if ( isset( $wgHooks['TitleMoveComplete' ] ) ) {
			$key = array_search( 'MwRdfOnTitleMoveComplete', $wgHooks['TitleMoveComplete'] );
			unset( $wgHooks['TitleMoveComplete'][$key] );
		}
		if ( isset( $wgHooks['ArticleDeleteComplete' ] ) ) {
			$key = array_search( 'MwRdfOnArticleDeleteComplete', $wgHooks['ArticleDeleteComplete'] );
			unset( $wgHooks['DeleteComplete'][$key] );
		}
	}
}

class MwRdfTestCase extends PHPUnit_Framework_TestCase {

	public function assertInstanceOf( $object, $class, $message = null ) {
		if ( ! is_object( $object ) )
		$this->fail( "First arg is not an object\n" . $message );
		if ( ! $object instanceof $class )
		$this->fail( "$object is not an instance of $class\n" . $message );
	}

	public function assertEqualsUnorderedTitlesLists( $list1, $list2, $message = null ) {
		if ( count( $list1 ) != count( $list2 ) )
		$this->fail( "Failed asserting that two lists of titles are the same:"
		. "they have different lengths.\n$message" );
		foreach ( $list1 as $title ) {
			$match = false;
			$url = $title->getFullUrl();
			$debug = "";
			foreach ( $list2 as $t ) {
				if ( $t->getFullUrl() == $url ) {
					$match = true;
				} else {
					$debug .= "\n" . $t->getFullUrl();
				}
			}

			if ( ! $match ) $this->fail( "Failed asserting that two lists of titles"
				. " are the same: did not find $url in "
				. "$debug\n$message" );
		}
	}

	public function assertNodesAreEquivalent( $node1, $node2, $message = null ) {
		$this->assertInstanceOf( $node1, "LibRDF_Node",
			"First argument to assertNodesAreEquivalent is not a Node\n$message" );
		$this->assertInstanceOf( $node2, "LibRDF_Node",
			"Second argument to assertNodesAreEquivalent is not a Node\n$message" );
		if ( get_class( $node1 ) != get_class( $node2 ) )
		$this->fail(  "Failed asserting that a " . get_class( $node1 )
			. " is equivalent to a " . get_class( $node2 ) . "\n$message" );
		$this->assertEquals( "$node1", "$node2", $message );
	}

	public function assertModelHasContext( $model, $context, $message = null ) {
		$i = $model->findStatements( null, null, null, $context );

		if ( ! $i->current() )
			$this->fail( $message );
	}

	public function assertModelHasStatement( $model, $statement, $message = null ) {
		$s = $statement->getSubject();
		$p = $statement->getPredicate();
		$o = $statement->getObject();
		$i = $model->findStatements( $s, $p, $o );
		if ( ! $i->current() )
			$this->fail( $message );
	}

	public function assertModelHasStatementInContext( $model, $statement,
	$context, $message = null ) {
		$s = $statement->getSubject();
		$p = $statement->getPredicate();
		$o = $statement->getObject();
		$i = $model->findStatements( $s, $p, $o, $context );

		if ( ! $i->current() )
			$this->fail( $message );
	}

	public function assertModelContainsModel( $model, $submodel, $message = null ) {
		$turtle = $submodel->serializeStatements( MwRdf::Serializer('turtle') );
		$sparql = MwRdf::turtleToSparql( $turtle );
		$query = new LibRDF_Query( $sparql, null, "sparql" );
		$res = $query->execute( $model );

		if ( ! ( $res && $res->getValue() == true ) ) {
			$turtle = $model->serializeStatements( MwRdf::Serializer('turtle') );
			$this->fail( "Model:\n$turtle\nSearch:\n$sparql\n$message" );
		}
	}

	public function assertModelContainsModelInContext( $model, $submodel, $context, $message = null ) {
		$cmodel = MwRdf::Model();

		foreach ( $model->findStatements( null, null, null, $context ) as $s ) {
			$cmodel->addStatement( $s );
		}

		$turtle = $submodel->serializeStatements( MwRdf::Serializer('turtle') );
		$sparql = MwRdf::turtleToSparql( $turtle );
		$query = new LibRDF_Query( $sparql, null, "sparql" );
		$res = $query->execute( $cmodel );

		if ( ! ( $res && $res->getValue() == true ) ) {
			$turtle = $model->serializeStatements( MwRdf::Serializer('turtle') );
			$this->fail( "Model:\n$turtle\nSearch:\n$sparql\n$message" );
		}
	}

	public function assertModelEqualsModel( $expected_model, $model, $message = null ) {
		$e_turtle = $expected_model->serializeStatements( MwRdf::Serializer('turtle') );
		$a_turtle = $model->serializeStatements( MwRdf::Serializer('turtle') );

		if ( $e_turtle == $a_turtle )
			return true; // don't bother querying if the strings match

		$sparql = MwRdf::turtleToSparql( $e_turtle );
		$query = new LibRDF_Query( $sparql, null, "sparql" );
		$res = $query->execute( $model );

		if ( ! ( $res && $res->getValue() == true ) ) {
			$turtle = $model->serializeStatements( MwRdf::Serializer('turtle') );
			$this->fail( "Expected:\n$e_turtle\nActual:\n$a_turtle\n$message" );
		}

		$sparql = MwRdf::turtleToSparql( $a_turtle );
		$query = new LibRDF_Query( $sparql, null, "sparql" );
		$res = $query->execute( $model );

		if ( ! ( $res && $res->getValue() == true ) ) {
			$turtle = $model->serializeStatements( MwRdf::Serializer('turtle') );
			$this->fail( "Expected:\n$e_turtle\nActual:\n$a_turtle\n$message" );
		}
	}

	public function assertEqualsNodeArrays( $expected, $actual, $message = null ) {
		if ( count( $expected ) != count( $actual ) )
			$this->fail( "The expected array and actuall array are different sizes"
				. $message );

		for ( $i = 0; $i < count( $expected ); $i++) {
			if ( ! $expected[$i] instanceof LibRDF_Node )
				$this->fail( "Element $i of the expected array is not a Node"
					. $message );

			if ( ! $actual[$i] instanceof LibRDF_Node )
				$this->fail( "Element $i of the actual array is not a Node"
					. $message );

			if ( "{$actual[$i]}" != "{$expected[$i]}" )
				$this->fail( "The arrays contain non-matching nodes\n"
					. "expected: {$expected[$i]}\n"
					. "actual:   {$actual[$i]}\n"
					. $message );
		}
	}

	public function assertStringIsParsableTurtle( $string ) {
		$parser = MwRdf::Parser( 'turtle' );
		$model = MwRdf::Model();
		try {
			$model->loadStatementsFromString( $parser, $text );
		} catch ( Exception $e ) {
			$this->fail( "Could not parse string as turtle:\n$text\n" );
		}
	}

	public function assertStringIsParsableRDFXML( $text ) {
		$parser = MwRdf::Parser( 'rdfxml' );
		$model = MwRdf::Model();
		try {
			$model->loadStatementsFromString( $parser, $text );
		} catch ( Exception $e ) {
			$this->fail( "Could not parse string as RDFXML:\n$text\n" );
		}
	}

	public function assertStringIsParsableTriples( $text ) {
		$parser = MwRdf::Parser( 'ntriples' );
		$model = MwRdf::Model();
		try {
			$model->loadStatementsFromString( $parser, $text );
		} catch ( Exception $e ) {
			$this->fail( "Could not parse string as RDFXML:\n$text\n" );
		}
	}

	public function assertStringIsParsableSPARQL( $text ) {
		try {
			MwRdf::Query( $text, null, 'sparql' );
		} catch ( Exception $e ) {
			$this->fail( "Could not parse string as SPARQL:\n$text\n" );
		}
	}
}

class MwRdfTestTest extends MwRdfTestCase {

	private $agent;

	public function setUp() {
		MwRdfTest::setupStorage();
		$this->agent = MwRdfTest::createModelingAgent( 'InPage Test', MwRdfTest::InPageWikitext() );
		$this->agent->registerModelMaker( 'MwRdf_InPage_Modeler' );
		$this->agent->registerModelMaker( 'MwRdf_Categories_Modeler' );
	}

	public function testTestMockArticleGetContent() {
		$article = new Article( 'some title', 'some text' );
		$text = $article->getContent();
		$this->assertEquals( 'some text', $text );
	}

	public function testTestMockArticleGetTitle() {
		$article = new Article( 'some title', 'some text' );
		$title = $article->getTitle();
		$text = $title->getText();
		$this->assertEquals( 'Some title', $text );
	}

	public function testTestMockArticleInModelingAgent() {
		$text = $this->agent->getArticle()->getContent( true );
		$this->assertEquals( MwRdfTest::InPageWikitext(), $text );
	}

	public function testTestCreateModel() {
		$model = $this->agent->buildModel( 'inpage' );
		$statement = $model->current();
		$this->assertNotNull( $statement );
	}
}
