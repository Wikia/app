<?php

class UpdateBacklinksJobTest extends WikiaBaseTest
{
	public function setUp()
	{
		parent::setUp();
		$dir = dirname(__FILE__ ).'/..';
		$app = F::app();
		$app->registerClass("Backlinks", "$dir/Backlinks.class.php");
		$app->registerClass("UpdateBacklinksJob", "$dir/job/UpdateBacklinksJob.class.php");

	}

	/**
	 * @covers UpdateBacklinksJob::run
	 */
	public function testRun() {
		$mockJob = $this->getMockBuilder( 'UpdateBacklinksJob' )
						->disableOriginalConstructor()
						->setMethods( array( 'getDocumentForTarget' ) )
						->getMock();
		
		$mockDocument = $this->getMockBuilder( 'Solarium_Document_AtomicUpdate' )
							->disableOriginalConstructor()
							->setMethods( array( 'addField', 'offsetExists', 'offsetGet' ) )
							->getMock();
		
		$mockIndexer = $this->getMockBuilder( 'Wikia\Search\Indexer' )
							->disableOriginalConstructor()
							->setMethods( array( 'updateDocuments' ) )
							->getMock();
		
		
		$mockMvField = array( 'backlink text' );
		$mockArrayObj = $this->getMock( 'ArrayObject', array( 'append' ), array( $mockMvField ) );
		$mockId = '123_234';
		$params = array( 'links' => array( $mockId => array( 'backlink text' => array( '123_345' => 1 ), 'other text' => array( '123_345' => 1 ) ) ) );

		$mockJob
			->expects( $this->at( 0 ) )
			->method ( 'getDocumentForTarget' )
			->with   ( $mockId )
			->will   ( $this->returnValue( $mockDocument ) )
		;
		$mockDocument
			->expects( $this->at( 0 ) )
			->method ( 'offsetExists' )
			->with   ( 'backlink_from_123_345_txt' )
			->will   ( $this->returnValue( false ) )
		;
		$mockDocument
			->expects( $this->at( 1 ) )
			->method ( 'addField' )
			->with   ( 'backlink_from_123_345_txt', $mockMvField, null, Solarium_Document_AtomicUpdate::MODIFIER_SET )
		;
		$mockDocument
			->expects( $this->at( 2 ) )
			->method ( 'offsetExists' )
			->with   ( 'backlink_from_123_345_txt' )
			->will   ( $this->returnValue( true ) )
		;
		$mockDocument
			->expects( $this->at( 3 ) )
			->method ( 'offsetGet' )
			->with   ( 'backlink_from_123_345_txt' )
			->will   ( $this->returnValue( $mockArrayObj ) )
		;
		/* not listening
		$mockArrayObj
			->expects( $this->at( 0 ) )
			->method ( 'append' )
			->with   ( 'other text' )
		;*/
		$mockIndexer
			->expects( $this->at( 0 ) )
			->method ( 'updateDocuments' )
			->with   ( array( $mockDocument ) )
		;
		$paramRefl = new ReflectionProperty( 'Job', 'params' );
		$paramRefl->setAccessible( true );
		$paramRefl->setValue( $mockJob, $params );
		
		$paramRefl = new ReflectionProperty( 'UpdateBacklinksJob', 'documents' );
		$paramRefl->setAccessible( true );
		$paramRefl->setValue( $mockJob, array( $mockDocument ) );
		
		$this->proxyClass( 'Wikia\Search\Indexer', $mockIndexer );
		$this->mockApp();
		
		$mockJob->run();
	}
	
	/**
	 * @covers UpdateBacklinksJob::getDocumentForTarget
	 */
	public function testGetDocumentForTargetUnitialized() {
		$mockJob = $this->getMockBuilder( 'UpdateBacklinksJob' )
						->disableOriginalConstructor()
						->setMethods( array( 'foo' ) ) // stupid mocking trick
						->getMock();
		
		$mockDocument = $this->getMockBuilder( 'Solarium_Document_AtomicUpdate' )
							->disableOriginalConstructor()
							->setMethods( array( 'setKey' ) )
							->getMock();
		$mockId = '123_234';
		
		$mockDocument
			->expects( $this->at( 0 ) )
			->method ( 'setKey' )
			->with   ( 'id', $mockId )
		;
		
		$this->proxyClass( 'Solarium_Document_AtomicUpdate', $mockDocument );
		$this->mockApp();
		
		$getter = new ReflectionMethod( 'UpdateBacklinksJob', 'getDocumentForTarget' );
		$getter->setAccessible( true );
		
		$this->assertEquals(
				get_class( $mockDocument ),
				$getter->invoke( $mockJob, $mockId )->_mockClassName,
				'UpdateBacklinksJob::getDocumentForTarget should always return an instance of Solarium_Document_AtomicUpdate'
		);
	}
	
	/**
	 * @covers UpdateBacklinksJob::getDocumentForTarget
	 */
	public function testGetDocumentForTargetInitialized() {
		$mockJob = $this->getMockBuilder( 'UpdateBacklinksJob' )
						->disableOriginalConstructor()
						->setMethods( array( 'foo' ) ) // stupid mocking trick
						->getMock();
		
		$mockDocument = $this->getMockBuilder( 'Solarium_Document_AtomicUpdate' )
							->disableOriginalConstructor()
							->setMethods( array( 'setKey' ) )
							->getMock();
		
		$mockId = '123_234';
		
		$mockDocument
			->expects( $this->never() )
			->method ( 'setKey' )
		;
		$this->proxyClass( 'Solarium_Document_AtomicUpdate', $mockDocument );
		$this->mockApp();
		
		$getter = new ReflectionMethod( 'UpdateBacklinksJob', 'getDocumentForTarget' );
		$getter->setAccessible( true );
		
		$docs = new ReflectionProperty( 'UpdateBacklinksJob', 'documents' );
		$docs->setAccessible( true );
		$docs->setValue( $mockJob, array( $mockId => $mockDocument ) );
		
		$this->assertEquals(
				$mockDocument,
				$getter->invoke( $mockJob, $mockId ),
				'UpdateBacklinksJob::getDocumentForTarget should always return an instance of Solarium_Document_AtomicUpdate'
		);
	}
}