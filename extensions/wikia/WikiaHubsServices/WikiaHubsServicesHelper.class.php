<?php

class WikiaHubsServicesHelper
{
	const HUBS_IMAGES_MEMC_KEY_VER = '1.03';
	const HUBS_IMAGES_MEMC_KEY_PREFIX = 'hubv2images';

	static public function getWikiaHomepageHubsMemcacheKey($lang) {
		return F::app()->wf->SharedMemcKey(
			'wikiahomepage',
			self::HUBS_IMAGES_MEMC_KEY_PREFIX,
			$lang,
			self::HUBS_IMAGES_MEMC_KEY_VER
		);
	}
}
