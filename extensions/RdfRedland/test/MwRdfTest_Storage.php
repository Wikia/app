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

class MwRdfTest_Storage extends MwRdfTestCase {

	private $agent;

	public function setUp() {
		MwRdfTest::setupStorage();
		$article = MwRdfTest::createStorageTestArticle();
		$this->agent = MwRdf::ModelingAgent( $article );
		$this->agent->registerModelMaker( 'MwRdf_InPage_Modeler' );
		$this->agent->registerModelMaker( 'MwRdf_Categories_Modeler' );
		MwRdf::RegisterVocabulary( "dc", "MwRdf_Vocabulary_DCmes" );
	}

	public function testStoredModelCanStoreAStatement() {
		$model = $this->agent->buildModel( 'inpage' );
		$statement = $model->current();
		$store = MwRdf::StoredModel();
		$store->addStatement( $statement );
		$this->assertModelHasStatement( $store, $statement, $store );
	}

	public function testInPageContext() {
		$this->agent->storeModel( 'inpage' );
		$context = $this->agent->getContextNode( 'inpage' );
		$store = MwRdf::StoredModel();
		$this->assertModelHasContext( $store, $context,
		"Didn't find context ($context) in the stored model" );
	}

	public function testCategoriesContext() {
		$this->agent->storeModel( 'categories' );
		$context = $this->agent->getContextNode( 'categories' );
		$store = MwRdf::StoredModel();
		$this->assertModelHasContext( $store, $context,
		"Didn't find context $context in the stored model" );
	}

	public function testInPageModelTurnsUpInStoredModel() {
		$this->agent->storeModel( 'inpage' );
		$store = MwRdf::StoredModel();
		# strip contexts (expensive for larger stores, fine here)
		$smodel = MwRdf::Model();
		foreach ( $store as $s ) {
			$smodel->addStatement( $s );
		}
		$store->rewind();
		$model = $this->agent->buildModel( 'inpage' );
		$this->assertModelContainsModel( $smodel, $model,
		"The inpage RDF model has not been successfully stored and retrieved." );
	}

	public function testThatTheInPageModelIsStoredCorrectlyInContext() {
		$this->agent->storeModel( 'inpage' );
		$store = MwRdf::StoredModel();
		$context = $this->agent->getContextNode( 'inpage' );
		$model = $this->agent->buildModel( 'inpage' );
		$this->assertModelContainsModelInContext( $store, $model, $context,
		"The inpage RDF model has not been successfully stored and retrieved." );
	}

	public function testQueryProducesExpectedModel() {
		$this->agent->storeModel( 'inpage' );
		$model = $this->agent->retrieveModel( 'inpage' );
		$expect = MwRdfTest::createExpectedInPageModel();
		$this->assertModelEqualsModel( $expect, $model );
	}

	public function testStoreInPageModelMemoryUsage() {
		$expected = memory_get_usage( true );
		$this->agent->storeModel( 'inpage' );
		$actual = memory_get_usage( true );
		$this->assertEquals( $expected, $actual );
	}

	public function testStoreInterwikiModelMemoryUsage() {
		$this->agent->registerModelMaker( 'MwRdf_Interwiki_Modeler' );
		$expected = memory_get_usage( true );
		$this->agent->storeModel( 'interwiki' );
		$actual = memory_get_usage( true );
		$this->assertEquals( $expected, $actual );
	}

	public function testStoreAllModelsMemoryUsage() {
		$this->agent->registerModelMaker( 'MwRdf_Categories_Modeler' );
		$this->agent->registerModelMaker( 'MwRdf_CreativeCommons_Modeler' );
		$this->agent->registerModelMaker( 'MwRdf_DCmes_Modeler' );
		$this->agent->registerModelMaker( 'MwRdf_History_Modeler' );
		$this->agent->registerModelMaker( 'MwRdf_Image_Modeler' );
		$this->agent->registerModelMaker( 'MwRdf_InPage_Modeler' );
		$this->agent->registerModelMaker( 'MwRdf_Interwiki_Modeler' );
		$this->agent->registerModelMaker( 'MwRdf_LinksFrom_Modeler' );
		$this->agent->registerModelMaker( 'MwRdf_LinksTo_Modeler' );
		$expected = memory_get_usage( true );
		$this->agent->storeAllModels();
		$actual = memory_get_usage( true );
		$this->assertEquals( $expected, $actual );
	}
}
