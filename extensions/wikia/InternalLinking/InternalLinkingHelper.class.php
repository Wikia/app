<?php

/**
 * Class InternalLinkingHelper
 */
class InternalLinkingHelper extends WikiaModel {

	public function getRelatedLanguages() {
		if ( empty( $this->wg->EnableLillyExt ) ) {
			return [];
		}

		$lilly = new Lilly();
		$title = $this->wg->title;
		$languages = $lilly->getCluster( $title->getFullURL() );
		$pageLang = $title->getPageLanguage()->getCode();
		unset( $languages[$pageLang] );

		return $languages;
	}

	public function getRelatedWikis() {
		return [];
	}

}
