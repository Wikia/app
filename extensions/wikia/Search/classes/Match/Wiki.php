<?php
/**
 * Class definition for \Wikia\Search\Match\Wiki
 */
namespace Wikia\Search\Match;
use \Wikia\Search\Result as Result;
use \WikiaHomePageHelper as HomePageHelper;

class Wiki extends AbstractMatch
{
	/**
	 * @see \Wikia\Search\Match\AbstractMatch::createResult()
	 * @return \Wikia\Search\Result;
	 */
	public function createResult()
	{
		return $this->getResultFromPromoData() ?: $this->getResultFromMainPage();
	}
	
	/**
	 * Extracts promo data and turns it into a Wikia\Search\Result
	 * Returns null if no promo data
	 * @return \Wikia\Search\Result|NULL
	 */
	public function getResultFromPromoData() {
		$fields = array();
		$helper = new HomePageHelper;
		$data = $helper->getWikiInfoForVisualization( $this->id, $this->interface->getLanguageCode() );
		
		if ( !empty( $data ) ) {
			$parsed = parse_url($data['url']);
			$fields['wid'] = $this->id;
			$fields['title'] = !empty( $data['name'] ) ? $data['name'] : $this->interface->getGlobalForWiki( 'wgSitename', $this->id );
			$fields[\WikiaSearch::field( 'title' )] = $data['name'];
			$fields['url'] = sprintf('%s://%s%s', $parsed['scheme'], $parsed['host'], $parsed['path']);
			$fields['isWikiMatch'] = true;
			$fields['thumbnail'] = array_shift( empty( $data['wiki_images'] ) ? array() : $data['wiki_images'] );

			$result = new Result( $fields );
			
			$text = $this->preprocessText( $data['description'] ?: $this->interface->getMainPageTextForWikiId( $this->id ) );
			$result->setText( $text, true );
			
			return $result;
		}
		return null;
	}
	
	/**
	 * Uses MediaWikiInterface to access necessary data from main page as a result.
	 * @return \Wikia\Search\Result
	 */
	public function getResultFromMainPage() {
		
		$fields = array(
				'wid' => $this->id,
				'title' => $this->interface->getGlobalForWiki( 'wgSitename', $this->id ),
				'isWikiMatch' => true,
				\WikiaSearch::field( 'title' ) => $this->interface->getGlobalForWiki( 'wgSitename', $this->id ),
				$fields['url'] = $this->interface->getMainPageUrlForWikiId( $this->id )
				);
		$result = new Result( $fields );
		
		
		
		$result->setText( $this->preprocessText( $this->getMainPageTextForWikiId( $this->id ) ) );
		
		return $result;
	}
	
	/**
	 * Allows us to mutate the description based on skin
	 * @param string $text
	 * @return string
	 */
	protected function preprocessText( $text ) {
		$text = \strip_tags( \html_entity_decode( $text, ENT_COMPAT, 'UTF-8' ) );
		$snippetLength = $this->interface->isSkinMobile() ? 100 : 250; 
		$match = array();
		if ( preg_match( "/^.{1,{$snippetLength}}\b/s", $text, $match ) ) {
			$text = $match[0];
		}
		return $text;
	}
	
}