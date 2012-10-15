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

class MwRdfTest_Framework extends MwRdfTestCase {

	protected $fixture;
	public static $username = 'RdfTestUser';
	public static $nopage_user = 'PagelessUser';

	public function setUp() {
		MwRdfTest::setupStorage();
	}

	public function testStorage() {
		$s = MwRdf::Store();
		$this->assertInstanceOf( $s, "LibRdf_Storage" );
	}

	public function testTerms() {
		MwRdf::registerVocabulary( "rdf", "MwRdf_Vocabulary_Rdf" );
		$rdf = MwRdf::Vocabulary( 'rdf' );
		$this->assertInstanceOf( $rdf, "MwRdf_Vocabulary_Rdf" );
		$ns = "http://www.w3.org/1999/02/22-rdf-syntax-ns#";
		$this->assertEquals( $ns, $rdf->getNS() );
		$this->assertEquals( "[{$ns}type]", $rdf->type->__toString(), 'check type' );
		$this->assertInstanceOf( $rdf->a, "LibRDF_Node" );
		$this->assertEquals( "[{$ns}type]", $rdf->a->__toString() );
	}

	public function testRegisterVocabulary() {
		MwRdf::RegisterVocabulary( 'TestVocab', 'TestVocabularyClass' );
		$ns = 'http://example.com/test/';
		$tv = MwRdf::Vocabulary( 'TestVocab' );
		$this->assertInstanceOf( $tv->Left, "LibRDF_UriNode" );
		$this->assertEquals( "[{$ns}Left]", $tv->Left->__toString() );
		$this->assertTrue( $tv->Right instanceof LibRDF_UriNode );
		$this->assertEquals( "[{$ns}Right]", $tv->Right->__toString() );
		$this->assertTrue( $tv->Over instanceof LibRDF_UriNode );
		$this->assertEquals( "[{$ns}Over]", $tv->Over->__toString() );
		$this->assertTrue( $tv->Under instanceof LibRDF_UriNode );
		$this->assertEquals( "[{$ns}Under]", $tv->Under->__toString() );
	}

	public function testCC() {
		MwRdf::registerVocabulary( "cc", "MwRdf_Vocabulary_CreativeCommons" );
		$cc = MwRdf::Vocabulary( "cc" );
		$this->assertType( 'object', $cc );
		$ns = "http://web.resource.org/cc/";
		$this->assertEquals( $ns, $cc->getNS() );
		$this->assertTrue( $cc->Work instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}Work]", $cc->Work->__toString() );
		$this->assertTrue( $cc->Agent instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}Agent]", $cc->Agent->__toString() );
		$this->assertTrue( $cc->License instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}License]", $cc->License->__toString() );
		$this->assertTrue( $cc->Permission instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}Permission]", $cc->Permission->__toString() );
		$this->assertTrue( $cc->Requirement instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}Requirement]", $cc->Requirement->__toString() );
		$this->assertTrue( $cc->Prohibition instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}Prohibition]", $cc->Prohibition->__toString() );
		$this->assertTrue( $cc->PublicDomain instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}PublicDomain]", $cc->PublicDomain->__toString() );
		$this->assertTrue( $cc->Reproduction instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}Reproduction]", $cc->Reproduction->__toString() );
		$this->assertTrue( $cc->Distribution instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}Distribution]", $cc->Distribution->__toString() );
		$this->assertTrue( $cc->DerivativeWorks instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}DerivativeWorks]", $cc->DerivativeWorks->__toString() );
		$this->assertTrue( $cc->Notice instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}Notice]", $cc->Notice->__toString() );
		$this->assertTrue( $cc->Attribution instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}Attribution]", $cc->Attribution->__toString() );
		$this->assertTrue( $cc->SourceCode instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}SourceCode]", $cc->SourceCode->__toString() );
		$this->assertTrue( $cc->CommercialUse instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}CommercialUse]", $cc->CommercialUse->__toString() );
		$this->assertTrue( $cc->license instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}license]", $cc->license->__toString() );
		$this->assertTrue( $cc->permits instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}permits]", $cc->permits->__toString() );
		$this->assertTrue( $cc->requires instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}requires]", $cc->requires->__toString() );
		$this->assertTrue( $cc->prohibits instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}prohibits]", $cc->prohibits->__toString() );
		$this->assertTrue( $cc->derivativeWork instanceof LibRDF_Node );
		$this->assertEquals( "[{$ns}derivativeWork]", $cc->derivativeWork->__toString() );
	}

	public function testModelingAgent() {
		$t = Title::newFromText( 'This is a test' );
		$agent = MwRdf::ModelingAgent( $t );
		$title = $agent->getTitle();
		$article = $agent->getArticle();
		$this->assertTrue( $agent instanceof MwRdf_ModelingAgent );
		$this->assertTrue( $title instanceof Title );
		$this->assertTrue( $article instanceof Article );
		$this->assertEquals( $title->getDBkey(), $t->getDBkey() );
		$this->assertEquals( $title->getNamespace(), $t->getNamespace() );
		$this->assertEquals( $title->getDBkey(), $t->getDBkey() );
		$this->assertSame( $article->getTitle(), $title );

		$agent = MwRdf::ModelingAgent( $article );
		$title = $agent->getTitle();
		$article = $agent->getArticle();
		$this->assertTrue( $agent instanceof MwRdf_ModelingAgent );
		$this->assertTrue( $title instanceof Title );
		$this->assertTrue( $article instanceof Article );
	}

	public function testModelingAgentNoParameterException() {
		try {
			$agent = MwRdf::ModelingAgent();
		}
		catch (Exception $expected) {
			return;
		}
		$this->fail( 'ModelingAgent() should raise an exeption if called with no args.' );
	}

	public function testModelingAgentFromSpecialPageException() {
		$rc = Title::newFromText( 'Special:RecentChanges' );
		try {
			$agent = MwRdf::ModelingAgent( $rc );
		}
		catch (Exception $expected) {
			return;
		}
		$this->fail( 'ModelingAgent() should raise an exeption if called on a special page.' );
	}

	public function testModel() {
		$m = MwRdf::Model();
		$this->assertTrue( $m  instanceof LibRDF_Model );
	}

	public function testLiteralNode() {
		$n = MwRdf::LiteralNode( '' );
		$this->assertTrue( $n  instanceof LibRDF_LiteralNode );
		$this->assertEquals( null, $n->getDatatype() );
	}

	public function testTypedLiteral() {
		$ns = MwRdf::getNamespace( 'dc' );
		$n = MwRdf::LiteralNode( 'en', $ns . 'ISO639-2' );
		$this->assertTrue( $n  instanceof LibRDF_LiteralNode );
		$this->assertEquals( $ns . 'ISO639-2', $n->getDatatype() );
	}

	public function testUriNode() {
		$n = MwRdf::UriNode( 'http://example.com/test/' );
		$this->assertTrue( $n  instanceof LibRDF_UriNode );
	}

	public function testBlankNode() {
		$n = MwRdf::BlankNode( '01' );
		$this->assertTrue( $n  instanceof LibRDF_BlankNode );
	}

	public function testURI() {
		$uri = MwRdf::URI( 'http://example.com' );
		$this->assertTrue( $uri instanceof LibRDF_URI );
	}

	public function testStatementFromNodes() {
		$terms = MwRdf::Vocabulary( 'rdf' );
		$s = MwRdf::UriNode( 'http://example.org/ns/a2' );
		$p = MwRdf::UriNode( 'http://example.org/ns/b2' );
		$o = MwRdf::UriNode( 'http://example.org/ns/c2' );
		$statement = MwRdf::Statement( $s, $p, $o );
		$this->assertTrue( $statement instanceof LibRDF_Statement );
		$this->assertEquals(
		"{[http://example.org/ns/a2], [http://example.org/ns/b2], [http://example.org/ns/c2]}",
		"$statement");
	}

	public function testParser() {
		$o = MwRdf::Parser();
		$this->assertTrue( $o instanceof LibRDF_Parser );
	}

	public function testListVocabularies() {
		MwRdf::registerVocabulary( "rdf", "MwRdf_Vocabulary_Rdf" );
		MwRdf::registerVocabulary( "rdfs", "MwRdf_Vocabulary_RdfSchema" );
		MwRdf::registerVocabulary( "cc", "MwRdf_Vocabulary_CreativeCommons" );
		MwRdf::registerVocabulary( "dc", "MwRdf_Vocabulary_DCMES" );
		$this->assertType( 'array', MwRdf::ListVocabularies() );
		$this->assertContains( 'rdf', MwRdf::ListVocabularies() );
		$this->assertContains( 'rdfs', MwRdf::ListVocabularies() );
		$this->assertContains( 'cc', MwRdf::ListVocabularies() );
		$this->assertContains( 'dc', MwRdf::ListVocabularies() );
	}

	public function testGetRdfNamespace() {
		$this->assertEquals( 'http://www.w3.org/1999/02/22-rdf-syntax-ns#',
		MwRdf::getNamespace( 'rdf' ) );
		$this->assertEquals( 'http://www.w3.org/2000/01/rdf-schema#',
		MwRdf::getNamespace( 'rdfs' ) );
		$this->assertEquals( 'http://web.resource.org/cc/',
		MwRdf::getNamespace( 'cc' ) );
		$this->assertEquals( 'http://purl.org/dc/elements/1.1/',
		MwRdf::getNamespace( 'dc' ) );
	}

	public function testGetNamespacePrelude() {
		$this->assertType( 'string', MwRdf::getNamespacePrelude() );
		$parser = new LibRDF_Parser( 'turtle' );
		$i = $parser->parseString( MwRdf::getNamespacePrelude() );
		$this->assertTrue( $i instanceof LibRDF_StreamIterator, get_class( $i ) );
		// this should be a completely empty result, we're just proving it
		// can be parsed
		$this->assertNull( $i->current() );
		$this->assertNull( $i->next() );
	}

	public function testPageOrString() {
		$bad_title = '';
		$node = MwRdf::PageOrString( $bad_title, 'some text' );
		$this->assertInstanceOf( $node, "LibRdf_LiteralNode" );
		$this->assertEquals( 'some text', "$node" );
		$good_title = 'Main Page'; // FIXME are we sure this always exists?
		$node = MwRdf::PageOrString( $good_title, 'some text' );
		$this->assertTrue( $node instanceof LibRDF_UriNode );
		$title = Title::newFromText( 'Main Page' );
		$uri = $title->getFullUrl();
		$this->assertEquals( "[$uri]", "$node" );
	}

	public function testLanguage() {
		$lang = MwRdf::Language( 'en' );
		$this->assertTrue( $lang instanceof LibRDF_LiteralNode );
		$ns = MwRdf::getNamespace( 'dc' );
		$this->assertEquals( $ns . 'ISO639-2', $lang->getDatatype() );
		$this->assertEquals( "en^^<{$ns}ISO639-2>", "$lang" );
	}

	public function testPersonToResource_AllArgs_UserHasRealName() {
		$user = MwRdfTest::CreateUserWithRealName();
		$res = MwRdf::PersonToResource(
		$user->getID(), $user->getName(), $user->getRealName() );
		$this->assertInstanceOf( $res, "LibRDF_LiteralNode" );
		$this->assertEquals( 'Real Name', "$res" );
	}

	public function testPersonToResource_JustId_UserHasRealName() {
		$user = MwRdfTest::CreateUserWithRealName();
		$res = MwRdf::PersonToResource( $user->getID() );
		$this->assertInstanceOf( $res, "LibRDF_LiteralNode" );
		$this->assertEquals( 'Real Name', "$res" );
	}

	public function testPersonToResource_AllArgs_UserHasPageButNotRealName() {
		$user = MwRdfTest::CreateUserWithoutRealNameWithPage();
		$res = MwRdf::PersonToResource(
		$user->getID(), $user->getName(), $user->getRealName() );
		$expect = MwRdfTest::CreateUserWithoutRealNameWithPage_PageNode();
		$this->assertNodesAreEquivalent( $expect, $res );
	}

	public function testPersonToResource_JustId_UserHasPageButNotRealName() {
		$user = MwRdfTest::CreateUserWithoutRealNameWithPage();
		$res = MwRdf::PersonToResource( $user->getID() );
		$expect = MwRdfTest::CreateUserWithoutRealNameWithPage_PageNode();
		$this->assertNodesAreEquivalent( $expect, $res );
	}

	public function testPersonToResource_AllArgs_UserHasNeitherRealNameNorPage() {
		$user = MwRdfTest::CreateUserWithoutRealNameOrPage();
		$res = MwRdf::PersonToResource(
		$user->getID(), $user->getName(), $user->getRealName() );
		$this->assertTrue( $res instanceof LibRDF_LiteralNode );
		$this->assertEquals( wfMsg( 'siteuser', "MwRdfPagelessNamelessUser" ), "$res" );
	}

	public function testPersonToResource_JustId_UserHasNeitherRealNameNorPage() {
		$user = MwRdfTest::CreateUserWithoutRealNameOrPage();
		$res = MwRdf::PersonToResource( $user->getID() );
		$this->assertTrue( $res instanceof LibRDF_LiteralNode );
		$this->assertEquals( wfMsg( 'siteuser', "MwRdfPagelessNamelessUser" ), "$res" );
	}

	public function testPersonToResource_AnonymousUser() {
		$user = MwRdfTest::CreateAnonymousUser();
		$res = MwRdf::PersonToResource( 0, null, null );
		$this->assertTrue( $res instanceof LibRDF_LiteralNode );
		$this->assertEquals( 'anonymous', "$res" );
	}

	public function testRightsResource_Page() {
		global $wgRightsPage;
		// make sure the rights page exists
		$title = Title::newFromText( self::$username . '/Test Rights Page', NS_USER );
		$wgRightsPage = $title->getPrefixedText();
		if ( ! $title->exists() ) {
			$text = 'This is a test copyright page';
			$article = new Article( $title );
			$summary = 'Preparing article for unit test';
			$article->doEdit( $text, $summary );
		}
		$res = MwRdf::RightsResource();
		$this->assertTrue( $res instanceof LibRDF_UriNode,
		"got " . get_class( $res ) . " instead of resource." );
		$username = self::$username;
		$this->assertEquals( "[{$title->getFullUrl()}]", "$res" );
	}

	public function testRightsResource_UrlSettings() {
		global $wgRightsPage, $wgRightsUrl;
		$wgRightsPage = null;
		$wgRightsUrl = 'http://example.com/ns/copyright';
		$res = MwRdf::RightsResource();
		$this->assertTrue( $res instanceof LibRDF_UriNode );
		$this->assertEquals( "[http://example.com/ns/copyright]", "$res" );
	}

	public function testRightsResource_UrlTextSetting() {
		global $wgRightsPage, $wgRightsUrl, $wgRightsText;
		$wgRightsPage = null;
		$wgRightsUrl = null;
		$wgRightsText = 'This is not a copyright statement';
		$res = MwRdf::RightsResource();
		$this->assertTrue( $res instanceof LibRDF_LiteralNode );
		$this->assertEquals( "This is not a copyright statement", "$res" );
	}

	public function testRightsResource_NoSetting() {
		global $wgRightsPage, $wgRightsUrl, $wgRightsText;
		$wgRightsPage = null;
		$wgRightsUrl = null;
		$wgRightsText = null;
		$this->assertType( "boolean", MwRdf::RightsResource() );
		$this->assertFalse( MwRdf::RightsResource() );
	}

	public function testTimestampResource() {
		$res = MwRdf::TimestampResource( time() );
		$this->assertTrue( $res instanceof LibRDF_LiteralNode, get_class( $res ) );
		$ns = MwRdf::getNamespace( 'dc' );
		$this->assertEquals( $ns . 'W3CDTF', $res->getDatatype() );
	}


	public function testGetCcTerms() {

		$license =  'http://creativecommons.org/licenses/by-sa/1.0/';
		$terms = MwRdf::GetCcTerms( $license );
		$this->assertType( 'array', $terms, $license );
		$this->assertContains( 're', $terms );
		$this->assertContains( 'di', $terms );
		$this->assertContains( 'de', $terms );
		$this->assertContains( 'no', $terms );
		$this->assertContains( 'by', $terms );
		$this->assertContains( 'sa', $terms );

		$license =  'http://creativecommons.org/licenses/by-nc-sa/1.0/';
		$terms = MwRdf::GetCcTerms( $license );
		$this->assertType( 'array', $terms, $license );
		$this->assertContains( 're', $terms );
		$this->assertContains( 'di', $terms );
		$this->assertContains( 'de', $terms );
		$this->assertContains( 'no', $terms );
		$this->assertContains( 'by', $terms );
		$this->assertContains( 'sa', $terms );
		$this->assertContains( 'nc', $terms );

		$license =  'http://creativecommons.org/licenses/GPL/2.0/';
		$terms = MwRdf::GetCcTerms( $license );
		$this->assertType( 'array', $terms, $license );
		$this->assertContains( 'de', $terms );
		$this->assertContains( 're', $terms );
		$this->assertContains( 'di', $terms );
		$this->assertContains( 'no', $terms );
		$this->assertContains( 'sa', $terms );
		$this->assertContains( 'sc', $terms );

		$license =  'http://creativecommons.org/licenses/LGPL/2.1/';
		$terms = MwRdf::GetCcTerms( $license );
		$this->assertType( 'array', $terms, $license );
		$this->assertContains( 'de', $terms );
		$this->assertContains( 're', $terms );
		$this->assertContains( 'di', $terms );
		$this->assertContains( 'no', $terms );
		$this->assertContains( 'sa', $terms );
		$this->assertContains( 'sc', $terms );

		$license =  'http://www.gnu.org/copyleft/fdl.html';
		$terms = MwRdf::GetCcTerms( $license );
		$this->assertType( 'array', $terms, $license );
		$this->assertContains( 'de', $terms );
		$this->assertContains( 're', $terms );
		$this->assertContains( 'di', $terms );
		$this->assertContains( 'no', $terms );
		$this->assertContains( 'sa', $terms );
		$this->assertContains( 'sc', $terms );
	}
}
