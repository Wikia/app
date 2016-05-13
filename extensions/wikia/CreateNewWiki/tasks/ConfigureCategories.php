<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;
use WikiFactoryHub;

class ConfigureCategories implements Task {
	use Loggable;

	private $taskContext;

	public function __construct( TaskContext $taskContext ) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
		$categories = $this->taskContext->getCategories();
		$vertical = $this->taskContext->getVertical();

		$this->taskContext->setCategories( $this->prepareCategories( $vertical, $categories) );
	}

	public function check() {
		return TaskResult::createForSuccess();
	}

	public function run() {
		$cityId = $this->taskContext->getCityId();
		$wikiFactoryInstance = WikiFactoryHub::getInstance();

		$this->setVertical($this->taskContext->getVertical(), $cityId, $wikiFactoryInstance);
		$this->setCategories($this->taskContext->getCategories(), $cityId, $wikiFactoryInstance);

		return TaskResult::createForSuccess();
	}

	public function prepareCategories($vertical, $categories) {
		if ( $vertical === WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES ) {
			array_unshift( $categories, WikiFactoryHub::CATEGORY_ID_GAMING );
		}

		if ( in_array( $vertical,
			[
				WikiFactoryHub::VERTICAL_ID_TV,
				WikiFactoryHub::VERTICAL_ID_BOOKS,
				WikiFactoryHub::VERTICAL_ID_COMICS,
				WikiFactoryHub::VERTICAL_ID_MUSIC,
				WikiFactoryHub::VERTICAL_ID_MOVIES
			]
		) ) {
			array_unshift( $categories, WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT );
		}

		if ( $vertical === WikiFactoryHub::VERTICAL_ID_LIFESTYLE ) {
			array_unshift( $categories, WikiFactoryHub::CATEGORY_ID_LIFESTYLE );
		}

		return $categories;
	}

	public function setVertical($vertical, $cityId, WikiFactoryHub $wikiFactoryHubInstance) {
		$wikiFactoryHubInstance->setVertical( $cityId, $vertical, "CW Setup" );
		$this->debug( ":", implode( ["CreateWiki", __CLASS__, "Wiki added to the vertical: {$vertical}"] ) );
	}

	public function setCategories($categories, $cityId, WikiFactoryHub $wikiFactoryHubInstance) {
		foreach ( $categories as $category ) {
			$wikiFactoryHubInstance->addCategory( $cityId, $category );
			$this->debug( ":", implode( ["CreateWiki", __CLASS__, "Wiki added to the category: {$category}"] ) );
		}
	}
}
