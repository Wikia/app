<?php

namespace WikiDescription;

class WikiDescriptionService {
	const WIKI_DESCRIPTION_SITE_META = 'wiki-description-site-meta';

	public static function getDescription( string $siteName ): string {
		return wfMessage( self::WIKI_DESCRIPTION_SITE_META, [ $siteName ] );
	}
}
