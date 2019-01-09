<?php

namespace Wikia\FeedsAndPosts;

class WikiVariables {
	public function get() {
		global $wgServer, $wgDBname, $wgDisableHTTPSDowngrade, $wgEnableHTTPSForAnons;

		$wikiVariables = [
			'basePath' => $wgServer,
			'dbName' => $wgDBname,
			'disableHTTPSDowngrade' => !empty( $wgDisableHTTPSDowngrade ),
			'enableHTTPSForAnons' => !empty( $wgEnableHTTPSForAnons ),
			'enableHTTPSForDomain' => wfHttpsEnabledForURL( $wgServer ),
		];

		return $wikiVariables;
	}
}
