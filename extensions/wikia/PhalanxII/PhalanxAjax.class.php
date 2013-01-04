<?php

class PhalanxAjax {

	/**
	 * Get given block data
	 *
	 * @author Maciej Brencz
	 */
	public static function getOneBlock() {
		global $wgRequest;
		$id = $wgRequest->getInt('id');

		if(empty($id)) {
			return false;
		}

		return PhalanxHelper::getOneBlock($id);
	}

	/**
	 * Test some text against active blocks
	 *
	 * @author Maciej Brencz
	 */
	static public function testBlock() {
		global $wgRequest;
		$text = $wgRequest->getVal( 'text' );

		return PhalanxHelper::testBlock($text);
	}

	/**
	 * Add a block
	 *
	 * @author Maciej Brencz
	 */
	static public function setBlock() {
		return PhalanxHelper::setBlock();
	}

	static public function removeSingleBlock() {
		global $wgRequest;
		$id = $wgRequest->getInt('id');

		if(empty($id)) {
			return false;
		}

		return PhalanxHelper::removeFilter($id);
	}
}
