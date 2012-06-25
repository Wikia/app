<?php
/**
 * Hooks handlers for the Weinre web inspector
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WeinreHooks extends WikiaObject {
	private function getHost(){
		$weinre = F::build( 'Weinre' );
		$host = false;

		if ( $weinre->isEnabled() ) {
			$host = $weinre->getRequestedHost();
		}

		return $host;
	}
	public function onSkinAfterBottomScripts( WikiaSkin $sk, &$scripts ) {
		$host = $this->getHost();

		//allow testing from non-owned test environment or production/staging
		if ( !empty( $host ) || !empty( $this->wg->develEnvironment ) ) {
			//this would be filtered on a per-skin basis by AssetManager config
			foreach ( F::build( 'AssetsManager', array(), 'getInstance' )->getURL( 'weinre_js' ) as $s ) {
				$scripts .= "<script src=\"{$s}\"></script>";
			}
		}

		return true;
	}

	public function onWikiaMobileAssetsPackages( Array &$jsHeadPackages, Array &$jsBodyPackages, Array &$scssPackages ) {
		$host = $this->getHost();

		//allow testing from non-owned test environment or production/staging
		if ( !empty( $host ) || !empty( $this->wg->develEnvironment ) ) {
			$jsBodyPackages[] = 'weinre_js';
		}

		return true;
	}
}