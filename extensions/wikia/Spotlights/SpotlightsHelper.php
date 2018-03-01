<?php

class SpotlightsHelper {
	public static function isEnglishWiki() {
		global $wgContLanguageCode, $wgLanguageCode;

		return $wgContLanguageCode == "en" || $wgLanguageCode == "en";
	}
}
