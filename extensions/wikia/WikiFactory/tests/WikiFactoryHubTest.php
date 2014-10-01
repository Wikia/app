<?php

class WikiFactoryHubTest extends WikiaBaseTest {

	public function testGetCategoriesByNameNone() {
		$factoryHub = $this->getMock( 'WikiFactoryHub', ['getAllCategories'], [], '', false );

		$noMatch = array(
			10 => array('name' => 'foobar' )
		);
		$factoryHub->expects( $this->once() )
			->method( 'getAllCategories' )
			->with( false )
			->will( $this->returnValue( $noMatch ) );

		$this->assertEquals( null, $factoryHub->getCategoryByName( 'bar' ) );
	}

	public function testGetCategoriesByName() {
		$factoryHub = $this->getMock( 'WikiFactoryHub', ['getAllCategories'], [], '', false );

		$noMatch = array(
			10 => array('name' => 'foobar' )
		);
		$factoryHub->expects( $this->once() )
			->method( 'getAllCategories' )
			->with( false )
			->will( $this->returnValue( $noMatch ) );

		$this->assertEquals( array( 'id' => 10, 'name' => 'foobar' ), $factoryHub->getCategoryByName( 'foobar' ) );
	}
}
