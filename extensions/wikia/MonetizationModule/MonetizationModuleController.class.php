<?php

class MonetizationModuleController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * Monetization Module
	 * @requestParam string geo
	 * @responseParam array data - list of modules
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		if ( !MonetizationModuleHelper::canShowModule() ) {
			$this->data = '';
			wfProfileOut( __METHOD__ );
			return true;
		}

		$this->response->addAsset( 'monetization_module_css' );

		$params = [
			's_id' => $this->wg->CityId,
			'geo' => MonetizationModuleHelper::getCountryCode( $this->request ),
		];
		$this->data = MonetizationModuleHelper::getMonetizationUnits( $params );

		// set cache control to 1 hour
		$this->response->setCacheValidity( MonetizationModuleHelper::CACHE_TTL );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Ecommerce Unit
	 * @requestParam string location [rail/bottom/bottom-ads/article-title]
	 * @responseParam string moduleTitle
	 * @responseParam string buttonLabel
	 * @responseParam string className
	 * @responseParam array products - list of products
	 */
	public function ecommerce() {
		wfProfileIn( __METHOD__ );

		$location = $this->request->getVal( 'location', MonetizationModuleHelper::LOCATION_BOTTOM );

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

		$this->moduleTitle = wfMessage( 'monetization-module-title' )->escaped();
		$this->products = $products;
		$this->buttonLabel = wfMessage( 'monetization-module-button-label' )->plain();
		$this->className = ( $location == MonetizationModuleHelper::LOCATION_RAIL ) ? 'module' : '';
		$this->type = 'ecommerce';
		$this->position = $location;

		wfProfileOut( __METHOD__ );
	}

}
