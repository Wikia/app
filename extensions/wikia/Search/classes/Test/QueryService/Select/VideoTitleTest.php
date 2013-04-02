<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\VideoTitleTest
 */
namespace Wikia\Search\Test\QueryService\Select;
use Wikia\Search\Test\BaseTest, ReflectionMethod, Wikia\Search\QueryService\DependencyContainer, Wikia\Search\QueryService\Select\Video;
/**
 * Tests the functionality of Wikia\Search\QueryService\Select\VideoTitle
 * @author relwell
 */
class VideoTitleTest extends BaseTest
{
	/**
	 * @covers Wikia\Search\QueryService\Select\VideoTitle::getFormulatedQuery
	 */
	public function testGetFormulatedQuery() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQuery' ) );
		$dc = new DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\VideoTitle' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$videoTitle ='my video title';
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $videoTitle ) )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\VideoTitle', 'getFormulatedQuery' );
		$method->setAccessible( true );
		$this->assertEquals(
				sprintf( 'wid:%s AND ns:6 AND ( title_en:(%s) OR nolang_txt:(%s) )', Video::VIDEO_WIKI_ID, $videoTitle, $videoTitle ),
				$method->invoke( $mockSelect )
		);
	}
}