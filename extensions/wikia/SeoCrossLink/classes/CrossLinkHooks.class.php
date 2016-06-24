<?php

namespace Wikia\SeoCrossLink;

class CrossLinkHooks {
	public static function onOutputPageBeforeHTML( \OutputPage $out, &$text ) {
		$user = $out->getUser();
		$lang = $out->getLanguage();
		$title = $out->getTitle();

		if ( $user && $user->isAnon() && $lang && $lang->getCode() === 'en'
			&& $title && $title->getNamespace() === NS_MAIN
		) {
			$inserter = new CrossLinkInserter();
			$text = $inserter->insertCrossLinks( $text );
		}

		return true;
	}
}
