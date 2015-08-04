<?php
/**
 * Set of unit tests for GlobalFile class
 *
 * @author Inez Korczyński
 */
class MultiBytePathInfoTest extends WikiaBaseTest {

	public function testAll() {
		$this->assertEquals( mb_pathinfo( 'すどく.txt' ), [
			'basename' => 'すどく.txt',
			'extension' => 'txt',
			'filename' => 'すどく'
		] );

		$this->assertEquals( mb_pathinfo( 'sudoku.すどく.txt' ), [
			'basename' => 'sudoku.すどく.txt',
			'extension' => 'txt',
			'filename' => 'sudoku.すどく'
		] );

		$this->assertEquals( mb_pathinfo( '/dir_すどく/すどく.txt' ), [
			'dirname' => '/dir_すどく',
			'basename' => 'すどく.txt',
			'extension' => 'txt',
			'filename' => 'すどく'
		] );

		$this->assertEquals( mb_pathinfo( '/dir_すどく/すどく.すどく.txt' ), [
			'dirname' => '/dir_すどく',
			'basename' => 'すどく.すどく.txt',
			'extension' => 'txt',
			'filename' => 'すどく.すどく'
		] );
	}
}
