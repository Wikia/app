<?php
/**
 * User: artur
 * Date: 07.06.13
 * Time: 16:02
 */

class GroupingIteratorTest extends WikiaBaseTest {

	public function testGroupingIteratorNextOnEmptyArray() {
		$groupingIterator = new GroupingIterator( new ArrayIterator( [] ), 1);
		$this->assertFalse( $groupingIterator->valid() );
	}

	public function testFirstGroup() {
		$groupingIterator = new GroupingIterator( new ArrayIterator( [1] ), 1);
		$this->assertTrue( $groupingIterator->valid() );
		$this->assertEquals( [1], $groupingIterator->current() );
	}
	public function testLastGroup() {
		$groupingIterator = new GroupingIterator( new ArrayIterator( [1,2,3,4,5,6,7,8,9] ), 2);
		$groupingIterator->next();
		$groupingIterator->next();
		$groupingIterator->next();
		$groupingIterator->next();
		$this->assertTrue( $groupingIterator->valid() );
		$this->assertEquals( [9], $groupingIterator->current() );
	}

	public function testSecondGroup() {
		$groupingIterator = new GroupingIterator( new ArrayIterator( [1,2] ), 1);
		$groupingIterator->next();
		$this->assertTrue( $groupingIterator->valid() );
		$this->assertEquals( [2], $groupingIterator->current() );
	}

	public function testEmptySecondGroup() {
		$groupingIterator = new GroupingIterator( new ArrayIterator( [1] ), 1);
		$groupingIterator->next();
		$this->assertFalse( $groupingIterator->valid() );
	}

	public function testSecondGroup2() {
		$groupingIterator = new GroupingIterator( new ArrayIterator( [1,2,3] ), 2);
		$this->assertTrue( $groupingIterator->valid() );
		$this->assertEquals( [1,2], $groupingIterator->current() );
		$groupingIterator->next();
		$this->assertTrue( $groupingIterator->valid() );
		$this->assertEquals( [3], $groupingIterator->current() );
	}

	public function testEmptySecondGroup2() {
		$groupingIterator = new GroupingIterator( new ArrayIterator( [1,2] ), 2);
		$groupingIterator->next();
		$this->assertFalse( $groupingIterator->valid() );
	}
}
