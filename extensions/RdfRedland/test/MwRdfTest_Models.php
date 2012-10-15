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

require_once( 'includes/ContLang.php' );

class MwRdf_ModelingAgent_Test extends MwRdfTestCase {

	protected static $agent;

	protected function setUp() {
		MwRdfTest::setupGlobals();
		MwRdf::RegisterVocabulary( 'rdf', "MwRdf_Vocabulary_Rdf" );
		MwRdf::RegisterVocabulary( 'dc', "MwRdf_Vocabulary_DCmes" );
		MwRdf::RegisterVocabulary( 'dcterms', "MwRdf_Vocabulary_DcTerms" );
		MwRdf::RegisterVocabulary( 'dctype', "MwRdf_Vocabulary_DcMiType" );
		MwRdf::registerVocabulary( "cc", "MwRdf_Vocabulary_CreativeCommons" );
		MwRdf::registerVocabulary( "rdfs", "MwRdf_Vocabulary_RdfSchema" );
		$cats = array( 'TestPages', 'StorageTests' );
		$user = new User(2);
		$article = MwRdfTest::createTestArticle( 'Modeling test article',
		MwRdfTest::InPageWikitext(), $cats, $user );
		$this->agent = MwRdf::ModelingAgent( $article );
		$this->agent->unregisterModelMakers();
	}

	public function testRegisterModelMaker() {
		$names = $this->agent->listModelNames();
		$this->assertType( 'array', $names );
		$this->assertFalse( isset( $names[0] ), 'should be empty' );
		$this->agent->registerModelMaker( 'MwRdf_InPage_Modeler' );
		$names = $this->agent->listModelNames();
		$this->assertType( 'array', $names );
		$this->assertContains( 'inpage', $names );
	}

	public function testInPageRdf() {
		$this->agent->RegisterModelMaker( 'MwRdf_InPage_Modeler' );
		$model = $this->agent->buildModel( 'inpage' );
		$expected_model = MwRdfTest::createExpectedInPageModel();
		$this->assertModelEqualsModel( $expected_model, $model );
	}

	public function testToResource() {
		$title = MwRdfTest::createTestTitle( 'SomeRandomTitle' );
		$agent = MwRdf::ModelingAgent( $title );
		$res = $agent->titleResource();
		$this->assertTrue( $res instanceof LibRDF_URINode, get_class( $res ) );
	}

	public function testTimestamp() {
		$res = $this->agent->getTimestampResource();
		$this->assertTrue( $res instanceof LibRDF_LiteralNode, get_class( $res ) );
		$ns = MwRdf::getNamespace( 'dc' );
		$this->assertEquals( $ns . 'W3CDTF', $res->getDatatype() );
	}

	public function testMediaType() {
		$lang = MwRdf::MediaType( 'text/html' );
		$this->assertTrue( $lang instanceof LibRDF_LiteralNode );
		$ns = MwRdf::getNamespace( 'dc' );
		$this->assertEquals( $ns . 'IMT', $lang->getDatatype() );
		$this->assertEquals( "text/html^^<{$ns}IMT>", "$lang" );
	}

	public function testDcmesModel_ArticleWithSoleContributor() {
		$this->agent->registerModelMaker( 'MwRdf_DCmes_Modeler' );
		$model = $this->agent->buildModel( 'dcmes' );
		$this->assertTrue( $model instanceof LibRDF_Model, "$model" );
		$expect = MwRdfTest::createExpectedDcmesModel();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testDcmesModel_TalkPageWithSoleContributor() {
		$article = MwRdfTest::createTalkPage();
		$this->agent = MwRdf::ModelingAgent( $article );
		$this->agent->registerModelMaker( 'MwRdf_DCmes_Modeler' );
		$model = $this->agent->buildModel( 'dcmes' );
		$this->assertTrue( $model instanceof LibRDF_Model, "$model" );
		$expect = MwRdfTest::createExpectedTalkDcmesModel();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testDCmesModel_ArticleWithAllSortsOfContributors() {
		$article = $this->agent->getArticle();
		$article->addContributor( MwRdfTest::createAnonymousUser() );
		$article->addContributor( MwRdfTest::createUserWithoutRealNameWithPage() );
		$article->addContributor( MwRdfTest::createUserWithoutRealnameOrPage() );
		$this->agent->registerModelMaker( 'MwRdf_DCmes_Modeler' );
		$model = $this->agent->buildModel( 'dcmes' );
		$expect = MwRdfTest::createExpectedDcmesModelWithContributors();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testGetContributorsAsResources() {
		$article = $this->agent->getArticle();
		$article->addContributor( MwRdfTest::createAnonymousUser() );
		$article->addContributor( MwRdfTest::createUserWithoutRealNameWithPage() );
		$article->addContributor( MwRdfTest::createUserWithoutRealnameOrPage() );
		$contribs = $this->agent->getContributorResources();
		$this->assertType( 'array', $contribs );
		$this->assertTrue( count( $contribs ) == 3,
		"Number of contribs (" . count( $contribs )
		. ") should be 3 or greater." );
		foreach ( $contribs as $c ) {
			$this->assertTrue( is_subclass_of( $c, 'LibRDF_Node' ) );
		}
	}

	public function testCCModel() {
		$this->agent->registerModelMaker( "MwRdf_CreativeCommons_Modeler" );
		$model = $this->agent->buildModel( 'cc' );
		$this->assertType( 'object', $model, gettype( $model ) );
		$this->assertInstanceOf( $model, "LibRDF_Model" );
		$expect = MwRdfTest::createExpectedCcModel();
		$this->assertModelEqualsModel( $expect, $model );

	}

	public function testFetchLinkedTitles() {
		$dcterms = MwRdf::Vocabulary( 'dcterms' );
		$linked =  $this->agent->getLinkedTitles();
		$this->assertType( 'array', $linked );
		$expect = array(
		Title::newFromText( 'Link1' ),
		Title::newFromText( 'Link2' ),
		Title::newFromText( 'User:Page1' ),
		Title::newFromText( 'User:Page2' ) );
		$this->assertEqualsUnorderedTitlesLists( $expect, $linked );
	}

	public function testLinksFromModel() {
		$this->agent->registerModelMaker( 'MwRdf_LinksFrom_Modeler' );
		$model = $this->agent->buildModel( 'linksfrom' );
		$expect = MwRdfTest::createExpectedLinksFromModel();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testImageModel() {
		$this->agent->registerModelMaker( 'MwRdf_Image_Modeler' );
		$model = $this->agent->buildModel( 'image' );
		$this->assertType( 'object', $model, gettype( $model ) );
		$this->assertInstanceOf( $model, "LibRDF_Model", get_class( $model ) );
		$expect = MwRdfTest::createExpectedImageModel();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testHistoryModel() {
		$this->agent->registerModelMaker( 'MwRdf_History_Modeler' );
		$model = $this->agent->buildModel( 'history' );
		$expect = MwRdfTest::createExpectedHistoryModel();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testInterwikiModel() {
		global $wgContLang;
		$wgContLang = new Language();
		$wikitext = MwRdfTest::interwikiWikitext();
		$this->agent->getArticle()->setContent( $wikitext );
		$this->agent->registerModelMaker( 'MwRdf_Interwiki_Modeler' );
		$model = $this->agent->buildModel( 'interwiki' );
		$expect = MwRdfTest::createExpectedInterwikiModel();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testCateogriesModel() {
		$title = $this->agent->getArticle()->getTitle();
		$title->setParentCategories( array( "Category:Red",
		"Category:Green",
		"Category:Blue" ));
		$this->agent->registerModelMaker( 'MwRdf_Categories_Modeler' );
		$model = $this->agent->buildModel( 'categories');
		$expect = MwRdfTest::createExpectedCategoriesModel();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testContextNode() {
		$modelname = time();
		$context = $this->agent->getContextNode( $modelname );
		$this->assertType( 'object', $context, gettype( $context ) );
		$this->assertTrue( $context instanceof LibRDF_UriNode,
		get_class( $context ) );
		$this->assertRegExp( "/#$modelname(\?|\])/", "$context" );
	}

	public function testListDefaultModels() {
		$this->agent->registerModelMaker( 'MwRdf_InPage_Modeler' );  # no
		$this->agent->registerModelMaker( 'MwRdf_DCmes_Modeler' ); # yes
		$this->agent->registerModelMaker( 'MwRdf_LinksFrom_Modeler' ); # yes
		$expect = array( 'dcmes', 'linksfrom' );
		$list = $this->agent->listDefaultModels();
		$this->assertType( 'array', $list );
		$this->assertEquals( $expect, $list );
	}
}

class MwRdfTest_NonExistantArticle_ModelingTests {

	public function testTimestamp() {
		$this->markTestIncomplete();
		$pagename = self::$username . '/NonArticle';
		$title = Title::newFromText( $pagename, NS_USER );
		if ( $title->exists() ) {
			$article = new Article( $title );
			$article->doPurge();
		}
		$agent = MwRdf::ModelingAgent( $title );
		$this->assertType( 'boolean', $agent->getTimestampResource() );
		$this->assertFalse( $agent->getTimestampResource() );
	}
}
