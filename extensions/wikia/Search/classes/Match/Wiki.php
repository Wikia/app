<?php
/**
 * Class definition for \Wikia\Search\Match\Wiki
 */
namespace Wikia\Search\Match;
use \Wikia\Search\Result as Result;
use \Wikia\Search\Utilities;

class Wiki extends AbstractMatch
{
	/**
	 * Creates result from  main page. We used to use promo data, but we're putting that kind of information one level up.
	 * @see \Wikia\Search\Match\AbstractMatch::createResult()
	 * @return \Wikia\Search\Result;
	 */
	public function createResult()
	{
		$fields = array(
				'wid' => $this->id,
				'title' => $this->interface->getGlobalForWiki( 'wgSitename', $this->id ),
				'isWikiMatch' => true,
				'url' => $this->interface->getMainPageUrlForWikiId( $this->id )
				);
		$result = new Result( $fields );
		
		$result->setText( $this->preprocessText( $this->interface->getMainPageTextForWikiId( $this->id ) ) );
		
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