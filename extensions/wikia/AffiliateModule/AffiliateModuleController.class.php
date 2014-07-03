<?php

class AffiliateModuleController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * Affiliate Module
	 * @requestParam string location [rail/bottom/bottom-ads/article-title]
	 * @responseParam string title
	 * @responseParam array products - list of products
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		if ( !$this->app->checkSkin( 'oasis' ) ) {
			$this->skipRendering();
			wfProfileOut( __METHOD__ );
			return true;
		}

		$location = $this->request->getVal( 'location', AffiliateModuleHelper::LOCATION_BOTTOM );

		AffiliateModuleHelper::replaceBottomAds( $location, $this->request );

		if ( !AffiliateModuleHelper::canShowModule( $location ) ) {
			$this->skipRendering();
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( AffiliateModuleHelper::canLoadAssets( $location ) ) {
			$this->response->addAsset( 'affiliate_module_css' );
			$this->response->addAsset( 'affiliate_module_js' );
		}

		$type = $this->wg->AffiliateModuleOptions[$location];
		if ( !method_exists( $this, $type ) ) {
			$this->skipRendering();
			wfProfileOut( __METHOD__ );
			return true;
		}

		$this->forward( __CLASS__, $type );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Affiliate Unit
	 * @requestParam string location [rail/bottom/bottom-ads/article-title]
	 * @responseParam string moduleTitle
	 * @responseParam string buttonLabel
	 * @responseParam string className
	 * @responseParam array products - list of products
	 */
	public function affiliateUnit() {
		wfProfileIn( __METHOD__ );

		$location = $this->request->getVal( 'location', AffiliateModuleHelper::LOCATION_BOTTOM );

		$products = [
			[
				'id' => 'B007ZQAKHU',
				'name' => 'The Lord of the Rings: The Motion Picture Trilogy (The Fellowship of the Ring / The Two Towers / The Return of the King Extended Editions) [Blu-ray] (2012)',
				'url' => 'http://www.amazon.com/gp/product/B007ZQAKHU/ref=as_li_tl?ie=UTF8&camp=1789&creative=390957&creativeASIN=B007ZQAKHU&linkCode=as2&tag=lotrwikia-mcb-reg-f-20&linkId=NIQYAQCQESVNRNMN',
				'thumbUrl' => 'http://ecx.images-amazon.com/images/I/51wp1eHVwdL._AA160_.jpg',
				'price' => '$68.99',
				'vendor' => 'amazon',
			],
			[
				'id' => '0345325818',
				'name' => 'The Silmarillion (Pre-Lord of the Rings)',
				'url' => 'http://www.amazon.com/gp/product/0345325818/ref=as_li_tl?ie=UTF8&camp=1789&creative=390957&creativeASIN=0345325818&linkCode=as2&tag=lotrwikia-mcb-reg-f-20&linkId=P6FRCSZGHQ2PIA35',
				'thumbUrl' => 'http://ecx.images-amazon.com/images/I/51tDzXVWy4L._AA160_.jpg',
				'price' => '$5.44',
				'vendor' => 'amazon',
			],
			[
				'id' => '0345538374',
				'name' => 'J.R.R. Tolkien 4-Book Boxed Set: The Hobbit and The Lord of the Rings (Movie Tie-in): The Hobbit, The Fellowship of the Ring, The Two Towers, The Return of the King',
				'url' => 'http://www.amazon.com/gp/product/0345538374/ref=as_li_tl?ie=UTF8&camp=1789&creative=390957&creativeASIN=0345538374&linkCode=as2&tag=lotrwikia-mcb-reg-f-20&linkId=KRY56KEPJ5XYKDIO',
				'thumbUrl' => 'http://ecx.images-amazon.com/images/I/51GJzbM5vTL._AA160_.jpg',
				'price' => '$21.76',
				'vendor' => 'amazon',
			],
		];

		$this->moduleTitle = wfMessage( 'affiliate-module-title' )->escaped();
		$this->products = $products;
		$this->buttonLabel = wfMessage( 'affiliate-module-button-label' )->plain();
		$this->className = ( $location == AffiliateModuleHelper::LOCATION_RAIL ) ? 'module' : '';
		$this->location = $location;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Ad Unit
	 * @requestParam string location [rail/bottom/bottom-ads/article-title]
	 * @responseParam string location [rail/bottom/bottom-ads/article-title]
	 * @responseParam string adClient
	 * @responseParam string adSlot
	 */
	public function adUnit() {
		wfProfileIn( __METHOD__ );

		$this->location = $this->request->getVal( 'location', AffiliateModuleHelper::LOCATION_ARTICLE_TITLE );
		$this->adClient = $this->wg->GoogleAdClient;
		$this->adSlot = '6789179427';

		wfProfileOut( __METHOD__ );
	}

}
