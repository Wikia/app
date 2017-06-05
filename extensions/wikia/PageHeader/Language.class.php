<?php
/**
 * Created by PhpStorm.
 * User: jakubjastrzebski
 * Date: 05/06/2017
 * Time: 10:36
 */

namespace Wikia\PageHeader;

use \WikiaApp;

class Language {

	public $currentLangName;
	public $languages;
	public $language_urls;

	public function __construct( WikiaApp $app ) {
		global $wgContLanguageCode, $wgTitle;

		$this->currentLangName = \Language::getLanguageName( $wgContLanguageCode );
		$this->languageList = $this->handleLanguages( $app );

		//$request_language_urls = $this->request->getVal( 'request_language_urls' );
		//if ( !empty( $request_language_urls ) ) {
		//	$language_urls = $request_language_urls;
		//}
	}

	private function handleLanguages( WikiaApp $app ) {
		global $wgTitle, $wgContLanguageCode;

		$this->language_urls = $app->getSkinTemplateObj()
			? $app->getSkinTemplateObj()->data['language_urls']
			: [];

		$this->language_urls["interwiki-{$wgContLanguageCode}"] = [
			'href' => $wgTitle->getFullURL(),
			'text' => $this->currentLangName,
			'class' => "interwiki-{$wgContLanguageCode}",
		];

		$this->languages = [];
		foreach ( $this->language_urls as $val ) {
			$this->languages[$val["class"]] = [
				'href' => $val['href'],
				'name' => $val['text'],
				'class' => $val['class'],
			];
		}

		ksort( $this->languages );
		return $this->languages;
	}
}
