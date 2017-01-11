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
		$data = '[{"parser_tag_version": ' .
			PortableInfoboxParserTagController::PARSER_TAG_VERSION .
			', "data": [], "metadata": []}]';
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

		$this->assertEquals(
			[
				[
					'parser_tag_version' => PortableInfoboxParserTagController::PARSER_TAG_VERSION,
					'data' => [ [ 'type' => 'data', 'data' => [ 'label' => null, 'value' => 1, 'layout' => null, 'span' => 1 ] ] ],
					'metadata' => [
						[
							'type' => 'data',
							'sources' => [
								'test' => [
									'label' => '',
									'primary' => true
								],
								'test2' => [
									'label' => ''
								]
							]
						]
					]
				]
			],
			$result
		);
	}

	public function testTemplate() {
		$data = [
			[
				'parser_tag_version' => PortableInfoboxParserTagController::PARSER_TAG_VERSION,
				'data' => [],
				'metadata' => []
			]
		];
		$result = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1, NS_TEMPLATE ) )
			->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ ] ) )
			->setParsingHelper( new ParsingHelperDummy( null, $data ) )
			->getData();

		$this->assertEquals( $data, $result );
	}

	public function testReparse() {
		$oldData = '[{"parser_tag_version": 0, "data": [], "metadata": []}]';
		$newData = [
			[
				'parser_tag_version' => PortableInfoboxParserTagController::PARSER_TAG_VERSION,
				'data' => [],
				'metadata' => []
			]
		];

		$result = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1 ) )
			// purge memc so we can rerun tests
			->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ '1infoboxes' => $oldData ] ) )
			->setParsingHelper( new ParsingHelperDummy( $newData ) )
			->getData();

		$this->assertEquals( $newData, $result );
	}

	public function testDelete() {
		$data = '[{"parser_tag_version": ' .
			PortableInfoboxParserTagController::PARSER_TAG_VERSION .
			', "data": [], "metadata": []}]';
		$result = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1 ) )
			// purge memc so we can rerun tests
			->purge()
			->setPagePropsProxy( new PagePropsProxyDummy( [ '1infoboxes' => $data ] ) )
			->delete()
			->getData();

		$this->assertEquals( [ ], $result );
	}

	public function testPurge() {
		$data = '[{"parser_tag_version": ' .
			PortableInfoboxParserTagController::PARSER_TAG_VERSION .
			', "data": [], "metadata": []}]';
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
			->setPagePropsProxy(
				new PagePropsProxyDummy( [ '1infoboxes' => json_encode( $this->getInfoboxPageProps() ) ] )
			)
			->getImages();

		$this->assertEquals( count( $images ), 2 );
	}

	public function testImageListFetchImages() {
		$images = PortableInfoboxDataService::newFromTitle( $this->prepareTitle( 1 ) )
			->purge()
			->setPagePropsProxy(
				new PagePropsProxyDummy( [ '1infoboxes' => json_encode( $this->getInfoboxPageProps() ) ] )
			)
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

	protected function getInfoboxPageProps() {
		return [
			[
				'parser_tag_version' => PortableInfoboxParserTagController::PARSER_TAG_VERSION,
				'data' => [
					[
						'type' => 'data',
						'data' => [
							'value' => 'AAAA',
							'label' => 'BBBB'
						]
					],
					[
						'type' => 'image',
						'data' => [
							[
								'key' => 'Test.jpg',
								'alt' => null,
								'caption' => null,
							]
						]
					],
					[
						'type' => 'image',
						'data' => [
							[
								'key' => 'Test2.jpg',
								'alt' => null,
								'caption' => null
							]
						]
					]
				],
				'metadata' => []
			],
			[
				'parser_tag_version' => PortableInfoboxParserTagController::PARSER_TAG_VERSION,
				'data' => [
					[
						'type' => 'image',
						'data' => [
							[
								'key' => 'Test2.jpg',
								'alt' => null,
								'caption' => null
							]
						]
					]
				],
				'metadata' => []
			]
		];
	}
}

class ParsingHelperDummy {

	public function __construct( $infoboxesData = null, $includeonlyInfoboxesData = null ) {
		$this->infoboxesData = $infoboxesData;
		$this->includeonlyInfoboxesData = $includeonlyInfoboxesData;
	}

	public function parseIncludeonlyInfoboxes( $title ) {
		return $this->includeonlyInfoboxesData;
	}

	public function reparseArticle( $title ) {
		return $this->infoboxesData;
	}
}

class PagePropsProxyDummy {

	public function __construct( $data ) {
		$this->data = $data;
	}

	public function get( $id, $property ) {
		return $this->data[ $id . $property ] ?? '';
	}

	public function set( $id, $data ) {
		foreach ( $data as $property => $value ) {
			$this->data[ $id . $property ] = $value;
		}
	}
}
