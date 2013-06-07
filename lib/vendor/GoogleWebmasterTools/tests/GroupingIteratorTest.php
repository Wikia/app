<?php
/**
 * User: artur
 * Date: 07.06.13
 * Time: 16:02
 */

class GroupingIteratorTest extends WikiaBaseTest {
	public function testGroupingIteratorNext() {
		$groupingIterator = new GroupingIterator( new ArrayIterator( [] ), 1);
		$this->assertFalse( $groupingIterator->valid() );
	}
}
