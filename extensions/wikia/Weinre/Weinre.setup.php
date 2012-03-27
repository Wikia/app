<?php
/**
 * Weinre web inspector
 * 
 * @see http://phonegap.github.com/weinre/
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$app = F::app();

$app->wg->append(
	'ExtensionCredits',
	array(
		'name' => 'Weinre web inspector',
		'description' => 'Adds support for inspecting the browser via Weinre on mobile devices',
		'version' => '1.0',
		'author' => array(
			'Federico "Lox" Lucignano <federico(at)wikia-inc.com>',
			'Jakub Olek <jakubolek(at)wikia-inc.com>'
		)
	),
	'other'
);

$app->registerHook( 'SkinAfterBottomScripts', 'WeinreHooks', 'onSkinAfterBottomScripts' );

class WeinreHooks extends WikiaObject {
	public function onSkinAfterBottomScripts( WikiaSkin $sk, &$scripts ) {
		$host = $this->wg->request->getVal( 'weinrehost' );

		//allow testing from non-owned test environment or production/staging
		if ( !empty( $host ) || !empty( $this->wg->develEnvironment ) ) {
			//this would be filtered on a per-skin basis by AssetManager config
			foreach ( F::build( 'AssetsManager', array(), 'getInstance' )->getURL( 'weinre_js' ) as $s ) {
				$scripts .= "<script src=\"{$s}\"></script>";
			}
		}

		return true;
	}
}