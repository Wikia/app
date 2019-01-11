<?php

namespace Wikia\FeedsAndPosts;

class WikiVariables {
	public function get() {
		global $wgServer, $wgDBname;

		$wikiVariables = [
			'basePath' => $wgServer,
			'dbName' => $wgDBname,
		];

		\Hooks::run( 'MercuryWikiVariables', [ &$wikiVariables ] );

		return $wikiVariables;
	}
}
