<?php

namespace Wikia\CreateNewWiki\Tasks;


use Locale;
use WikiFactoryTags;

class SetTags implements Task {

	private $taskContext;

	public function __construct( TaskContext $taskContext ) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
		return TaskResult::createForSuccess();
	}

	public function check() {
		return TaskResult::createForSuccess();
	}

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
