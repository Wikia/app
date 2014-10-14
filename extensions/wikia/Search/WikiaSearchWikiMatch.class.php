<?php

class WikiaSearchWikiMatch extends WikiDataSource
{
	/**
	 * The main page, which we use for text snippets and URLs
	 * @var Title
	 */
	protected $mainPageTitle;
	
	/**
	 * Cached value for sitenae
	 * @var string
	 */
	protected $sitename;
	
	/**
	 * Abstract how we get the mock result into two different functions
	 * @return WikiaSearchResult
	 */
	public function getResult() {
		return $this->getResultFromPromoData() ?: $this->getResultFromMainPage();
	}
	
	/**
	 * Extracts promo data and turns it into a WikiaSearchResult
	 * Returns null if no promo data
	 * @return WikiaSearchResult|NULL
	 */
	public function getResultFromPromoData() {
		$fields = array();
		$helper = new WikiaHomePageHelper; 
		$data = $helper->getWikiInfoForVisualization( $this->id, $this->wg->ContLang->getCode() );
		
		if ( !empty( $data ) ) {
			$parsed = parse_url($data['url']);
			$fields['wid'] = $this->id;
			$fields['title'] = !empty( $data['name'] ) ? $data['name'] : $this->getSitenameFromWf();
			$fields[WikiaSearch::field( 'title' )] = $data['name'];
			$fields['url'] = sprintf('%s://%s%s', $parsed['scheme'], $parsed['host'], $parsed['path']);
			$fields['isWikiMatch'] = true;
			
			$result = new WikiaSearchResult( $fields );

			$text = $this->preprocessText( $data['description'] ?: $this->getTextFromMainPage() );
			
			$result->setText( $text, true );
			return $result;
		}
		return null;
	}
	
	public function getResultFromMainPage() {
		
		$fields = array(
				'wid' => $this->id,
				'title' => $this->getSitenameFromWf(),
				'isWikiMatch' => true,
				WikiaSearch::field( 'title' ) => $this->getSitenameFromWf(),
				$fields['url'] = $this->getUrlFromMainPage(),
				);
		$result = new WikiaSearchResult( $fields );
		
		
		$result->setText( $this->preprocessText( $this->getTextFromMainPage() ) );
		
		return $result;
	}
	
	/**
	 * Allows us to easily grab sitename from wikifactory
	 * @return mixed
	 */
	protected function getSitenameFromWf() {
		if ( $this->sitename === null ) {
			$this->sitename = unserialize( WikiFactory::getVarByName( 'wgSitename', $this->id )->cv_value );
		}
		return $this->sitename;
	}
	
	/**
	 * Mainpage access
	 * @return Title
	 */
	protected function getMainPageTitle() {
		if (! isset( $this->mainPageTitle ) ) {
			$response = \ApiService::foreignCall(
					$this->getDbName(), 
					array(
							'action'      => 'query',
							'meta'        => 'allmessages',
							'ammessages'  => 'mainpage',
							'amlang'      => unserialize(WikiFactory::getVarByName( 'wgLanguageCode', $this->id )->cv_value)
							) 
					);
			
		    $this->mainPageTitle = GlobalTitle::newFromText( $response['query']['allmessages'][0]['*'], NS_MAIN, $this->id );
		}
		return $this->mainPageTitle;
	}

	/**
	 * Provides a text snippet from article service
	 * @return Ambigous <string, unknown>
	 */
	protected function getTextFromMainPage() {
		$params = array(
				'controller' => 'ArticlesApiController', 
				'method' => 'getDetails', 
				'titles' => $this->getMainPageTitle()->getDbKey()
				);
		$response = ApiService::foreignCall( $this->getDbName(), $params, ApiService::WIKIA );
		$item = array_shift( $response['items'] );
		return $item['abstract'];
	}
	
	/**
	 * Allows us to mutate the description based on skin
	 * This doesn't exactly belong here as-is because we should be ignorant of user, skin, etc.
	 * @param string $text
	 * @return string
	 */
	protected function preprocessText( $text ) {
		$text = strip_tags( html_entity_decode( $text, ENT_COMPAT, 'UTF-8' ) );

		$snippetLength = $this->wg->User->getSkin() instanceof SkinWikiaMobile ? 100 : 250; 
		
		$match = array();
		if ( preg_match( "/^.{1,{$snippetLength}}\b/s", $text, $match ) ) {
			$text = $match[0];
		}
		
		return $text;
	}
	
	/**
	 * Provides URL from main page
	 * @return string
	 */
	protected function getUrlFromMainPage() {
		return $this->getMainPageTitle()->getFullUrl();
	}
	
}