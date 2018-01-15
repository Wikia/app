<?php

namespace Wikia\PageHeader;

use \WikiaApp;

class Languages {

	public $currentLangName;
	public $languageList;

	private $title;

	/**
	 * Language constructor.
	 *
	 * @param WikiaApp $app
	 */
	public function __construct( WikiaApp $app ) {
		$this->title = \RequestContext::getMain()->getTitle();
		$this->currentLangName = \Language::getLanguageName( $this->title->getPageLanguage()->getCode() );
		$this->languageList = $this->handleLanguages( $app );
	}

	/**
	 * @param WikiaApp $app
	 *
	 * @return array
	 */
	private function handleLanguages( WikiaApp $app ): array {
		$languageUrls = $app->getSkinTemplateObj()->data['language_urls'] ?: [];
		$languages = [];

		foreach ( $languageUrls as $lang) {
			$languages[$lang['lang']] = [
				'href' => $lang['href'],
				'name' => $lang['text'],
			];
		}

		ksort( $languages );

		return $languages;
	}

	public function shouldDisplay(): bool {
		return count( $this->languageList ) > 0;
	}
}
