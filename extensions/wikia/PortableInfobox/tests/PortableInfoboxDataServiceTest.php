<?php

use Wikia\PortableInfobox\Parser\Nodes\NodeFactory;

class PortableInfoboxDataServiceTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @param $id
	 * @param int $ns
	 *
	 * @return Title
	 */
	protected function prepareTitle( $id = 0, $ns = NS_MAIN ) {
		$title = new Title();
		$title->mArticleID = $id;
		$title->mNamespace = $ns;

		return $title;
	}

	public function testEmptyData() {
		$result = PortableInfoboxDataService::newFromTitle( $this->prepareTitle() )
			// empty page props
			->setPagePropsProxy( new PagePropsProxyDummy( [ ] ) )
			->getData();

		$this->assertEquals( [ ], $result );
	}

	public function testLoadFromProps() {
		$data = '[{"data": [], "sources": []}]';
		$result = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1 ) )
			// purge memc so we can rerun tests
			->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ '1infoboxes' => $data ] ) )
			->getData();

		$this->assertEquals( json_decode( $data, true ), $result );
	}

	public function testSave() {
		$markup = '<infobox><data source="test"><default>{{{test2}}}</default></data></infobox>';
		$infoboxNode = NodeFactory::newFromXML( $markup, [ 'test' => 1 ] );

		$result = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1 ) )
			->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ ] ) )
			->save( $infoboxNode )
			->getData();

		$this->assertEquals( [ [ 'data' => [ [ 'type' => 'data', 'data' => [ 'label' => null, 'value' => 1 ] ] ],
								 'sources' => [ 'test', 'test2' ] ] ], $result );
	}

	public function testTemplate() {
		$data = [ [ 'data' => [ ], 'sources' => [ ] ] ];
		$result = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1, NS_TEMPLATE ) )
			->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ ] ) )
			->setTemplatesHelper( new TemplateHelperDummy( $data ) )
			->getData();

		$this->assertEquals( $data, $result );
	}

	public function testDelete() {
		$data = '[{"data": [], "sources": []}]';
		$result = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1 ) )
			// purge memc so we can rerun tests
			->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ '1infoboxes' => $data ] ) )
			->delete()
			->getData();

		$this->assertEquals( [ ], $result );
	}

	public function testPurge() {
		$data = '[{"data": [], "sources": []}]';
		$service = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1 ) )
			// purge memc so we can rerun tests
			->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ '1infoboxes' => $data ] ) );

		// this should load data from props to memc
		$result = $service->getData();

		$service->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ ] ) );
		$purged = $service->getData();

		$this->assertEquals( [ json_decode( $data, true ), [ ] ], [ $result, $purged ] );
	}

	public function testImageListRemoveDuplicates() {
		$images = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1 ) )
			->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ '1infoboxes' => json_encode( $this->getInfoboxData() ) ] ) )
			->getImages();

		$this->assertEquals( count( $images ), 2 );
	}

	public function testImageListFetchImages() {
		$images = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1 ) )
			->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ '1infoboxes' => json_encode( $this->getInfoboxData() ) ] ) )
			->getImages();

		$this->assertEquals( [ 'Test.jpg', 'Test2.jpg' ], $images );
	}

	public function testTitleNullConstructor() {
		$service = PortableInfoboxDataService::newFromTitle( null );
		$result = $service->getData();
		$this->assertEquals( [ ], $result );
	}

	public function testConstructor() {
		$service = PortableInfoboxDataService::newFromPageID( null );
		$result = $service->getData();
		$this->assertEquals( [ ], $result );
	}

	protected function getInfoboxData() {
		return [ [ 'data' => [ [ "type" => "data",
								 "data" => [
									 "value" => "AAAA",
									 "label" => "BBBB"
								 ]
							   ], [ "type" => "image",
									"data" => [ [
										"key" => "Test.jpg",
										"alt" => null,
										"caption" => null,
									] ]
							   ], [ "type" => "image",
									"data" => [ [
										"key" => "Test2.jpg",
										"alt" => null,
										"caption" => null
									] ] ] ] ],
				 [ 'data' => [ [ "type" => "image",
								 "data" => [ [
									 "key" => "Test2.jpg",
									 "alt" => null,
									 "caption" => null
								 ] ] ] ] ] ];
	}
}

class TemplateHelperDummy {

	public function __construct( $hidden = false ) {
		$this->hidden = $hidden;
	}

	public function parseInfoboxes( $title ) {
		return $this->hidden;
	}
}

class PagePropsProxyDummy {

	public function __construct( $data ) {
		$this->data = $data;
	}

	public function get( $id, $property ) {
		$prop = $this->data[ $id . $property ];

		return $prop !== null ? $prop : '';
	}

	public function set( $id, $data ) {
		foreach ( $data as $property => $value ) {
			$this->data[ $id . $property ] = $value;
		}
	}
}
