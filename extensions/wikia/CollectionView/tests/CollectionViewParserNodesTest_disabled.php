<?php
//class CollectionViewParserNodesTest extends WikiaBaseTest {
//
//	protected function setUp() {
//		parent::setUp();
//		require_once( dirname( __FILE__ ) . '/../CollectionView.setup.php' );
//		foreach ( $wgAutoloadClasses as $class => $file) {
//			require_once($file);
//		}
//	}
//
//	public function testNodeTitle() {
//		$string = '<title source="nombre"><default>def</default></title>';
//		$xml = simplexml_load_string( $string );
//
//		$node = new Wikia\CollectionView\Parser\Nodes\NodeTitle( $xml, [ 'nombre' => 1 ] );
//		$nodeDefault = new Wikia\CollectionView\Parser\Nodes\NodeTitle( $xml, [ ] );
//		$this->assertTrue( $node->getData()[ 'value' ] == 1 );
//		$this->assertTrue( $nodeDefault->getData()[ 'value' ] == 'def' );
//	}
//
//	public function testNodePair() {
//		$string = '<pair source="Season"><label>Season(s)</label><default>Lorem ipsum</default></pair>';
//		$xml = simplexml_load_string( $string );
//
//		$node = new Wikia\CollectionView\Parser\Nodes\NodePair( $xml, [ 'Season' => 1 ] );
//		$nodeDefault = new Wikia\CollectionView\Parser\Nodes\NodePair( $xml, [ ] );
//		$this->assertTrue( $node->getData()[ 'value' ] == 1 );
//		$this->assertTrue( $nodeDefault->getData()[ 'value' ] == 'Lorem ipsum' );
//	}
//
//	public function testNodeImage() {
//		$string = '<image source="image2"><alt source="alt-source"><default>default-alt</default></alt></image>';
//		$xml = simplexml_load_string( $string );
//
//		$nodeDefault = new Wikia\CollectionView\Parser\Nodes\NodeImage( $xml, [ ] );
//
//		$node = $this->getMockBuilder( 'Wikia\CollectionView\Parser\Nodes\NodeImage' )->setConstructorArgs( [ $xml, [ 'image2' => 'aaa.jpg', 'alt-source' => 'bbb' ] ] )->setMethods( [ 'resolveImageUrl' ] )->getMock();
//		$node->expects( $this->any() )->method( 'resolveImageUrl' )->will( $this->returnValue( 'aaa.jpg' ) );
//
//		$this->assertTrue( $node->getData()[ 'value' ] == 'aaa.jpg', 'value is not aaa.jpg' );
//		$this->assertTrue( $node->getData()[ 'alt' ] == 'bbb', 'alt is not bbb' );
//		$this->assertTrue( $nodeDefault->getData()[ 'alt' ] == 'default-alt', 'default alt' );
//	}
//
//	public function testNodeHeader() {
//		$string = '<header><value>Comandantes</value></header>';
//		$xml = simplexml_load_string( $string );
//
//		$node = new Wikia\CollectionView\Parser\Nodes\NodeHeader( $xml, [ ] );
//		$this->assertTrue( $node->getData()[ 'value' ] == 'Comandantes' );
//	}
//
//	public function testNodeFooter() {
//		$string = '<footer><links>123</links></footer>';
//		$xml = simplexml_load_string( $string );
//
//		$node = new Wikia\CollectionView\Parser\Nodes\NodeFooter( $xml, [ ] );
//		$this->assertTrue( $node->getData()[ 'links' ] == '123' );
//	}
//
//	public function testNodeGroup() {
//		$string = '<group>
//				<pair source="elem1"><label>l1</label><default>def1</default></pair>
//				<pair source="elem2"><label>l2</label><default>def2</default></pair>
//				<pair source="elem3"><label>l2</label></pair>
//					</group>
//						';
//		$xml = simplexml_load_string( $string );
//
//		$node = new Wikia\CollectionView\Parser\Nodes\NodeGroup( $xml, [ 'elem1' => 1, 'elem2' => 2 ] );
//		$data = $node->getData();
//		$this->assertTrue( is_array( $data[ 'value' ] ), 'value is array' );
//		$this->assertTrue( $data[ 'value' ][ 0 ][ 'data' ][ 'value' ] == 1, 'first elem' );
//		$this->assertTrue( $data[ 'value' ][ 1 ][ 'data' ][ 'value' ] == 2, 'second elem' );
//		$this->assertTrue( $data[ 'value' ][ 1 ][ 'data' ][ 'label' ] == 'l2', 'second elem - label' );
//		$this->assertTrue( $data[ 'value' ][ 2 ][ 'isNotEmpty' ] == false, 'empty' );
//	}
//
//	public function testNodeComparition() {
//		$string = '<comparison>
//			   <set>
//				  <header><value>Combatientes</value></header>
//				  <pair source="lado1" />
//				  <pair source="lado2" />
//			   </set>
//			   <set>
//				  <header><value>Comandantes</value></header>
//				  <pair source="comandantes1" />
//				  <pair source="comandantes2" />
//			   </set>
//			</comparison>
//						';
//		$xml = simplexml_load_string( $string );
//
//		$node = new Wikia\CollectionView\Parser\Nodes\NodeComparison( $xml, [ 'lado1' => 1, 'lado2' => 2 ] );
//		$data = $node->getData();
//
//		$this->assertTrue( is_array( $data[ 'value' ] ), 'value is array' );
//		$this->assertTrue( $data[ 'value' ][ 0 ][ 0 ][ 'type' ] == 'header' );
//		$this->assertTrue( $data[ 'value' ][ 0 ][ 0 ][ 'data' ][ 'value' ] == 'Combatientes' );
//		$this->assertTrue( $data[ 'value' ][ 0 ][ 1 ][ 'type' ] == 'pair' );
//		$this->assertTrue( $data[ 'value' ][ 0 ][ 2 ][ 'data' ][ 'value' ] == 2 );
//	}
//
//}
