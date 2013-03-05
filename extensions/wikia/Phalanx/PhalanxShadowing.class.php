<?php

/**
 * This class is responsible for shadowing traffic to new Phalanx
 *
 * Percentage of traffic shadowed to new Phalanx can be controlled using:
 *
 * wgPhalanxShadowingPercentage = 5; // %
 * wgPhalanxShadowingPercentage = 0; // disable
 *
 * @author macbre
 */
class PhalanxShadowing {

	private static $typeName = null;
	private static $typesMap = array(
		1   => 'content',
		2   => 'summary',
		4   => 'title',
		8   => 'user',
		16  => 'question_title',
		32  => 'recent_questions',
		64  => 'wiki_creation',
		256 => 'email'
	);

	/**
	 * Called from Phalanx::getFromFilter
	 *
	 * @param $blockType int numeric ID of block type
	 */
	public static function setType($blockType) {
		if (isset(self::$typesMap[$blockType])) {
			self::$typeName = self::$typesMap[$blockType];

			Wikia::log(__METHOD__, false, "type #{$blockType}", true);
		}
		else {
			self::$typeName = null;

			Wikia::log(__METHOD__, false, "not recognized type provided: #{$blockType}", true);
		}
	}

	/**
	 * Called from Phalanx::findBlocked
	 *
	 * @param $content string text to check
	 */
	public static function check($content) {
		global $wgPhalanxShadowingPercentage;
		if (empty($wgPhalanxShadowingPercentage) || !is_numeric($wgPhalanxShadowingPercentage)) {
			return;
		}

		wfProfileIn(__METHOD__);

		if (mt_rand(1, 100) <= $wgPhalanxShadowingPercentage) {
			if (self::$typeName !== null) {
				Wikia::log(__METHOD__, false, self::$typeName, true);

				$service = new PhalanxService();
				$service->check(self::$typeName, $content);
			}
		}

		self::$typeName = null;
		wfProfileOut(__METHOD__);
	}
}
