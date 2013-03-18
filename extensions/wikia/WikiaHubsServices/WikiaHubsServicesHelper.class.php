<?php

class WikiaHubsServicesHelper
{
	const HUBSV2_IMAGES_MEMC_KEY_VER = '1.03';
	const HUBSV2_IMAGES_MEMC_KEY_PREFIX = 'hubv2images';

	static public function getWikiaHomepageHubsMemcacheKey($lang) {
		return F::app()->wf->SharedMemcKey(
			'wikiahomepage',
			self::HUBSV2_IMAGES_MEMC_KEY_PREFIX,
			$lang,
			self::HUBSV2_IMAGES_MEMC_KEY_VER
		);
	}
}
