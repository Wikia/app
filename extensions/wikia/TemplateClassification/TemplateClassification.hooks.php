<?php

namespace Wikia\TemplateClassification;

class Hooks {

	public static function register() {
		$hooks = new self();
		\Hooks::register( 'QueryPageUseResultsBeforeRecache', [ $hooks, 'onQueryPageUseResultsBeforeRecache' ] );
	}

	public function onQueryPageUseResultsBeforeRecache( $queryCacheType, $results ) {
		if ( $queryCacheType === \UnusedtemplatesPage::UNUSED_TEMPLATES_PAGE_NAME ) {
			if ( $results instanceof \ResultWrapper ) {
				// Mark these results as not-needing classification
			} else {
				// Mark all templates as needing classification
			}
		}
		return true;
	}
}
