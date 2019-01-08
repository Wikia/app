<?php

namespace Wikia\FeedsAndPosts;

class WikiVariables {
	public function get() {
		$cacheTTL = 60; // a minute

		return \WikiaDataAccess::cache(
			wfMemcKey( 'feeds-wiki-variables' ),
			$cacheTTL,
			function () {
				global $wgServer, $wgDBname, $wgDisableHTTPSDowngrade, $wgEnableHTTPSForAnons;

				$wikiVariables = [
					'dbName' => $wgDBname,
					'disableHTTPSDowngrade' => !empty( $wgDisableHTTPSDowngrade ),
					'enableHTTPSForAnons' => !empty( $wgEnableHTTPSForAnons ),
					'enableHTTPSForDomain' => wfHttpsEnabledForURL( $wgServer ),
				];

				return $wikiVariables;
			}
		);
	}

}
