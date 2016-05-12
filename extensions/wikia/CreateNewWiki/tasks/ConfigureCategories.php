<?php

namespace Wikia\CreateNewWiki\Tasks;

use WikiFactoryHub;

class ConfigureCategories implements Task {

	private $taskContext;

	public function __construct(TaskContext $taskContext) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
		$categories = $this->taskContext->getCategories();
		$vertical = $this->taskContext->getVertical();

		if ( $vertical === WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES) {
			array_unshift($categories, WikiFactoryHub::CATEGORY_ID_GAMING);
		}

		if ( in_array( $vertical,
			[
				WikiFactoryHub::VERTICAL_ID_TV,
				WikiFactoryHub::VERTICAL_ID_BOOKS,
				WikiFactoryHub::VERTICAL_ID_COMICS,
				WikiFactoryHub::CATEGORY_ID_MUSIC,
				WikiFactoryHub::CATEGORY_ID_MOVIES
			]
		) ) {
			array_unshift($categories, WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT);
		}

		if ( $vertical === WikiFactoryHub::VERTICAL_ID_LIFESTYLE ) {
			array_unshift($categories, WikiFactoryHub::CATEGORY_ID_LIFESTYLE);
		}

		$this->taskContext->setCategories( $categories );
	}

	public function check() {
	}

	public function run() {
		$categories = $this->taskContext->getCategories();
		$vertical = $this->taskContext->getVertical();
		$oHub = WikiFactoryHub::getInstance();

		$oHub->setVertical( $this->taskContext->getCityId(), $vertical, "CW Setup" );
		wfDebugLog( "createwiki", __METHOD__ . ": Wiki added to the vertical: {$vertical} \n", true );

		foreach($categories as $category) {
			$oHub->addCategory( $this->taskContext->getCityId(), $category );
			wfDebugLog( "createwiki", __METHOD__ . ": Wiki added to the category: {$category} \n", true );
		}
	}
}
