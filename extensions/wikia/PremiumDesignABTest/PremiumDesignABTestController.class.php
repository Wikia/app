<?php

class PremiumDesignABTestController extends WikiaController {
	private function setVariant() {
		global $wgPremiumDesignABTestVariants;

		$articleId = $this->wg->Title->getArticleID();

		if ( array_key_exists( $articleId, $wgPremiumDesignABTestVariants ) ) {
			$this->setVal( 'variant', $wgPremiumDesignABTestVariants[$articleId] );
		} else {
			$this->setVal( 'variant', null );
		}
	}

	public function header() {
		$this->setVariant();
	}

	public function A_header() {
		$this->headerModuleParams = [ 'showSearchBox' => false ];
	}

	public function B_header() {
		$this->headerModuleParams = [ 'showSearchBox' => false ];
	}

	public function pageheader() {
		$this->setVariant();
	}

	public function A_pageheader() {
		global $wgExtensionsPath;
		$this->videoPlayButtonSrc = $wgExtensionsPath . '/wikia/PremiumDesignABTest/images/play-button.png';
	}

	public function B_pageheader() {

	}

	public function C_pageheader() {
		$this->headerModuleParams = [ 'showSearchBox' => false ];
	}

	public function D_pageheader() {
		$this->headerModuleParams = [ 'showSearchBox' => false ];
	}

	public function rightrail() {
		$this->setVariant();
	}

	public function C_rightrail() {
		// number of pages on this wiki
		$this->tallyMsg = wfMessage( 'oasis-total-articles-mainpage', SiteStats::articles() )->parse();
	}

	public function D_rightrail() {
		// number of pages on this wiki
		$this->tallyMsg = wfMessage( 'oasis-total-articles-mainpage', SiteStats::articles() )->parse();
	}

	public function video() {
		global $wgExtensionsPath;
		$this->videoPlayButtonSrc = $wgExtensionsPath . '/wikia/PremiumDesignABTest/images/play-button.png';
	}
}
