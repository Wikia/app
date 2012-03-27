<?php
/**
 * Hooks handlers for the Weinre web inspector
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WeinreHooks extends WikiaObject {
	public function onSkinAfterBottomScripts( WikiaSkin $sk, &$scripts ) {
		$weinre = F::build( 'Weinre' );

		if ( $weinre->isEnabled() ) {
			$host = $weinre->getRequestedHost();

			//allow testing from non-owned test environment or production/staging
			if ( !empty( $host ) || !empty( $this->wg->develEnvironment ) ) {
				//this would be filtered on a per-skin basis by AssetManager config
				foreach ( F::build( 'AssetsManager', array(), 'getInstance' )->getURL( 'weinre_js' ) as $s ) {
					$scripts .= "<script src=\"{$s}\"></script>";
				}
			}
		}

		return true;
	}
}