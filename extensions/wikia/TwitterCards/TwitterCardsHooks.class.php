<?php

/**
 * Class TwitterCardsHooks
 */
class TwitterCardsHooks {

	/**
	 * Hook: add meta tags for Twitter Cards
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return bool
	 */
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		$twitterCards = new TwitterCards();
		$meta = $twitterCards->getMeta( $out );
		foreach( $meta as $name => $value ) {
			$out->addMeta( $name, $value );
		}

		return true;
	}

}
