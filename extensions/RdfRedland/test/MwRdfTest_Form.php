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

require_once( 'includes/MessageCache.php' );

class MwRdf_Form_Test extends PHPUnit_Framework_TestCase {

	private $html;
	private $messages;

	public function setUp() {
		global $wgOut, $wgUser, $wgMessageCache;
		$wgOut = $this;
		$wgUser = new User(2);
		$wgMessageCache = new MessageCache();
		$wgMessageCache->addMessages(array(
			'rdf'                 => 'Rdf',
			'rdf-inpage'          => "Embedded In-page Turtle",
			'rdf-dcmes'           => "Dublin Core Metadata Element Set",
			'rdf-cc'              => "Creative Commons",
			'rdf-image'           => "Embedded images",
			'rdf-linksfrom'       => "Links from the page",
			'rdf-links'           => "All links",
			'rdf-history'         => "Historical versions",
			'rdf-interwiki'       => "Interwiki links",
			'rdf-categories'      => "Categories",
			'rdf-target'          => "Target page",
			'rdf-modelnames'      => "Model(s)",
			'rdf-format'          => "Output format",
			'rdf-output-xml'      => "XML",
			'rdf-output-turtle'   => "Turtle",
			'rdf-output-ntriples' => "NTriples",
			'rdf-instructions'    => "Select the target page and RDF models you're interested in.")
		);

		MwRdf::$ModelMakers = array(
			'MwRdf_CreativeCommons_Modeler',
			'MwRdf_LinksFrom_Modeler',
			'MwRdf_LinksTo_Modeler',
			'MwRdf_InPage_Modeler',
			'MwRdf_DCmes_Modeler',
			'MwRdf_History_Modeler',
			'MwRdf_Image_Modeler',
			'MwRdf_Categories_Modeler',
			'MwRdf_Interwiki_Modeler' );
		MwRdf::ShowForm();
	}

	public function tearDown() {
		MwRdf::$ModelMakers = array();
	}

	public function addHtml( $html ) {
		$this->html .= $html;
	}

	public function parse( $string ) {
		return $string;
	}

	public function testFormHasModelnamesSelector() {
		$this->assertRegExp( "/<select[^>]+name='modelnames\[\]'[^>]*>/", $this->html );
	}

	public function testFormModelnamesSelectorHasOptions() {
		$this->assertRegExp( "/<select[^>]+name='modelnames\[\]'[^>]*>\s*(<option[^>]*>[^<]*<\/option>\s*)+<\/select>/",
		$this->html, 'has modelname options' );
	}

	public function testFormModelnamesSelectorHasCorrectOptions() {
		foreach ( array( 'inpage', 'cc', 'dcmes', 'image', 'linksfrom',
		'history', 'interwiki', 'categories' ) as $name ) {
			$this->assertRegExp( "/<option\s+value='$name'[^>]*>[^<]*<\/option>/",
			$this->html, "has $name option" );
		}
	}

	public function testFormHasFormatSelector() {
		$this->assertRegExp( "/<select[^>]+name='format'[^>]*>/",
		$this->html, 'has format selector' );
	}

	public function testFormFormatSelectorHasOptions() {
		$this->assertRegExp( "/<select[^>]+name='format'[^>]*>\s*(<option[^>]*>[^<]*<\/option>\s*)+<\/select>/",
		$this->html, 'has format options' );
	}

	public function testFormFormatSelectorHasCorrectOptions() {
		foreach ( array( 'rdfxml', 'ntriples', 'turtle' ) as $name ) {
			$this->assertRegExp( "/<option\s+value='$name'[^>]*>[^<]*<\/option>/",
			$this->html, "has $name option" );
		}
	}

	public function testShowFormWithMessage() {
		$msg = 'this is a message';
		MwRdf::ShowForm( $msg );
		$this->assertContains( $msg, $this->html );
	}
}
