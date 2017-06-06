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

		$this->languageUrls = $app->getSkinTemplateObj()
			? $app->getSkinTemplateObj()->data['language_urls']
			: [];

		$this->languageUrls["interwiki-{$this->langCode}"] = [
			'href' => $this->title->getFullURL(),
			'text' => $this->currentLangName,
			'class' => "interwiki-{$this->langCode}",
		];

		$this->languages = [];
		foreach ( $this->languageUrls as $val ) {
			$this->languages[$val["class"]] = [
				'href' => $val['href'],
				'name' => $val['text'],
				'class' => $val['class'],
			];
		}

		unset( $this->languages["interwiki-{$this->langCode}"] );
		ksort( $this->languages );

		return $this->languages;
	}
}
