<?php

abstract class WikiDataGetter {
	public abstract function getWikiData($wikiId, $langCode);

	protected function sanitizeWikiData($wikiData) {
		foreach (array('name', 'headline', 'description', 'flags') as $key) {
			if (empty($wikiData[$key])) {
				$wikiData[$key] = null;
			}
		}
		return $wikiData;
	}
}
