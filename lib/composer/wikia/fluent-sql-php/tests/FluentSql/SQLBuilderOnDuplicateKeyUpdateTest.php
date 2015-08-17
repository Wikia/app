<?php
namespace FluentSql;

class SQLBuilderOnDuplicateKeyUpdateTest extends FluentSqlTestBase {

	public function testSet() {
		$expected = "
			INSERT INTO files SET id = '1', location = '/path/to/file'
			ON DUPLICATE KEY UPDATE a = '5', b = 'ten'
		";

		$sql = ( new SQL )
			->INSERT( 'files' )
			->SET( 'id', 1 )
			->SET( 'location', '/path/to/file' )
			->ON_DUPLICATE_KEY_UPDATE( [ 'a' => 5, 'b' => 'ten' ] );

		$actual = $sql->injectParams( null, $sql->build() );

		$this->assertEquals( $expected, $actual );
	}

	public function testValues() {
		$expected = "
			INSERT INTO some_table (col1, col2, col3) VALUES ( '1', '2', '3' ), ( '4', '5', '6' )
			ON DUPLICATE KEY UPDATE my_col = 'upsert', my_col2 = '25.73'
		";

		$sql = ( new SQL )
			->INSERT()->INTO( 'some_table', [ 'col1', 'col2', 'col3' ] )
			->VALUES( [ [ 1, 2, 3 ], [ 4, 5, 6 ] ] )
			->ON_DUPLICATE_KEY_UPDATE( [ 'my_col' => 'upsert', 'my_col2' => 25.73 ] );

		$actual = $sql->injectParams( null, $sql->build() );

		$this->assertEquals( $expected, $actual );
	}
}
