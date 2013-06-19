<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\VideoTest
 */
namespace Wikia\Search\Test\QueryService\Select;
use Wikia, ReflectionProperty, ReflectionMethod;
/**
 * Tests video search
 */
class VideoTest extends Wikia\Search\Test\BaseTest {
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Video::configureQueryFields
	 */
	public function testConfigureQueryFields() {
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getLanguageCode' ) )
		                      ->getMock();
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'addQueryFields' ) );
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig, 'service' => $mockService ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Video' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$videoQueryFields = array(
				Wikia\Search\Utilities::field( 'title', 'en' )           => 100, 
				Wikia\Search\Utilities::field( 'html', 'en' )            => 5, 
				Wikia\Search\Utilities::field( 'redirect_titles', 'en' ) => 50
		);
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getLanguageCode' )
		    ->will   ( $this->returnValue( 'fr' ) )
	    ;
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'addQueryFields' )
		    ->with   ( $videoQueryFields )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'addQueryFields' )
		    ->with   ( [ 'video_actors_txt' => 100, 'video_genres_txt' => 50, 'html_media_extras_txt' => 80 ] )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Video', 'configureQueryFields' );
		$method->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\VideoEmbedTool::getQueryClausesString
	 */
	public function testGetQueryClausesString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getWikiId', 'getNamespaces' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\VideoEmbedTool' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\VideoEmbedTool', 'getQueryClausesString' );
		$method->setAccessible( true );
		$this->assertEquals(
				'((wid:123) AND (is_video:true) AND (ns:6))',
				$method->invoke( $mockSelect )
		);
	}
	
	
}