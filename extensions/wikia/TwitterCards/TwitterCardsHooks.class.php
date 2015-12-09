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
		$app = F::app();
		if ( $app->wg->TwitterCardsMetaTagsLoaded ) {
			return true;
		}

		$twitterCards = new TwitterCards();
		$meta = $twitterCards->getMeta( $out );
		foreach( $meta as $name => $value ) {
			$out->addMeta( $name, $value );
		}

		$app->wg->TwitterCardsMetaTagsLoaded = true;

		return true;
	}

}
