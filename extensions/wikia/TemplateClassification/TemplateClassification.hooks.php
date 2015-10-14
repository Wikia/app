<?php

namespace Wikia\TemplateClassification;

use Wikia\TemplateClassification\UnusedTemplates\Handler;

class Hooks {

	public static function register() {
		$hooks = new self();
		\Hooks::register( 'QueryPageUseResultsBeforeRecache', [ $hooks, 'onQueryPageUseResultsBeforeRecache' ] );
	}

	public function onQueryPageUseResultsBeforeRecache( \QueryPage $queryPage, $results ) {
		if ( $queryPage->getName() === \UnusedtemplatesPage::UNUSED_TEMPLATES_PAGE_NAME ) {
			$handler = $this->getUnusedTemplatesHandler();
			if ( $results instanceof \ResultWrapper ) {
				$handler->markAsUnusedFromResults( $results );
			} else {
				$handler->markAllAsUsed();
			}
		}
		return true;
	}

	/**
	 * @return Handler
	 */
	protected function getUnusedTemplatesHandler() {
		return new Handler();
	}
}
