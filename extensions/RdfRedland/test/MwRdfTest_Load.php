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

class MwRdf_Load_Test extends PHPUnit_Framework_TestCase {

	public $title;

	public function setUp() {
		MwRdf::$store_options = MwRdf::$store_options . ',new=yes';
		$pagename = MwRdfTest::$username . '/Special page test page';
		$wikitext = <<<EOT
		<rdf>
		@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
		@prefix dc: <http://purl.org/dc/elements/1.1/> .
		@prefix ex: <http://example.org/stuff/1.0/> .

		<http://www.w3.org/TR/rdf-syntax-grammar>
		dc:title "RDF/XML Syntax Specification (Revised)" ;
		ex:editor [
		ex:fullname "Dave Beckett";
		ex:homePage <http://purl.org/net/dajobe/>
		] .
		</rdf>

		[[Main Page]]

		[[category:Test]] [[category:Rdf]]

EOT;
		MwRdf_ModelingAgent_Test::setPageText( $pagename, $wikitext );
		$this->title = Title::newFromText( $pagename, NS_USER );
	}

	public function testLoad() {
		$agent = MwRdf::ModelingAgent( $this->title );
		for ( $i = 0; $i < 10000; $i++ ) {
			$model = $agent->retrieveModel( 'inpage' );
			$this->assertType( 'object', $model );
			$this->assertTrue( $model instanceof LibRDF_Model );
			$statement = MwRdf::Statement(
			MwRdf::UriNode( 'http://www.w3.org/TR/rdf-syntax-grammar' ),
			MwRdf::UriNode( 'http://purl.org/dc/elements/1.1/title' ),
			MwRdf::LiteralNode( 'RDF/XML Syntax Specification (Revised)' ) );
			$this->assertTrue( $model->hasStatement( $statement ) );
			$statements = $model->findStatements(
			MwRdf::UriNode( 'http://www.w3.org/TR/rdf-syntax-grammar' ),
			MwRdf::UriNode( 'http://example.org/stuff/1.0/editor' ),
			null );
			$this->assertType( 'object', $statements );
			$this->assertTrue( $statements instanceof LibRDF_StreamIterator );
			$statement = $statements->current();
			$this->assertTrue( $statement instanceof LibRdf_Statement );
			$editor = $statement->getObject();
			$this->assertTrue( $editor instanceof LibRdf_BlankNode );
			$statement = MwRdf::Statement(
			$editor,
			MwRdf::UriNode( 'http://example.org/stuff/1.0/fullname' ),
			MwRdf::LiteralNode( "Dave Beckett" ) );
			$this->assertTrue( $model->hasStatement( $statement ) );
			$statement = MwRdf::Statement(
			$editor,
			MwRdf::UriNode( 'http://example.org/stuff/1.0/homePage' ),
			MwRdf::UriNode( 'http://purl.org/net/dajobe/' ) );
			$this->assertTrue( $model->hasStatement( $statement ) );
			$model->rewind();
		}
	}
}
