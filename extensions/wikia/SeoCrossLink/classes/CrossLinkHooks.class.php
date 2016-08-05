<?php

namespace Wikia\SeoCrossLink;

class CrossLinkHooks {
	public static function onOutputPageBeforeHTML( \OutputPage $out, &$text ) {
		$user = $out->getUser();
		$lang = $out->getLanguage();

		if ( $user && $user->isAnon() && $lang && $lang->getCode() === 'en' ) {
			$inserter = new CrossLinkInserter();
			$text = $inserter->insertCrossLinks( $text );
		}

		return true;
	}
}
