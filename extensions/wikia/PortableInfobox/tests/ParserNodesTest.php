<?php

class PortableInfoboxParserNodesTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	public function testNodeTitle() {
		$string = '<title source="nombre"><default>def</default></title>';
		$xml = simplexml_load_string( $string );

		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeTitle( $xml, [ 'nombre' => 1 ] );
		$nodeDefault = new Wikia\PortableInfobox\Parser\Nodes\NodeTitle( $xml, [ ] );
		$this->assertTrue( $node->getData()[ 'value' ] == 1 );
		$this->assertTrue( $nodeDefault->getData()[ 'value' ] == 'def' );
	}

	public function testNodeData() {
		$string = '<data source="Season"><label>Season(s)</label><default>Lorem ipsum</default></data>';
		$xml = simplexml_load_string( $string );

		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeData( $xml, [ 'Season' => 1 ] );
		$nodeDefault = new Wikia\PortableInfobox\Parser\Nodes\NodeData( $xml, [ ] );
		$this->assertTrue( $node->getData()[ 'value' ] == 1 );
		$this->assertTrue( $nodeDefault->getData()[ 'value' ] == 'Lorem ipsum' );
	}

	public function testNodeImage() {
		$string = '<image source="image2"><alt source="alt-source"><default>default-alt</default></alt></image>';
		$xml = simplexml_load_string( $string );

		$nodeDefault = new Wikia\PortableInfobox\Parser\Nodes\NodeImage( $xml, [ ] );

		$node = $this->getMockBuilder( 'Wikia\PortableInfobox\Parser\Nodes\NodeImage' )->setConstructorArgs( [ $xml, [ 'image2' => 'aaa.jpg', 'alt-source' => 'bbb' ] ] )->setMethods( [ 'resolveImageUrl' ] )->getMock();
		$node->expects( $this->any() )->method( 'resolveImageUrl' )->will( $this->returnValue( 'aaa.jpg' ) );

		$this->assertTrue( $node->getData()[ 'url' ] == 'aaa.jpg', 'value is not aaa.jpg' );
		$this->assertTrue( $node->getData()[ 'name' ] == 'aaa.jpg', 'value is not aaa.jpg' );
		$this->assertTrue( $node->getData()[ 'alt' ] == 'bbb', 'alt is not bbb' );
		$this->assertTrue( $nodeDefault->getData()[ 'alt' ] == 'default-alt', 'default alt' );
	}

	public function testNodeHeader() {
		$string = '<header>Comandantes</header>';
		$xml = simplexml_load_string( $string );

		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeHeader( $xml, [ ] );
		$this->assertTrue( $node->getData()[ 'value' ] == 'Comandantes' );
	}

	public function testNodeFooter() {
		$string = '<footer>123</footer>';
		$xml = simplexml_load_string( $string );

		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeFooter( $xml, [ ] );
		$this->assertTrue( $node->getData()[ 'value' ] == '123' );
	}

	public function testNodeGroup() {
		$string = '<group>
				<data source="elem1"><label>l1</label><default>def1</default></data>
				<data source="elem2"><label>l2</label><default>def2</default></data>
				<data source="elem3"><label>l2</label></data>
					</group>
						';
		$xml = simplexml_load_string( $string );

		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeGroup( $xml, [ 'elem1' => 1, 'elem2' => 2 ] );
		$data = $node->getData();
		$this->assertTrue( is_array( $data[ 'value' ] ), 'value is array' );
		$this->assertTrue( $data[ 'value' ][ 0 ][ 'data' ][ 'value' ] == 1, 'first elem' );
		$this->assertTrue( $data[ 'value' ][ 1 ][ 'data' ][ 'value' ] == 2, 'second elem' );
		$this->assertTrue( $data[ 'value' ][ 1 ][ 'data' ][ 'label' ] == 'l2', 'second elem - label' );
		$this->assertTrue( $data[ 'value' ][ 2 ][ 'isNotEmpty' ] == false, 'empty' );
	}

	public function testNodeComparition() {
		$string = '<comparison>
			   <set>
				  <header>Combatientes</header>
				  <data source="lado1" />
				  <data source="lado2" />
			   </set>
			   <set>
				  <header>Comandantes</header>
				  <data source="comandantes1" />
				  <data source="comandantes2" />
			   </set>
			</comparison>
						';
		$xml = simplexml_load_string( $string );

		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeComparison( $xml, [ 'lado1' => 1, 'lado2' => 2 ] );
		$data = $node->getData();

		$this->assertTrue( is_array( $data[ 'value' ] ), 'value is array' );
		$this->assertTrue( $data[ 'value' ][ 0 ]['data']['value'][ 0 ][ 'type' ] == 'header' );
		$this->assertTrue( $data[ 'value' ][ 0 ]['data']['value'][ 0 ][ 'data' ][ 'value' ] == 'Combatientes' );
		$this->assertTrue( $data[ 'value' ][ 0 ]['data']['value'][ 1 ][ 'type' ] == 'data' );
		$this->assertTrue( $data[ 'value' ][ 0 ]['data']['value'][ 2 ][ 'data' ][ 'value' ] == 2 );
	}
}
