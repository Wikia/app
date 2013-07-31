<?php
namespace Wikia\Search\Test\TestProfile;
use Wikia\Search\Test, ReflectionProperty;
/**
 * Tests for Config class
 */
class BaseTest extends Test\BaseTest
{
	/**
	 * @covers Wikia\Search\TestProfile\Base::getQueryFieldsToBoosts
	 */
	public function testGetQueryFieldsToBoosts() {
		$base = new \Wikia\Search\TestProfile\Base;
		$reflDefault = new ReflectionProperty( $base, 'defaultQueryFields' );
		$reflDefault->setAccessible( true );
		$this->assertEquals(
				$reflDefault->getValue( $base ),
				$base->getQueryFieldsToBoosts(),
				'Without a query service, get default query fields'
		);
		$this->assertEquals(
				$reflDefault->getValue( $base ),
				$base->getQueryFieldsToBoosts( '\\Wikia\\Search\\QueryService\\Select\\Dismax\\OnWiki' ),
				'A query service that isn\'t specific in the switch statement should result in default query fields'
		);
		$reflVideo = new ReflectionProperty( $base, 'videoQueryFields' );
		$reflVideo->setAccessible( true );
		$this->assertEquals(
				$reflVideo->getValue( $base ),
				$base->getQueryFieldsToBoosts( '\\Wikia\\Search\\QueryService\\Select\\Dismax\\Video' ),
				'video qfs for video qs'
		);
		$this->assertEquals(
				$reflVideo->getValue( $base ),
				$base->getQueryFieldsToBoosts( '\\Wikia\\Search\\QueryService\\Select\\Dismax\\VideoEmbedTool' ),
				'video qfs for video qs'
		);
		$reflInterWiki= new ReflectionProperty( $base, 'interWikiQueryFields' );
		$reflInterWiki->setAccessible( true );
		$this->assertEquals(
				$reflInterWiki->getValue( $base ),
				$base->getQueryFieldsToBoosts( '\\Wikia\\Search\\QueryService\\Select\\Dismax\\InterWiki' ),
				'interwiki qfs for interwiki qs'
		);
	}
	
}