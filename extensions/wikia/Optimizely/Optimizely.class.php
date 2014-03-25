<?php
/**
 * Optimizely
 *
 * @author Damian Jóźwiak
 *
 */
class Optimizely {
	public static function onOasisSkinAssetGroupsBlocking(&$jsAssetGroups) {
		$jsAssetGroups[] = 'optimizely';
		return true;
	}
}
