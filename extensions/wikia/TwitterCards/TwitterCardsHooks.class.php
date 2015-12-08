<?php

/**
 * Class TwitterCardsHooks
 */
class TwitterCardsHooks {

	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		global $wgTwitterAccount;

		$title = $out->getTitle();
		if ( !( $title instanceof Title ) ) {
			return true;
		}

		$meta['twitter:card'] = 'summary';
		$meta['twitter:site'] = $wgTwitterAccount;

		// add meta tags
		foreach( $meta as $name => $value ) {
			$out->addMeta( $name, $value );
		}

		return true;
	}

}
