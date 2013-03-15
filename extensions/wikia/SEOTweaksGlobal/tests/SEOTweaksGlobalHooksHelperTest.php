<?php
/**
 * @author Jacek 'mech' Wozniak
 */

class SEOTweaksGlobalHooksHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../SEOTweaksGlobal.setup.php';
		parent::setUp();
	}

	/*
	 * Test if the thumbnail gets generated for article
	 */
	public function testArticleImageGeneration() {
		$memkey = 'sght_memkey';
		$thumbUrl = 'http://www.wikia.com/wiki/fake.jpg';

		$mock_cache = $this->getMock('stdClass', array('get', 'set'));
		$mock_cache->expects($this->once())
			->method('get')
			->with($this->equalTo($memkey))
			->will($this->returnValue(null));
		$mock_cache->expects($this->once())
			->method('set')
			->with($this->equalTo($memkey),$this->equalTo($thumbUrl));

		$fileMock = $this->getMock('File', array(), array(), '', FALSE);
		$mockedFileTitle = $this->getMock('Title' );

		$this->mockGlobalVariable('wgMemc', $mock_cache, 0);
		$this->mockGlobalFunction('findFile', $fileMock, 1, array($mockedFileTitle));

		$this->mockApp();

		$mockedTitle = $this->getMock('Title');

		$mocked = $this->getMock('SEOTweaksGlobalHooksHelper', array('getThumbFromFile', 'getFirstArticleImage', 'makeKey') );
		$mocked->expects($this->once())
			->method('getFirstArticleImage')
			->with($this->equalTo( $mockedTitle ) )
			->will( $this->returnValue( $mockedFileTitle ) );
		$mocked->expects($this->once())
			->method('getThumbFromFile')
			->with($this->equalTo( $fileMock ) )
			->will( $this->returnValue( $thumbUrl ) );
		$mocked->expects( $this->any() )
			->method('makeKey')
			->will( $this->returnValue($memkey) );

		$meta = array('foo'=>'bar');
		$mocked->onOpenGraphMetaHeaders($meta, $mockedTitle);
		$this->assertEquals(array('foo'=>'bar', 'og:image' => $thumbUrl), $meta);
	}

	/*
	 * Test if the thumbnail gets generated for article from file namespace
	 */
	public function testFileImageGeneration() {
		$memkey = 'sght_memkey2';
		$thumbUrl = 'http://www.wikia.com/wiki/fake2.jpg';

		$mock_cache = $this->getMock('stdClass', array('get', 'set'));
		$mock_cache->expects($this->once())
			->method('get')
			->with($this->equalTo($memkey))
			->will($this->returnValue(null));
		$mock_cache->expects($this->once())
			->method('set')
			->with($this->equalTo($memkey),$this->equalTo($thumbUrl));

		$fileMock = $this->getMock('File', array(), array(), '', FALSE);
		$mockedTitle = $this->getMock('Title', array('getNamespace') );
		$mockedTitle->expects($this->any())
			->method('getNamespace')
			->will($this->returnValue(NS_FILE));

		$this->mockGlobalVariable('wgMemc', $mock_cache, 0);
		$this->mockGlobalFunction('findFile', $fileMock, 1, array($mockedTitle));

		$this->mockApp();

		$mocked = $this->getMock('SEOTweaksGlobalHooksHelper', array('getThumbFromFile', 'getFirstArticleImage', 'makeKey') );
		$mocked->expects($this->never())
			->method('getFirstArticleImage');
		$mocked->expects($this->once())
			->method('getThumbFromFile')
			->with($this->equalTo( $fileMock ) )
			->will( $this->returnValue( $thumbUrl ) );
		$mocked->expects( $this->any() )
			->method('makeKey')
			->will( $this->returnValue($memkey) );

		$meta = array('foo'=>'bar');
		$mocked->onOpenGraphMetaHeaders($meta, $mockedTitle);
		$this->assertEquals(array('foo'=>'bar', 'og:image' => $thumbUrl), $meta);
	}

	/*
	 * Test if we don't try to generate thumbnail for user pages (bugid 98881)
	 */
	public function testUserNS() {
		$mock_cache = $this->getMock('stdClass', array('get', 'set'));
		$mock_cache->expects($this->never())
			->method('get');
		$mock_cache->expects($this->never())
			->method('set');

		$this->mockGlobalVariable('wgMemc', $mock_cache, 0);

		$this->mockApp();

		$mockedTitle = $this->getMock('Title', array('getNamespace') );
		$mockedTitle->expects($this->any())
			->method('getNamespace')
			->will($this->returnValue(NS_USER));

		$mocked = $this->getMock('SEOTweaksGlobalHooksHelper', array('getThumbFromFile', 'getFirstArticleImage', 'makeKey') );
		$mock_cache->expects($this->any())
			->method('makeKey')
			->will($this->returnValue('bar'));
		$mocked->expects($this->never())
			->method('getFirstArticleImage');
		$mocked->expects($this->never())
			->method('getThumbFromFile');
		$meta = array('foo'=>'bar');

		$mocked->onOpenGraphMetaHeaders($meta, $mockedTitle);
		$this->assertEquals(array('foo'=>'bar'), $meta);
	}
	/**
	 * As tests above cover all the generation cases, we right now use the cached value to check the
	 * behaviour in remaining scenarios
	 * @dataProvider getCacheDataProvider
	 */
	public function testCache($memcacheValue, $meta, $expected, $desciption) {
		$memkey = 'sght_memkey2';

		$mock_cache = $this->getMock('stdClass', array('get', 'set'));
		$mock_cache->expects($this->once())
			->method('get')
			->with($this->equalTo($memkey))
			->will($this->returnValue($memcacheValue));
		$mock_cache->expects($this->never())
			->method('set');

		$this->mockGlobalVariable('wgMemc', $mock_cache, 0);

		$this->mockApp();

		$mocked = $this->getMock('SEOTweaksGlobalHooksHelper', array('getThumbFromFile', 'getFirstArticleImage', 'makeKey') );
		$mocked->expects( $this->any() )
			->method('makeKey')
			->will( $this->returnValue($memkey) );
		$mocked->expects($this->never())
			->method('getThumbFromFile');

		$mockedTitle = $this->getMock('Title');
		$mocked->onOpenGraphMetaHeaders($meta, $mockedTitle);
		$this->assertEquals($expected, $meta, $desciption);

	}

	public function getCacheDataProvider() {
		return array(
			array('http://www.wikia.com/wiki/fake3.jpg', array('foo'=>'bar'), array('foo'=>'bar', 'og:image' => 'http://www.wikia.com/wiki/fake3.jpg'),
				'cached value'
			),
			array('http://www.wikia.com/wiki/fake3.jpg', array('foo'=>'bar', 'og:image' => 'http://www.wikia.com/wiki/to_override.jpg'), array('foo'=>'bar', 'og:image' => 'http://www.wikia.com/wiki/fake3.jpg'),
				'cache overrides input value'
			),
			array('', array('foo'=>'bar'), array('foo'=>'bar'),
				'if no thumbnail was generated, don\'t create the entry for \'og:image\''
			),
			array('', array('foo'=>'bar', 'og:image' => 'http://www.wikia.com/wiki/dont_override.jpg'), array('foo'=>'bar', 'og:image' => 'http://www.wikia.com/wiki/dont_override.jpg'),
				'if no thumbnail was generated, don\'t override the input value'
			),
		);
	}

}