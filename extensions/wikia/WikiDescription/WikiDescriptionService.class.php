<?php

namespace WikiDescription;

class WikiDescriptionService {
	const WIKI_DESCRIPTION_SITE_META = 'wiki-description-site-meta';

	public function getDescription( string $site_name ): string {
		return wfMessage( self::WIKI_DESCRIPTION_SITE_META, [ $site_name ] );
	}
}
