<?php

namespace Wikia\FeedsAndPosts;

class WikiVariables {
	public function get() {
		$cacheTTL = 60; // a minute

		return \WikiaDataAccess::cache(
			wfMemcKey( 'feeds-wiki-variables' ),
			$cacheTTL,
			function () {
				global $wgDBname, $wgServer, $wgDisableHTTPSDowngrade, $wgEnableHTTPSForAnons;

				$wikiVariables = [
					'basePath' => $wgServer,
					'dbName' => $wgDBname,
					'disableHTTPSDowngrade' => $wgDisableHTTPSDowngrade,
					'enableHTTPSForAnons' => $wgEnableHTTPSForAnons,
				];

				return $wikiVariables;
			}
		);
	}

}
