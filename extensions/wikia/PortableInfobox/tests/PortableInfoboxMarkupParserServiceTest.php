<?php

class PortableInfoboxMarkupParserServiceTest extends WikiaBaseTest {

	protected function setUp() {
		parent::setUp();
		require_once( dirname(__FILE__) . '/../services/PortableInfoboxMarkupParserService.class.php');
		require_once( dirname(__FILE__) . '/../PortableInfobox.setup.php');
	}

	public function markupProvider() {
		return [
			[ '<infobox>
			<image source="image">
				<alt source="image hover">
					<default>{{BASEPAGENAME}}</default>
				</alt>
			</image>
			<image source="image2">
				<alt source="image hover2">
					<default>{{BASEPAGENAME}}</default>
				</alt>
			</image>
			<pair source="Season">
        		<label>Season(s)</label>
        		<default>Lorem ipsum</default>
    		</pair>
			<title source="nombre">
				<default>{{{PAGENAME}}}</default>
			</title>
			<group>
				<header>
					<value>Información General</value>
				</header>
				<pair source="prev">
					<label>Previa</label>
				</pair>
			</group>
			<comparison>
			   <set>
				  <header><value>Combatientes</value></header>
				  <pair source="lado1" />
				  <pair source="lado2" />
			   </set>
			   <set>
				  <header><value>Comandantes</value></header>
				  <pair source="comandantes1" />
				  <pair source="comandantes2" />
			   </set>
			</comparison>
			<group>
			   <header>
				  <value>Apariciones</value>
			   </header>
			   <pair source="últimaapar">
					 <label>Última Aparición</label>
				  </pair>
			</group>
			<footer>
			   <links>
				 {{#switch:{{BASEPAGENAME}}|Fanon=|
					 {{#ifexist:Categoría:Imágenes de {{BASEPAGENAME}}|
						 [[:Categoría:Imágenes de {{BASEPAGENAME}}|Galería de
					 imágenes ({{PAGESINCAT:Imágenes de{{BASEPAGENAME}}}})
					 ]]}}}}
			   </links>
			</footer>
			</infobox>
			', ['image' => 'aaaa.jpg',
				'image2' => 'bbbb.jpg',
				'Season' => 'Season 1',
				'image hover' => 'IMAGE ALT',
				'prev' => 'PREVIA VALUE',
				'lado1' => 'COMATANTE 1',
				'lado2' => 'COMATANTE 2',
				'comandantes1' => 'COMXXX 1',
				'comandantes2' => 'COMXXX 21',
				'últimaapar' => 'UUUUUULTIMAPAAR'
				] ]
		];
	}

	/**
	 * @param $xmlMarkup
	 * @param $xmlData
	 * @dataProvider markupProvider
	 */
	public function testParse( $xmlMarkup, $xmlData ) {
		$parser = new PortableInfoboxMarkupParserService( $xmlMarkup, $xmlData );
		$data = $parser->parse();
		print_r( $data );
		$this->assertTrue( 1 == 1 );
	}

	public function testNodeTitle() {

	}
}