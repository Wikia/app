<?php

class AdTargeting {

	const ADULTS_ONLY = 'ao';
	const EARLY_CHILDHOOD = 'ec';
	const EVERYONE = 'everyone';
	const EVERYONE_10_PLUS = 'ec10';
	const MATURE = 'mature';
	const RATING_PENDING = 'rp';
	const TEEN = 'teen';

	static private $esrbRating = [
		self::EARLY_CHILDHOOD => 1,
		self::EVERYONE => 2,
		self::EVERYONE_10_PLUS => 3,
		self::TEEN => 4,
		self::MATURE => 5,
		self::ADULTS_ONLY => 6,
		self::RATING_PENDING => 7
	];

	static public function getEsrbRating() {
		global $wgWikiDirectedAtChildrenByFounder, $wgWikiDirectedAtChildrenByStaff;

		$directedAtChildren = $wgWikiDirectedAtChildrenByFounder || $wgWikiDirectedAtChildrenByStaff;
		$rating = $directedAtChildren ? self::EARLY_CHILDHOOD : self::TEEN;
		$dartRating = self::getEsrbRatingFromDartKeyValues();

		return $dartRating !== null ? $dartRating : $rating;
	}

	static private function getEsrbRatingFromDartKeyValues() {
		global $wgDartCustomKeyValues;

		$dartRating = null;
		$pairs = explode(';', $wgDartCustomKeyValues);

		foreach ($pairs as $pair) {
			list($key, $value) = explode('=', $pair);
			if ($key === 'esrb' && ($dartRating === null || self::$esrbRating[$value] > self::$esrbRating[$dartRating])) {
				$dartRating = $value;
			}
		}

		return $dartRating;
	}

}
