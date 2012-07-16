<?php

interface WikiGetDataHelper {
	public function getMemcKey($wikiId, $langCode);
	public function getImages($wikiId, $langCode, $wikiRow);
	public function getMainImage($wikiId, $langCode, $imageSource, &$currentData);
}
