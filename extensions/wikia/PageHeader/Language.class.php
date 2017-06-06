<?php

namespace Wikia\PageHeader;

use \RequestContext;
use \WikiaApp;

class Language {

	public $currentLangName;
	public $languages;
	public $languageUrls;
	private $langCode;
	private $title;

	/**
	 * Language constructor.
	 *
	 * @param WikiaApp $app
	 */
	public function __construct( WikiaApp $app ) {
		$this->langCode = RequestContext::getMain()->getLanguage()->getCode();

		$this->currentLangName = \Language::getLanguageName( $this->langCode );
		$this->languageList = $this->handleLanguages( $app );
	}

	/**
	 * @param WikiaApp $app
	 *
	 * @return array
	 */
	private function handleLanguages( WikiaApp $app ) {
		$this->title = RequestContext::getMain()->getTitle();
		$this->languageUrls = $app->getSkinTemplateObj()->data['language_urls'] ?: [];
		$this->languages = [];

		foreach ( $this->languageUrls as $key => $val ) {
			$this->languages[$key] = [
				'href' => $val['href'],
				'name' => $val['text'],
			];
		}

		ksort( $this->languages );

		return $this->languages;
	}
}
