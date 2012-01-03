<?php

class MobileContentParser {
	public static function onParserFirstCallInit( &$parser ) {
		$parser->setHook( 'mobile', 'MobileContentParser::displayContent' );
		$parser->setHook( 'nomobile', 'MobileContentParser::hideContent' );
		return true;
	}

	public static function displayContent( $contents, $attributes, $parser ) {
		$app = F::build('App');
		$skin = $app->getGlobal( 'wgUser' )->getSkin();
		$wgMobileSkins = $app->getGlobal( 'wgMobileSkins' );

		if ( in_array( $skin->getSkinName(), $wgMobileSkins ) ) {
			return $app->wg->Parser->recursiveTagParse( $contents );
		} else {
			return '';
		}
	}

	public static function hideContent( $contents, $attributes, $parser ) {
		$app = F::build('App');
		$skin = $app->getGlobal( 'wgUser' )->getSkin();
		$wgMobileSkins = $app->getGlobal( 'wgMobileSkins' );

		if ( in_array( $skin->getSkinName(), $wgMobileSkins ) ) {
			return '';
		} else {
			return $app->wg->Parser->recursiveTagParse( $contents );
		}
	}
}
