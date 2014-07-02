<?php

interface WikiGetDataHelper {
	public function getMemcKey($wikiId, $langCode);
	public function getImages($wikiId, $langCode, $wikiRow = null);
	public function getMainImage($wikiId, $langCode, $imageSource = null, &$currentData = null);
}
