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

			wfDebug(__METHOD__ . ": type #{$blockType}\n");
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
	public static function check($content, $expected_id) {
		global $wgPhalanxShadowingPercentage;
		if (empty($wgPhalanxShadowingPercentage) || !is_numeric($wgPhalanxShadowingPercentage)) {
			return;
		}

		if (mt_rand(1, 100) <= $wgPhalanxShadowingPercentage) {
			wfProfileIn(__METHOD__);
			if (self::$typeName !== null) {
				wfDebug(__METHOD__ . '::' . self::$typeName ."\n");
				
				$service = new PhalanxService();
				$service->matchShadow(self::$typeName, $content, $expected_id);
			}
			wfProfileOut(__METHOD__);
		}

		self::$typeName = null;
	
	}
}
