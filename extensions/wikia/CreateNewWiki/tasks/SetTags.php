<?php

namespace Wikia\CreateNewWiki\Tasks;

use Locale;
use WikiFactoryTags;

class SetTags extends Task {

	public function run() {
		$tags = new WikiFactoryTags( $this->taskContext->getCityId() );
		if ( $this->taskContext->getLanguage() !== 'en' ) {
			$langTag = Locale::getPrimaryLanguage( $this->taskContext->getLanguage() );
			if ( !empty($langTag) ) {
				$tags->addTagsByName( $langTag );
			}
		}

		return TaskResult::createForSuccess();
	}
}
